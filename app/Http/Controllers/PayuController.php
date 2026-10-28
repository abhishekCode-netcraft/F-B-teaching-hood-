<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class PayUController extends Controller
{
    public function initiatePayment(Request $request)
    {
        $customer = $request->validate([
            'firstname' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email'],
            'amount' => ['required'],
            'plan_name' => ['required'],
            'plan_id' => ['required'],
            'user_id' => ['required'],
        ]);

        $key = config('services.payu.key');
        $salt = config('services.payu.salt');

        $txnid = 'TXN' . Str::uuid()->toString();
        $productinfo = $customer['plan_name'];
        $firstname = $customer['firstname'];
        $email = $customer['email'];
        $amount = $customer['amount'];
        // $amount = number_format((float) $amount, 2, '.', '');

        $hashString = implode('|', [
            $key,
            $txnid,
            $amount,
            $productinfo,
            $firstname,
            $email,
            '', // udf1
            '', // udf2
            '', // udf3
            '', // udf4
            '', // udf5
            '', // udf6
            '', // udf7
            '', // udf8
            '', // udf9
            '', // udf10
            $salt,
        ]);

        $hash = strtolower(hash('sha512', $hashString));

        return response()->json([
            'payment_url' => config('services.payu.base_url'),
            'payment_data' => [
                'key' => $key,
                'txnid' => $txnid,
                'amount' => $amount,
                'productinfo' => $productinfo,
                'firstname' => $firstname,
                'email' => $email,
                'surl' => url('/') . "/payment/success?plan_id=" . request()->plan_id . "&user_id=" . request()->user_id,
                'furl' => url('/') . "/payment/failure?plan_id=" . request()->plan_id . "&user_id=" . request()->user_id,
                'hash' => $hash,
            ],
        ]);
    }

    private function verifyPayUResponse(array $data): bool
    {
        $salt = config('services.payu.salt');

        // PayU standard reverse hash:
        // salt|status||||||udf5|udf4|udf3|udf2|udf1|
        // email|firstname|productinfo|amount|txnid|key

        $hashString = implode('|', [
            $salt,
            $data['status'] ?? '',
            '',
            '',
            '',
            '',
            '',
            $data['udf5'] ?? '',
            $data['udf4'] ?? '',
            $data['udf3'] ?? '',
            $data['udf2'] ?? '',
            $data['udf1'] ?? '',
            $data['email'] ?? '',
            $data['firstname'] ?? '',
            $data['productinfo'] ?? '',
            $data['amount'] ?? '',
            $data['txnid'] ?? '',
            $data['key'] ?? '',
        ]);

        $calculatedHash = hash('sha512', $hashString);

        return isset($data['hash'])
            && hash_equals(
                strtolower($calculatedHash),
                strtolower($data['hash'])
            );
    }

    public function success(Request $request)
    {
        $data = $request->all();

        if (!$this->verifyPayUResponse($data)) {
            abort(400, 'Invalid PayU response hash.');
        }

        // if (($data['status'] ?? '') !== 'success') {
        //     return redirect(
        //         config('app.frontend_url', 'http://localhost:5173')
        //         . '/payment-status'
        //     );
        // }

        // dd($data['txnid']);

        $method = $data['mode'] ?? 'unknown';
        $status = $data['unmappedstatus'];
        $payment_id = $data['txnid'];
        $amount = $data['amount'];
        $metaData = json_encode($data);
        $userId = request()->user_id;

        // Prepare payload for Laravel API
        $data = [
            'payment_id' => $payment_id,
            'status'     => $status,
            'user_id'    => $userId,
            'method'     => $method,
            'amount'     => $amount,
            'meta_data' => $metaData
        ];

        Payment::create($data);

        $user = User::find($userId);
        $user->update([
            'plan_id' => request()->plan_id
        ]);

        // TODO:
        // 1. Find the order using txnid in your database.
        // 2. Verify the expected amount and transaction details.
        // 3. Update the order to paid using a database transaction.
        // 4. Make the update idempotent to prevent duplicate processing.

        return redirect(
            config('app.frontend_url', 'http://localhost:5173')
                . '/payment-status?txnid=' . $data['payment_id'] ?? ''
        );
    }

    public function failure(Request $request)
    {
        $data = $request->all();

        // dd($data);

        if (!$this->verifyPayUResponse($data)) {
            abort(400, 'Invalid PayU response hash.');
        }

        $method = $data['mode'] ?? 'unknown';
        $status = $data['unmappedstatus'];
        $payment_id = $data['txnid'];
        $amount = $data['amount'];
        $metaData = json_encode($data);
        $userId = request()->user_id;

        // Prepare payload for Laravel API
        $data = [
            'payment_id' => $payment_id,
            'status'     => $status,
            'user_id'    => $userId,
            'method'     => $method,
            'amount'     => $amount,
            'meta_data' => $metaData
        ];

        Payment::create($data);

        // TODO: Find the transaction in your database and record
        // the verified failure status. Do not mark an order paid.

        return redirect(
            config('app.frontend_url', 'http://localhost:5173')
                . '/payment-status?txnid=' . urlencode($data['payment_id'] ?? '')
        );
    }

    public function getPaymentStatus()
    {
        $validator = Validator::make(request()->all(), [
            'txnid' => 'required'
        ]);

        if ($validator->fails()) {
            return response_formatter(DEFAULT_VALIDATION_422, $validator->errors());
        }

        $payment = Payment::where('payment_id', request()->txnid)
            ->first();

        // $payment = $this->api->payment->fetch(request()->razorpay_payment_id);

        return response()->json([
            'status' => true,
            'message' => 'Payment details retrieved',
            'data' => $payment->toArray()
        ]);
    }
}
