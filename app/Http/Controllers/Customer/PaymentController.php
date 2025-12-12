<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\BillplzService;
use App\Http\Requests\BillplzCallbackRequest;
use App\Http\Requests\BillplzReturnRequest;

class PaymentController extends Controller
{
    protected $billplz;

    public function __construct(BillplzService $billplz)
    {
        // Auth middleware except for callback (webhook) and return (redirect from Billplz)
        $this->middleware('auth')->except(['callback', 'return']);
        $this->billplz = $billplz;
    }

    /**
     * Initiate payment for a booking
     *
     * @param Request $request
     * @param int $bookingId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function initiatePayment(Request $request, $bookingId)
    {
        try {
            // Find booking
            $booking = Booking::where('id', $bookingId)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Check if booking is already paid
            if ($booking->isPaid()) {
                return redirect()
                    ->route('customer.bookings.show', $booking->id)
                    ->with('info', 'This booking has already been paid.');
            }

            // Get or create payment record
            $payment = $booking->getOrCreatePayment('billplz');

            // Check if payment is already processing with a valid URL
            if ($payment->isProcessing() && $payment->bill_url) {
                return redirect($payment->bill_url);
            }

            // Mark as processing
            $payment->markAsProcessing();

            // Create bill in Billplz
            $result = $this->billplz->createBill($booking, $payment);

            if ($result['success']) {
                // Redirect to Billplz payment page
                return redirect($result['url']);
            }

            // If failed, mark as failed and show error
            $payment->markAsFailed('Failed to create payment bill');

            return redirect()
                ->route('customer.bookings.show', $booking->id)
                ->with('error', 'Failed to initiate payment. Please try again.');

        } catch (\Exception $e) {
            Log::error('Payment initiation failed', [
                'booking_id' => $bookingId,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('customer.bookings')
                ->with('error', 'An error occurred while initiating payment.');
        }
    }

    /**
     * Handle Billplz callback (webhook)
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function callback(BillplzCallbackRequest $request)
    {
        try {
            // Validated callback data
            $callbackData = $request->validated();

            Log::info('Billplz callback received', [
                'bill_id' => $callbackData['id'] ?? null,
                'paid' => $callbackData['paid'] ?? null,
            ]);

            // Verify X Signature (mandatory)
            $dataToVerify = $callbackData;
            unset($dataToVerify['x_signature']);

            if (!$this->billplz->verifyXSignature($dataToVerify, $callbackData['x_signature'])) {
                Log::warning('Billplz callback: Invalid X Signature', [
                    'bill_id' => $callbackData['id'] ?? null,
                ]);

                return response('Invalid signature', 403);
            }

            // Process callback
            $result = $this->billplz->processCallback($callbackData);

            if ($result['success']) {
                return response('OK', 200);
            }

            return response($result['message'] ?? 'Processing failed', $result['status_code'] ?? 422);

        } catch (\Exception $e) {
            Log::error('Billplz callback processing failed', [
                'error' => $e->getMessage(),
                'bill_id' => $request->input('id'),
            ]);

            return response('Error', 500);
        }
    }

    /**
     * Handle payment return (redirect after payment)
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function return(BillplzReturnRequest $request)
    {
        try {
            $billplzData = $request->validated();

            $billplzBillId = $billplzData['id'];
            $paid = $billplzData['paid'];
            $xSignature = $billplzData['x_signature'];
            $paidAmountCents = isset($billplzData['paid_amount'])
                ? (int) $billplzData['paid_amount']
                : (int) $billplzData['amount'];

            Log::info('Billplz return received', [
                'bill_id' => $billplzBillId,
                'paid' => $paid,
            ]);

            // Find payment by bill ID
            $payment = Payment::where('bill_id', $billplzBillId)->first();

            if (!$payment) {
                return redirect()
                    ->route('customer.bookings')
                    ->with('error', 'Payment not found.');
            }

            $booking = $payment->booking;

            // Verify X Signature
            $dataToVerify = $billplzData;
            unset($dataToVerify['x_signature']);

            if (!$this->billplz->verifyXSignature($dataToVerify, $xSignature)) {
                Log::warning('Billplz return: Invalid X Signature', [
                    'bill_id' => $billplzBillId,
                ]);

                return redirect()
                    ->route('customer.bookings.show', $booking->id)
                    ->with('error', 'Payment verification failed.');
            }

            // Persist signature and amounts for auditing
            $payment->update([
                'x_signature' => $xSignature,
                'transaction_id' => $billplzData['transaction_id'] ?? $billplzBillId,
                'paid_amount' => $paidAmountCents,
                'gateway_response' => $billplzData,
            ]);

            // Ensure amount matches expected
            if ($paidAmountCents !== $payment->getAmountInCents()) {
                Log::warning('Billplz return: Amount mismatch', [
                    'bill_id' => $billplzBillId,
                    'expected_cents' => $payment->getAmountInCents(),
                    'received_cents' => $paidAmountCents,
                ]);

                $payment->markAsFailed('Paid amount mismatch', $billplzData);

                return redirect()
                    ->route('customer.bookings.show', $booking->id)
                    ->with('error', 'Payment verification failed.');
            }

            // Check payment status and update records
            if ($paid === 'true') {
                // Update payment status if not already paid (callback might not reach localhost)
                if (!$payment->isPaid()) {
                    $payment->markAsPaid(
                        $billplzData,
                        $billplzData['transaction_id'] ?? $billplzBillId,
                        $paidAmountCents
                    );

                    Log::info('Payment marked as paid via return URL', [
                        'payment_id' => $payment->id,
                        'booking_id' => $booking->id,
                    ]);
                }

                // Payment successful - redirect to success page
                return redirect()->route('payment.success', $booking->id);
            } else {
                // Update payment as failed if not already
                if (!$payment->isFailed()) {
                    $payment->markAsFailed('Payment was not completed', $billplzData);
                }

                // Payment failed - redirect to failed page
                return redirect()->route('payment.failed', $booking->id);
            }

        } catch (\Exception $e) {
            Log::error('Billplz return processing failed', [
                'error' => $e->getMessage(),
                'bill_id' => $billplzData['id'] ?? null,
            ]);

            return redirect()
                ->route('customer.bookings')
                ->with('error', 'An error occurred while processing your payment.');
        }
    }

    /**
     * Show payment success page
     *
     * @param int $bookingId
     * @return \Illuminate\View\View
     */
    public function success($bookingId)
    {
        try {
            $booking = Booking::where('id', $bookingId)
                ->where('user_id', Auth::id())
                ->with(['activity', 'user', 'payment'])
                ->firstOrFail();

            $payment = $booking->payment;

            return view('customer.payment.success', compact('booking', 'payment'));

        } catch (\Exception $e) {
            return redirect()
                ->route('customer.bookings')
                ->with('error', 'Booking not found.');
        }
    }

