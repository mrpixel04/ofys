<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;

class BillplzService
{
    protected $apiKey;
    protected $apiUrl;
    protected $collectionId;
    protected $xSignatureKey;

    public function __construct()
    {
        $this->apiKey = config('services.billplz.api_key');
        $this->apiUrl = config('services.billplz.api_url');
        $this->collectionId = config('services.billplz.collection_id');
        $this->xSignatureKey = config('services.billplz.x_signature_key');
    }

    /**
     * Create a bill in Billplz
     *
     * @param Booking $booking
     * @return array
     */
    public function createBill(Booking $booking)
    {
        try {
            // Prepare bill data
            $billData = [
                'collection_id' => $this->collectionId,
                'email' => $booking->user->email,
                'name' => $booking->user->name,
                'amount' => $booking->getTotalPriceInCents(), // Amount in cents
                'callback_url' => route('payment.callback'),
                'description' => $this->generateBillDescription($booking),
                'reference_1_label' => 'Booking Reference',
                'reference_1' => $booking->booking_reference,
                'reference_2_label' => 'Activity',
                'reference_2' => $booking->activity->name ?? 'N/A',
            ];

            // Add redirect URL if needed
            $billData['redirect_url'] = route('payment.return');

            // Make API request to Billplz
            $response = Http::withBasicAuth($this->apiKey, '')
                ->asForm()
                ->post("{$this->apiUrl}/v3/bills", $billData);

            if ($response->successful()) {
                $data = $response->json();

                // Update booking with Billplz data
                $booking->update([
                    'billplz_bill_id' => $data['id'],
                    'billplz_collection_id' => $data['collection_id'],
                    'billplz_url' => $data['url'],
                    'payment_method' => 'billplz',
                    'payment_status' => 'processing',
                ]);

                Log::info('Billplz bill created successfully', [
                    'booking_id' => $booking->id,
                    'bill_id' => $data['id'],
                ]);

                return [
                    'success' => true,
                    'bill_id' => $data['id'],
                    'url' => $data['url'],
                    'data' => $data,
                ];
            }

            // Log error
            Log::error('Billplz bill creation failed', [
                'booking_id' => $booking->id,
                'response' => $response->body(),
                'status' => $response->status(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to create bill',
                'error' => $response->json(),
            ];

        } catch (\Exception $e) {
            Log::error('Billplz bill creation exception', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while creating the bill',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get bill details from Billplz
     *
     * @param string $billId
     * @return array
     */
    public function getBill($billId)
    {
        try {
            $response = Http::withBasicAuth($this->apiKey, '')
                ->get("{$this->apiUrl}/v3/bills/{$billId}");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to retrieve bill',
                'error' => $response->json(),
            ];

        } catch (\Exception $e) {
            Log::error('Billplz get bill exception', [
                'bill_id' => $billId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while retrieving the bill',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Delete a bill from Billplz
     *
     * @param string $billId
     * @return array
     */
    public function deleteBill($billId)
    {
        try {
            $response = Http::withBasicAuth($this->apiKey, '')
                ->delete("{$this->apiUrl}/v3/bills/{$billId}");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Bill deleted successfully',
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to delete bill',
                'error' => $response->json(),
            ];

        } catch (\Exception $e) {
            Log::error('Billplz delete bill exception', [
                'bill_id' => $billId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while deleting the bill',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify X Signature from Billplz callback
     *
     * @param array $data
     * @param string $signature
     * @return bool
     */
    public function verifyXSignature($data, $signature)
    {
        // Sort data by key
        ksort($data);

        // Build string for signature
        $signatureString = '';
        foreach ($data as $key => $value) {
            $signatureString .= $key . $value;
        }

        // Append X Signature Key
        $signatureString .= $this->xSignatureKey;

        // Generate signature
        $generatedSignature = hash_hmac('sha256', $signatureString, $this->xSignatureKey);

        // Compare signatures
        return hash_equals($generatedSignature, $signature);
    }

    /**
     * Process Billplz callback
     *
     * @param array $callbackData
     * @return array
     */
    public function processCallback($callbackData)
    {
        try {
            // Find booking by Billplz bill ID
            $booking = Booking::where('billplz_bill_id', $callbackData['id'])->first();

            if (!$booking) {
                Log::warning('Billplz callback: Booking not found', [
                    'bill_id' => $callbackData['id'],
                ]);

                return [
                    'success' => false,
                    'message' => 'Booking not found',
                ];
            }

            // Check if payment is already processed
            if ($booking->isPaid()) {
                Log::info('Billplz callback: Payment already processed', [
                    'booking_id' => $booking->id,
                    'bill_id' => $callbackData['id'],
                ]);

                return [
                    'success' => true,
                    'message' => 'Payment already processed',
                    'booking' => $booking,
                ];
            }

            // Update booking with transaction data
            $booking->update([
                'billplz_transaction_id' => $callbackData['transaction_id'] ?? null,
                'billplz_transaction_status' => $callbackData['transaction_status'] ?? null,
                'billplz_paid_amount' => $callbackData['amount'] ?? null,
                'payment_gateway_response' => $callbackData,
            ]);

            // Check payment status
            if (isset($callbackData['paid']) && $callbackData['paid'] === 'true') {
                // Payment successful
                $booking->markAsPaid($callbackData);

                Log::info('Billplz callback: Payment successful', [
                    'booking_id' => $booking->id,
                    'bill_id' => $callbackData['id'],
                    'transaction_id' => $callbackData['transaction_id'] ?? null,
                ]);

                return [
                    'success' => true,
                    'message' => 'Payment successful',
                    'booking' => $booking,
                    'paid' => true,
                ];
            } else {
                // Payment failed
                $booking->markAsFailed('Payment not completed');

                Log::warning('Billplz callback: Payment failed', [
                    'booking_id' => $booking->id,
                    'bill_id' => $callbackData['id'],
                ]);

                return [
                    'success' => true,
                    'message' => 'Payment failed',
                    'booking' => $booking,
                    'paid' => false,
                ];
            }

        } catch (\Exception $e) {
            Log::error('Billplz callback processing exception', [
                'error' => $e->getMessage(),
                'callback_data' => $callbackData,
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while processing the callback',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Generate bill description
     *
     * @param Booking $booking
     * @return string
     */
    protected function generateBillDescription(Booking $booking)
    {
        $activity = $booking->activity;
        $description = "Booking for {$activity->name}";
        
        if ($booking->participants > 1) {
            $description .= " ({$booking->participants} participants)";
        }

        $description .= " on " . $booking->booking_date->format('M d, Y');

        return $description;
    }

    /**
     * Get payment methods
     *
     * @return array
     */
    public function getPaymentMethods()
    {
        try {
            $response = Http::withBasicAuth($this->apiKey, '')
                ->get("{$this->apiUrl}/v3/payment_methods");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to retrieve payment methods',
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get FPX banks
     *
     * @return array
     */
    public function getFpxBanks()
    {
        try {
            $response = Http::withBasicAuth($this->apiKey, '')
                ->get("{$this->apiUrl}/v3/fpx_banks");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to retrieve FPX banks',
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ];
        }
    }
}
