<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\Singing;
use App\Models\UserDetail;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VideoController extends Controller
{
    public function index(Request $request)
    {

        $plan_id = Plan::where('name', $request->plan)->first()->id ?? null;
        $user_id = Auth::id();

        if ($plan_id) {
            $uploaded_videos_count = Payment::where('payments.user_id', $user_id)
                ->where('payments.stripe_payment_id', '!=', '')
                ->where('payments.plan_id', '=', $plan_id)
                ->join('videos', 'payments.stripe_payment_id', '=', 'videos.stripe_payment_id')
                ->count();

            // Allow up to 2 video uploads
            if ($uploaded_videos_count >= 2) {
                return view('thanks');
            }
        }

        if ($request->has('step') && $request->step == 'profile') {
            $userDetail = UserDetail::where('user_id', Auth::id())->first();
            return view('details', compact('userDetail'));
        } else if ($request->has('step') && $request->step == 'audition') {
            if ($plan_id) {


                $userDetail = Singing::where('user_id', Auth::id())->where('plan_id', '=', $plan_id)->first();
            } else {
                $plan = Payment::where('user_id', $user_id)->where('stripe_payment_id', '!=', '')->first()->plan_id ?? '';

                $userDetail = Singing::where('user_id', Auth::id())->where('plan_id', '=', $plan)->first();
            }
            return view('singing', compact('userDetail'));
        } else {

            $plan = Payment::where('user_id', $user_id)->where('stripe_payment_id', '!=', '')->first()->plan_id ?? '';

            $hasUserDetails = UserDetail::where('user_id', $user_id)->exists();
            $hasSinging = Singing::where('user_id', $user_id)->where('plan_id', $plan)->exists();

            $uploaded_videos_count = Payment::where('payments.user_id', $user_id)
                ->where('payments.stripe_payment_id', '!=', '')
                ->where('payments.plan_id', '=', $plan)
                ->join('videos', 'payments.stripe_payment_id', '=', 'videos.stripe_payment_id')
                ->count();

            if ($uploaded_videos_count >= 2) {

                return view('thanks');
            } else if ($hasUserDetails && $hasSinging)
                return view('upload-video');
            else if ($hasUserDetails) {
                $userDetail = Singing::where('user_id', Auth::id())->where('plan_id', '=', $plan)->first();
                return view('singing', compact('userDetail'));
            }
        }

        $userDetail = UserDetail::where('user_id', Auth::id())->first();
        return view('details', compact('userDetail'));
    }
    public function upload(Request $request)
    {
        $user = auth()->user();
        if (!empty($request->plan)) {
            $plan = Plan::where('name', $request->plan)->first();
            $payment = Payment::where('user_id', $user->id)->where('plan_id', $plan->id)->where('stripe_payment_id', '!=', '')->first();
        } else {
            $payment = Payment::where('user_id', $user->id)->where('stripe_payment_id', '!=', '')->latest()->first() ?? "";
            $plan = Plan::find($payment->plan_id);
        }

        if (!$plan || !$payment) {
            return redirect()->back()->with('error', 'No plan found #P404');
        }

        $validator = Validator::make($request->all(), [
            'style' => [
                'required',
                Rule::unique('videos')->where(function ($query) use ($request) {
                    return $query->where('user_id', Auth::id())
                        ->where('style', $request->style);
                }),
            ],
            'videoTitle' => 'required',
            'videoFile' => [
                'required',
                'mimetypes:video/*',
                'max:100000',
                function ($attribute, $value, $fail) {
                    $uploaded_videos_count = Video::where('user_id', Auth::id())->count();
                    if ($uploaded_videos_count >= env('MAX_VIDEO_FILE_UPLOAD', 2)) {
                        $fail('You have reached the maximum limit of ' . env('MAX_VIDEO_FILE_UPLOAD', 2) . ' videos.');
                    }
                },
            ],
        ], [
            'style.unique' => 'You have already uploaded a video with this style.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }



        if ($request->hasFile('videoFile')) {
            $videoFile = $request->file('videoFile');

            $fileName = uniqid() . '.' . $videoFile->getClientOriginalExtension();
            $oname = $videoFile->getClientOriginalName();

            $path = $videoFile->storeAs('videos/' . $plan->name, $fileName, 'public');

            $video = new Video();
            $video->user_id = $user->id;
            $video->plan_id = $plan->id;
            $video->stripe_payment_id = $payment->stripe_payment_id;
            $video->file_path = $path;
            $video->original_name = $oname;
            $video->title = $request->videoTitle;
            $video->style = $request->style;
            $video->description = $request->videoDescription;
            $video->save();

            return redirect()->back()->withInput()->with('success', 'Video uploaded successfully.');
        }

        return redirect()->back()->withErrors(['message' => 'No video file found.'])->withInput();
    }




}
