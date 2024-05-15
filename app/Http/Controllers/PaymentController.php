<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\UserDetail;
use App\Notifications\PaymentSuccessNotification;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class PaymentController extends Controller
{
    use Notifiable;
    private $price;
    public function __construct()
    {
        // $this->price = env('price', 10);
    }
    function plan_id($plan)
    {
        return Plan::where('name', $plan)->first()->id ?? null;

    }
    public function charge(String $plan = null)
    {

        $user = Auth::user();

        // $plan_id = $this->plan_id($plan);
        // if (!$plan_id) {
        //     return redirect()->route('home')->with('error', 'This audition is not available currently. #995');
        // }
        $get_plan = Plan::where('name', $plan)->where('is_active', '1')
        ->where('audition_start', '<=', date('Y-m-d H:i:s'))
        ->where('audition_end', '>=', date('Y-m-d H:i:s'))
        ->first();
        if (!$get_plan) {
            // dd($plan);
            return redirect()->route('home')->with('error', 'This audition is not available currently. #995');
        }
        if (Payment::where('user_id', $user->id)->where('plan_id', $get_plan->id)->where('payment_id', '!=', '')->where('status', '=', 'COMPLETED')->exists()) {
            return redirect()->route('upload-video', ['plan' => $plan]);
        }
        // $this->price = $get_plan->price;
        // session()->put('plan', $plan);
        return view('paypal', [
            'user' => $user,
            // 'intent' => $user->createSetupIntent(),
            'product' => $plan,
            // 'price' => $get_plan->price,
            'plan' => $get_plan
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

            // Get the payment ID from the returned object
            if ($payment->id ?? null) {
                $paymentId = $payment->id;


                // Create or update the payment record in your database
                $paymentRecord = Payment::updateOrCreate(['payment_id' => $paymentId, 'plan_id' => $plan_id], [
                    'user_id' => $user->id,
                    'plan_id' => $plan_id
                ]);
                Log::info($paymentRecord);
                if($paymentRecord) {
                    $paymentRecord['price'] = $this->price;
                    $paymentRecord['plan'] = $plan;
                    $user->notify(new PaymentSuccessNotification($paymentRecord));
                    return redirect()->route('upload-video', ['plan' => $request->plan]);
                }
                else {
                    Log::info($paymentRecord);
                    return redirect()->back()->with('error', 'Something went wrong. Please try again. #PDE400');
                }

                // if (UserDetail::where('user_id', Auth::user()->id)->exists())
                //     return redirect()->route('upload-video', ['plan' => $request->plan]);
                // else
                // return redirect()->route('upload-video', ['plan' => $request->plan]);
            }
            else {
                Log::info($payment);
                Log::info($user);
                return back()->withErrors(['message' => 'Looks like your payment was not successful. Please try again.']);
            }

            // redirect('upload-video');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Error creating subscription. ' . $e->getMessage()]);
        }
        return redirect('home');
    }
}
