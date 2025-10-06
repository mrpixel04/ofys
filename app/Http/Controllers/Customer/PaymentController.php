<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Services\BillplzService;

class PaymentController extends Controller
{
    protected $billplz;

    public function __construct(BillplzService $billplz)
    {
        $this->middleware('auth');
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

            // Check if payment is already processing
            if ($booking->payment_status === 'processing' && $booking->billplz_url) {
                return redirect($booking->billplz_url);
            }

            // Mark as processing
            $booking->markAsProcessing();

            // Create bill in Billplz
            $result = $this->billplz->createBill($booking);

            if ($result['success']) {
                // Redirect to Billplz payment page
                return redirect($result['url']);
            }

            // If failed, mark as failed and show error
            $booking->markAsFailed('Failed to create payment bill');

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
                ->route('customer.bookings.index')
                ->with('error', 'An error occurred while initiating payment.');
        }
    }

    /**
     * Handle Billplz callback (webhook)
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request)
    {
        try {
            // Get callback data
            $callbackData = $request->all();

            Log::info('Billplz callback received', [
                'data' => $callbackData,
            ]);

            // Verify X Signature if present
            if ($request->has('x_signature')) {
                $xSignature = $request->input('x_signature');
                $dataToVerify = $request->except('x_signature');

                if (!$this->billplz->verifyXSignature($dataToVerify, $xSignature)) {
                    Log::warning('Billplz callback: Invalid X Signature', [
                        'data' => $callbackData,
                    ]);

                    return response('Invalid signature', 403);
                }
            }

            // Process callback
            $result = $this->billplz->processCallback($callbackData);

            if ($result['success']) {
                return response('OK', 200);
            }

            return response('Processing failed', 500);

        } catch (\Exception $e) {
            Log::error('Billplz callback processing failed', [
                'error' => $e->getMessage(),
                'data' => $request->all(),
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
    public function return(Request $request)
    {
        try {
            // Get bill ID from request
            $billplzBillId = $request->input('billplz[id]');
            $paid = $request->input('billplz[paid]');
            $xSignature = $request->input('billplz[x_signature]');

            Log::info('Billplz return received', [
                'bill_id' => $billplzBillId,
                'paid' => $paid,
            ]);

            // Find booking
            $booking = Booking::where('billplz_bill_id', $billplzBillId)->first();

            if (!$booking) {
                return redirect()
                    ->route('customer.bookings.index')
                    ->with('error', 'Booking not found.');
            }

            // Verify X Signature if present
            if ($xSignature) {
                $dataToVerify = $request->input('billplz');
                unset($dataToVerify['x_signature']);

                if (!$this->billplz->verifyXSignature($dataToVerify, $xSignature)) {
                    Log::warning('Billplz return: Invalid X Signature', [
                        'bill_id' => $billplzBillId,
                    ]);

                    return redirect()
                        ->route('customer.bookings.show', $booking->id)
                        ->with('error', 'Payment verification failed.');
                }
            }

            // Check payment status
            if ($paid === 'true') {
                // Payment successful - redirect to success page
                return redirect()->route('payment.success', $booking->id);
            } else {
                // Payment failed - redirect to failed page
                return redirect()->route('payment.failed', $booking->id);
            }

        } catch (\Exception $e) {
            Log::error('Billplz return processing failed', [
                'error' => $e->getMessage(),
                'data' => $request->all(),
            ]);

            return redirect()
                ->route('customer.bookings.index')
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
                ->with(['activity', 'user'])
                ->firstOrFail();

            return view('customer.payment.success', compact('booking'));

        } catch (\Exception $e) {
            return redirect()
                ->route('customer.bookings.index')
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
                ->with(['activity', 'user'])
                ->firstOrFail();

            return view('customer.payment.failed', compact('booking'));

        } catch (\Exception $e) {
            return redirect()
                ->route('customer.bookings.index')
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
                ->with(['activity', 'user'])
                ->firstOrFail();

            // Check if booking is paid
            if (!$booking->isPaid()) {
                return redirect()
                    ->route('customer.bookings.show', $booking->id)
                    ->with('error', 'Payment not completed yet.');
            }

            return view('customer.payment.receipt', compact('booking'));

        } catch (\Exception $e) {
            return redirect()
                ->route('customer.bookings.index')
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
                ->with(['activity', 'user'])
                ->firstOrFail();

            // Get bill details from Billplz if bill ID exists
            $billDetails = null;
            if ($booking->billplz_bill_id) {
                $result = $this->billplz->getBill($booking->billplz_bill_id);
                if ($result['success']) {
                    $billDetails = $result['data'];
                }
            }

            return view('customer.payment.status', compact('booking', 'billDetails'));

        } catch (\Exception $e) {
            return redirect()
                ->route('customer.bookings.index')
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
                ->firstOrFail();

            // Check if booking is already paid
            if ($booking->isPaid()) {
                return redirect()
                    ->route('customer.bookings.show', $booking->id)
                    ->with('info', 'This booking has already been paid.');
            }

            // Delete old bill if exists
            if ($booking->billplz_bill_id) {
                $this->billplz->deleteBill($booking->billplz_bill_id);
            }

            // Reset payment fields
            $booking->update([
                'billplz_bill_id' => null,
                'billplz_url' => null,
                'billplz_transaction_id' => null,
                'billplz_transaction_status' => null,
                'payment_status' => 'pending',
            ]);

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
