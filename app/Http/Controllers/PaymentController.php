<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class PaymentController extends Controller
{
    private $price;
    public function __construct()
    {
        $this->price = env('price', 10);
    }
    function plan_id($plan)
    {
        $plan_id = Plan::where('name', $plan)->first()->id ?? null;
        // if (!$plan_id) {
        //     // print_r($plan_id);die;
        //     return false;
        // }
        return $plan_id;
    }
    public function charge(String $plan)
    {

        $user = Auth::user();

        $plan_id = $this->plan_id($plan);
        if (!$plan_id) {
            // print_r($plan_id);die;
            return redirect()->route('home')->with('error', 'Plan not found #995');
        }
        if (Payment::where('user_id', $user->id)->where('plan_id', $plan_id)->where('stripe_payment_id', '!=', '')->exists()) {
            return redirect()->route('upload-video', ['plan' => $plan]);
        }
        // session()->put('plan', $plan);
        return view('payment', [
            'user' => $user,
            'intent' => $user->createSetupIntent(),
            'product' => $plan,
            'price' => $this->price
        ]);
    }

    public function processPayment(Request $request, $plan)
    {
        //    dd($plan, 'test', $request->plan);
        $user = Auth::user();
        $plan_id = $this->plan_id($plan);
        $paymentMethod = $request->input('payment_method');
        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethod);


        try {
            $payment = $user->charge($this->price * 100, $paymentMethod, [
                'return_url' => route('upload-video', ['plan' => $request->plan]),
            ]);
            Log::info($payment);
            // Get the payment ID from the returned object
            $paymentId = $payment->id;


            // Create or update the payment record in your database
            $paymentRecord = Payment::updateOrCreate(['stripe_payment_id' => $paymentId, 'plan_id' => $plan_id], [
                'user_id' => $user->id,
                'plan_id' => $plan_id
            ]);
            Log::info($paymentRecord);

            if (UserDetail::where('user_id', Auth::user()->id)->exists())
                return redirect()->route('upload-video', ['plan' => $request->plan]);
            else
                return redirect()->route('upload-video', ['plan' => $request->plan]);

            // redirect('upload-video');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Error creating subscription. ' . $e->getMessage()]);
        }
        return redirect('home');
    }
}