    /**
     * Show payment failed page
     *
     * @param int $bookingId
     * @return \Illuminate\View\View
     */
    public function failed($bookingId)
    {
        try {
            $booking = Booking::where('id', $bookingId)
                ->where('user_id', Auth::id())
                ->with(['activity', 'user', 'payment'])
                ->firstOrFail();

            $payment = $booking->payment;

            return view('customer.payment.failed', compact('booking', 'payment'));

        } catch (\Exception $e) {
            return redirect()
                ->route('customer.bookings')
                ->with('error', 'Booking not found.');
        }
    }

    /**
     * Show payment receipt
     *
     * @param int $bookingId
     * @return \Illuminate\View\View
     */
    public function receipt($bookingId)
    {
        try {
            $booking = Booking::where('id', $bookingId)
                ->where('user_id', Auth::id())
                ->with(['activity', 'user', 'payment'])
                ->firstOrFail();

            // Check if booking is paid
            if (!$booking->isPaid()) {
                return redirect()
                    ->route('customer.bookings.show', $booking->id)
                    ->with('error', 'Payment not completed yet.');
            }

            $payment = $booking->payment;

            return view('customer.payment.receipt', compact('booking', 'payment'));

        } catch (\Exception $e) {
            return redirect()
                ->route('customer.bookings')
                ->with('error', 'Booking not found.');
        }
    }

    /**
     * Show payment status/details page
     *
     * @param int $bookingId
     * @return \Illuminate\View\View
     */
    public function status($bookingId)
    {
        try {
            $booking = Booking::where('id', $bookingId)
                ->where('user_id', Auth::id())
                ->with(['activity', 'user', 'payment', 'payments'])
                ->firstOrFail();

            $payment = $booking->payment;

            // Get bill details from Billplz if bill ID exists
            $billDetails = null;
            if ($payment && $payment->bill_id) {
                $result = $this->billplz->getBill($payment->bill_id);
                if ($result['success']) {
                    $billDetails = $result['data'];
                }
            }

            return view('customer.payment.status', compact('booking', 'payment', 'billDetails'));

        } catch (\Exception $e) {
            return redirect()
                ->route('customer.bookings')
                ->with('error', 'Booking not found.');
        }
    }

    /**
     * Retry payment for a failed booking
     *
     * @param int $bookingId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function retry($bookingId)
    {
        try {
            $booking = Booking::where('id', $bookingId)
                ->where('user_id', Auth::id())
                ->with('payment')
                ->firstOrFail();

            // Check if booking is already paid
            if ($booking->isPaid()) {
                return redirect()
                    ->route('customer.bookings.show', $booking->id)
                    ->with('info', 'This booking has already been paid.');
            }

            $payment = $booking->payment;

            // Delete old bill if exists
            if ($payment && $payment->bill_id) {
                $this->billplz->deleteBill($payment->bill_id);
            }

            // Reset payment for retry or create new one
            if ($payment) {
                $payment->resetForRetry();
            }

            // Redirect to initiate payment
            return redirect()->route('payment.initiate', $booking->id);

        } catch (\Exception $e) {
            Log::error('Payment retry failed', [
                'booking_id' => $bookingId,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('customer.bookings.show', $bookingId)
                ->with('error', 'Failed to retry payment.');
        }
    }
}
