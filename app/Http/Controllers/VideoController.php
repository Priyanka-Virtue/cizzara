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

class VideoController extends Controller
{
    public function index(Request $request)
    {

        $plan_id = Plan::where('name', $request->plan)->first()->id ?? null;
        $user_id = Auth::id();
        $video_exists = Payment::where('payments.user_id', $user_id)->where('payments.stripe_payment_id', '!=', '')->where('payments.plan_id', '=', $plan_id)
            ->join('videos', 'payments.stripe_payment_id', '=', 'videos.stripe_payment_id')
            ->exists();

        if ($video_exists) {
            return view('thanks');
        }


        if ($request->has('step') && $request->step == 'profile') {
            $userDetail = UserDetail::where('user_id', Auth::id())->first();
            return view('details', compact('userDetail'));
        } else if ($request->has('step') && $request->step == 'audition') {
            $userDetail = Singing::where('user_id', Auth::id())->where('plan_id', '=', $plan_id)->first();
            return view('singing', compact('userDetail'));
        } else {

            $plan = Payment::where('user_id', $user_id)->where('stripe_payment_id', '!=', '')->first()->plan_id ?? '';
            $hasUserDetails = UserDetail::where('user_id', $user_id)->exists();
            $hasSinging = Singing::where('user_id', $user_id)->where('plan_id', $plan)->exists();
            if ($hasUserDetails && $hasSinging)
                return view('upload-video');
            else if ($hasUserDetails) {
                $userDetail = Singing::where('user_id', Auth::id())->where('plan_id', '=', $plan_id)->first();
                return view('singing', compact('userDetail'));
            }
        }

        $userDetail = UserDetail::where('user_id', Auth::id())->first();
        return view('details', compact('userDetail'));
    }
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'videoTitle' => 'required',
            'videoFile' => 'required|mimetypes:video/*|max:512000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = auth()->user();

        if ($request->hasFile('videoFile')) {
            $videoFile = $request->file('videoFile');

            // Generate a unique name for the video file
            $fileName = uniqid() . '.' . $videoFile->getClientOriginalExtension();
            $oname = $videoFile->getClientOriginalName();

            $plan = Payment::where('user_id', $user->id)->where('stripe_payment_id', '!=', '')->first() ?? "";
            // Save the video file to the storage disk
            // $plan =  session()->get('plan') ?? $request->plan;
            $path = $videoFile->storeAs('videos/' . $plan->name, $fileName, 'public');

            // Create a new Video model instance
            $video = new Video();
            $video->user_id = $user->id;
            $video->plan_id = $plan->plan_id;
            $video->stripe_payment_id = $plan->stripe_payment_id;
            $video->file_path = $path;
            $video->original_name = $oname;
            $video->title = $request->videoTitle;
            $video->description = $request->videoDescription;
            $video->save();

            return redirect('/thank-you')->with('success', 'Video uploaded successfully.');
        }

        return redirect()->back()->withErrors(['message' => 'No video file found.'])->withInput();
    }
}
