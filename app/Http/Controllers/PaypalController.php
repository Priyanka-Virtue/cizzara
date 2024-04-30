<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
class PaypalController extends Controller
{
    protected $paypalClient;
    public function __construct(){
        $paypalClient = new PayPalClient;
        $this->paypalClient = $paypalClient;
    }
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $this->paypalClient->setApiCredentials(config('paypal'));
        $token = $this->paypalClient->getAccessToken();
        $this->paypalClient->setAccessToken($token);
        $order = $this->paypalClient->createOrder([
            "intent"=> "CAPTURE",
            "purchase_units"=> [
                 [
                    "amount"=> [
                        "currency_code"=> "USD",
                        "value"=> $data['amount']
                    ],
                     'description' => 'test'
                ]
            ],
        ]);
        // $mergeData = array_merge($data,['status' => TransactionStatus::PENDING, 'vendor_order_id' => $order['id']]);
        // DB::beginTransaction();
        // Order::create($mergeData);
        // DB::commit();
        return response()->json($order);


        //return redirect($order['links'][1]['href'])->send();
       // echo('Create working');
    }
    public function capture(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $orderId = $data['orderId'];
        $this->paypalClient->setApiCredentials(config('paypal'));
        $token = $this->paypalClient->getAccessToken();
        $this->paypalClient->setAccessToken($token);
        $result = $this->paypalClient->capturePaymentOrder($orderId);

//            $result = $result->purchase_units[0]->payments->captures[0];
        try {
            DB::beginTransaction();
            if($result['status'] === "COMPLETED"){
                $transaction = new Payment();
                $transaction->payment_id = $orderId;

                $transaction->user_id   = $data['user_id'];
                $transaction->plan_id   = $data['plan_id'];
                $transaction->status   = 'COMPLETED';
                $transaction->save();
                // $order = Order::where('vendor_order_id', $orderId)->first();
                // $order->transaction_id = $transaction->id;
                // $order->status = TransactionStatus::COMPLETED;
                // $order->save();
                // $paymentRecord = Payment::updateOrCreate(['stripe_payment_id' => $paymentId, 'plan_id' => $plan_id], [
                //     'user_id' => $user->id,
                //     'plan_id' => $plan_id
                // ]);
                // Log::info($paymentRecord);
                // if($paymentRecord) {
                //     $paymentRecord['price'] = $this->price;
                //     $user->notify(new PaymentSuccessNotification($paymentRecord));
                //     return redirect()->route('upload-video', ['plan' => $request->plan]);
                // }
                // else {
                //     Log::info($paymentRecord);
                //     return redirect()->back()->with('error', 'Something went wrong. Please try again. #PDE400');
                // }
                DB::commit();
            }
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
        return response()->json($result);
    }


}
