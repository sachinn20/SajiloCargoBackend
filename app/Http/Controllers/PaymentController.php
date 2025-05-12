<?php
    namespace App\Http\Controllers;

    use App\Models\Booking;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Log;

    class PaymentController extends Controller
    {
        // STEP 1: Initiate Payment
        public function initiate(Request $request)
        {
            $request->validate([
                'booking_id' => 'required|exists:bookings,id'
            ]);
        
            try {
                $booking = Booking::findOrFail($request->booking_id);
                $amount = $booking->amount * 100; // Convert to paisa
        
                $payload = [
                    "return_url" => url('/verify-payment') . "?booking_id={$booking->id}", // safer
                    "website_url" => url('/'),
                    "amount" => $amount,
                    "purchase_order_id" => $booking->id,
                    "purchase_order_name" => "SajiloCargo Booking #{$booking->id}",
                    "customer_info" => [
                        "name" => auth()->user()->name ?? "Guest",
                        "email" => auth()->user()->email ?? "guest@email.com",
                        "phone" => auth()->user()->phone ?? "9800000001"
                    ]
                ];
        
                Log::info('[Khalti] Initiating payment with payload:', $payload);
        
                $res = Http::withoutVerifying()->withHeaders([
                    'Authorization' => 'Key df14ea32f8a14f798fb2cac788e2bda2',
                    'Content-Type' => 'application/json',
                ])->post('https://dev.khalti.com/api/v2/epayment/initiate/', $payload);
                
        
                Log::info('[Khalti] Raw response:', $res->json());
        
                if ($res->successful() && isset($res['payment_url'])) {
                    return response()->json([
                        'payment_url' => $res['payment_url'],
                        'pidx' => $res['pidx'],
                    ]);
                }
        
                // ❌ Log failure details
                Log::error('[Khalti] Payment initiation failed', [
                    'status' => $res->status(),
                    'body' => $res->body(),
                    'response' => $res->json(),
                ]);
        
                return response()->json(['error' => 'Failed to initiate payment.'], 500);
        
            } catch (\Exception $e) {
                Log::error('[Khalti] Exception during initiation', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                return response()->json(['error' => 'An unexpected error occurred.'], 500);
            }
        }
        

        // STEP 2: Verify Payment Using PIDX (LOOKUP API)
        public function lookup(Request $request)
        {
            $request->validate([
                'pidx' => 'required|string',
                'booking_id' => 'required|exists:bookings,id',
            ]);
        
            try {
                $secretKey = config('khalti.secret_key');
        
                if (empty($secretKey)) {
                    Log::error('[Khalti] Secret key is missing in config.');
                    return response()->json(['error' => 'Khalti secret key not configured.'], 500);
                }
        
                Log::info('[Khalti] Verifying payment with PIDX: ' . $request->pidx);
        
                $res = Http::withoutVerifying()->withHeaders([
                    'Authorization' => 'Key df14ea32f8a14f798fb2cac788e2bda2',
                    ])->post('https://dev.khalti.com/api/v2/epayment/lookup/', [
                    'pidx' => $request->pidx,
                ]);
        
                Log::info('[Khalti] Lookup Response:', $res->json());
        
                if ($res->successful() && $res['status'] === 'Completed') {
                    $booking = Booking::find($request->booking_id);
                    $booking->update([
                        'is_paid' => true,
                        'payment_mode' => 'khalti',
                        'khalti_transaction_id' => $res['transaction_id'],
                    ]);
        
                    return response()->json(['message' => 'Payment confirmed.', 'booking' => $booking]);
                }
        
                return response()->json([
                    'message' => 'Payment failed or incomplete',
                    'details' => $res->json()
                ], 422);
        
            } catch (\Exception $e) {
                Log::error('[Khalti] Exception during lookup', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                return response()->json(['error' => 'An unexpected error occurred during lookup.'], 500);
            }
        }
        
    }
