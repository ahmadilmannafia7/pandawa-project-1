<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FlightSeat;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionSuccessMail;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.serverKey');
        $hashedKey = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashedKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id;
        $transaction = Transaction::where('code', $orderId)->first();

        // Handle status dari Midtrans
        switch ($transactionStatus) {
            case 'capture':
                if ($request->payment_type == 'credit_card') {
                    if ($request->fraud_status == 'challenge') {
                        $transaction->update(['payment_status' => 'pending']);
                    } else {
                        $transaction->update(['payment_status' => 'success']);
                    }
                }
                break;

            case 'settlement':
                $transaction->update(['payment_status' => 'paid']);
                foreach ($transaction->passengers as $passenger) {
                    FlightSeat::where('id', $passenger->flight_seat_id)
                        ->update(['is_available' => false]);
                }
                Mail::to($transaction->email)->send(new TransactionSuccessMail($transaction));
                break;

            case 'pending':
                $transaction->update(['payment_status' => 'pending']);
                break;

            case 'deny':
                $transaction->update(['payment_status' => 'failed']);
                break;

            case 'expire':
                $transaction->update(['payment_status' => 'expired']);
                break;

            case 'cancel':
                $transaction->update(['payment_status' => 'canceled']);
                break;

            default:
                $transaction->update(['payment_status' => 'unknown']);
                break;
        }

        return response()->json(['message' => 'Callback received successfully']);
    }
}
