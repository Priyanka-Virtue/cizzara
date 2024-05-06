<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;
use App\Notifications\PaymentSuccessNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    // added name
    protected $paypalClient;
    public $plan_id, $amount, $members, $team_type;
    public function __construct()
    {
        $paypalClient = new PayPalClient;
        $this->paypalClient = $paypalClient;
    }

    public function calculateAmount($plan, $members, $team_type)
    {

        $amount = 0;
        $plan_amt = Plan::where('name', $plan)->first();


        switch ($team_type) {
            case 'Group':
                if ($members == '' || $members > $plan_amt['prices'][$team_type]['MaxMembers']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Please select number of members less than ' . $plan_amt['prices'][$team_type]['MaxMembers']
                    ], 400);
                }
                $amount = $plan_amt['prices'][$team_type]['Price'] * $members;
                $this->members = $members;
                break;
            case 'Duet':
                $amount = $plan_amt['prices'][$team_type]['Price'];
                $this->members = 2;
                break;

            default:
                $amount = $plan_amt['prices'][$team_type]['Price'];
                $this->members = 1;
                break;
        }
        $this->amount = $amount;
        $this->plan_id = $plan_amt['id'];
        // $this->members = $members;
        $this->team_type = $team_type;
        return number_format($amount, 2);
    }
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);




        if ($data['plan_type'] == 'Group' && $data['members'] == '') {
            return response()->json(['success' => false, 'message' => 'Please select number of members.'], 400);
        }

        $amount = $this->calculateAmount($data['plan'], $data['members'] ?? 1, $data['plan_type']);

        if ($amount == 0) {
            return response()->json(['success' => false, 'message' => 'Please select valid audition.'], 400);
        }

        // dd($this->plan_id, $amount);

        $this->paypalClient->setApiCredentials(config('paypal'));
        $token = $this->paypalClient->getAccessToken();
        $this->paypalClient->setAccessToken($token);
        $order = $this->paypalClient->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amount
                    ],
                    'description' => 'test'
                ]
            ],
        ]);
        // dd($order, $order->orderID);

        if (isset($order['id']) && $order['id'] != '') {

            // DB::beginTransaction();
            $transaction = new Payment();
            $transaction->payment_id = $order['id'];
            $transaction->user_id   = auth()->user()->id;
            $transaction->plan_id   = $this->plan_id;
            $transaction->members   = $this->members;
            $transaction->team_type = $this->team_type;
            $transaction->amount   = $this->amount;
            $transaction->status   = 'PENDING';
            $transaction->save();
            // $mergeData = array_merge($data,['status' => TransactionStatus::PENDING, 'vendor_order_id' => $order['id']]);

            // Order::create($mergeData);
            // DB::commit();
            return response()->json($order);
        }
        // return response()->json(['success' => false, 'message' => 'Error creating payment. Please try again. #PDE40c2'], 400);
        dd($order);
        //return redirect($order['links'][1]['href'])->send();
        // echo('Create working');
    }
    public function capture(Request $request)
    {
        // dd($this->plan_id);
        $data = json_decode($request->getContent(), true);
        $orderId = $data['orderId'];
        $this->paypalClient->setApiCredentials(config('paypal'));
        $token = $this->paypalClient->getAccessToken();
        $this->paypalClient->setAccessToken($token);
        $result = $this->paypalClient->capturePaymentOrder($orderId);

        //            $result = $result->purchase_units[0]->payments->captures[0];
        try {
            DB::beginTransaction();
            if ($result['status'] === "COMPLETED") {
                // $transaction = new Payment();
                // $transaction->payment_id = $orderId;
                // $transaction->user_id   = auth()->user()->id;
                // $transaction->plan_id   = $this->plan_id;
                // $transaction->members   = $this->members;
                // $transaction->team_type = $this->team_type;
                // $transaction->amount   = $this->amount;
                // $transaction->status   = 'COMPLETED';
                // $transaction->save();
                // $order = Order::where('vendor_order_id', $orderId)->first();
                // $order->transaction_id = $transaction->id;
                // $order->status = TransactionStatus::COMPLETED;
                // $order->save();
                $paymentRecord = Payment::where('payment_id', $orderId)->first();
                $paymentRecord->status = 'COMPLETED';
                $paymentRecord->save();
                // Log::info($paymentRecord);
                if ($paymentRecord) {
                    $paymentRecord['price'] = $paymentRecord->amount;
                    auth()->user()->notify(new PaymentSuccessNotification($paymentRecord));
                    DB::commit();
                    return response()->json(['success' => true, 'message' => 'Payment completed successfully.'], 200);
                    // return redirect()->route('upload-video', ['plan' => $request->plan]);
                } else {
                    Log::info($paymentRecord);
                    return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again. #PDE400'], 400);
                    DB::rollBack();
                    // return redirect()->back()->with('error', 'Something went wrong. Please try again. #PDE400');
                }
                // DB::commit();
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e);
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again. #PDE4002'], 400);
        }


        Log::info($result);
        return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again. #PDE4003'], 400);
        // return response()->json($result);
    }
}
