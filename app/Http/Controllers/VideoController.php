<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\Audition;
use App\Models\UserDetail;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
// use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use Illuminate\Filesystem\AwsS3V3Adapter;
class VideoController extends Controller
{
    public function index(Request $request)
    {

        $plan_id = Plan::where('name', $request->plan)->first()->id ?? null;
        $user_id = Auth::id();

        // $is_paid = Payment::where('user_id', $user_id)->where('plan_id', '=', $plan_id)->where('status', '=', 'COMPLETED')->exists();
        // if (!$is_paid)
        //     return redirect()->route('goToPayment', ['plan' => $request->plan])->with('error', 'You need to make payment first');



        if ($request->has('step') && $request->step == 'profile') {
            $userDetail = UserDetail::where('user_id', Auth::id())->first();
            return view('details', compact('userDetail'));
        } else if ($request->has('step') && $request->step == 'audition') {
            $userDetail = Audition::where('user_id', Auth::id())->where('plan_id', '=', $plan_id)->first();
            $payment = Payment::where('user_id', Auth::user()->id)->where('plan_id', $plan_id)->where('status', '=', 'COMPLETED')->first();

if(!$payment) {
    return redirect()->route('goToPayment', ['plan' => $request->plan])->with('error', 'You need to make payment first');
}
            return view('audition', compact('userDetail', 'payment'));
        } else {
            $audition = Audition::where('plan_id', $plan_id)->where('user_id', $user_id)->first();
            if ($audition) {
                if ($audition->status == 'disqualified') {
                    return view('thanks');
                }
                $videos = Video::where('user_id', $user_id)->where('plan_id', $plan_id)->where('status', $audition->status)->get();
                if (count($videos) >= env('MAX_VIDEO_FILE_UPLOAD')) {
                    return view('thanks');
                }
            }


            $hasUserDetails = UserDetail::where('user_id', $user_id)->exists();

            if ($hasUserDetails && $audition)
                return view('upload-video');
            else if ($hasUserDetails) {
                $userDetail = $audition;
                $payment = Payment::where('user_id', Auth::user()->id)->where('plan_id', $plan_id)->where('status', '=', 'COMPLETED')->first();
                if(!$payment) {
                    return redirect()->route('goToPayment', ['plan' => $request->plan])->with('error', 'You need to make payment first');
                }
                return view('audition', compact('userDetail', 'payment'));
            }
        }




        $userDetail = UserDetail::where('user_id', Auth::id())->first();
        return view('details', compact('userDetail'));
    }
    // public function index(Request $request)
    // {

    //     $plan_id = Plan::where('name', $request->plan)->first()->id ?? null;
    //     $user_id = Auth::id();

    //     if ($plan_id) {
    //         $uploaded_videos_count = Payment::where('payments.user_id', $user_id)
    //             ->where('payments.payment_id', '!=', '')
    //             ->where('payments.plan_id', '=', $plan_id)
    //             ->join('videos', 'payments.payment_id', '=', 'videos.payment_id')
    //             ->count();

    //         // Allow up to 2 video uploads
    //         if ($uploaded_videos_count >= 2) {
    //             return view('thanks');
    //         }
    //     }

    //     if ($request->has('step') && $request->step == 'profile') {
    //         $userDetail = UserDetail::where('user_id', Auth::id())->first();
    //         return view('details', compact('userDetail'));
    //     } else if ($request->has('step') && $request->step == 'audition') {
    //         if ($plan_id) {


    //             $userDetail = Audition::where('user_id', Auth::id())->where('plan_id', '=', $plan_id)->first();
    //         } else {
    //             $plan = Payment::where('user_id', $user_id)->where('payment_id', '!=', '')->first()->plan_id ?? '';

    //             $userDetail = Audition::where('user_id', Auth::id())->where('plan_id', '=', $plan)->first();
    //         }
    //         return view('audition', compact('userDetail'));
    //     } else {

    //         $plan = Payment::where('user_id', $user_id)->where('payment_id', '!=', '')->first()->plan_id ?? '';

    //         $hasUserDetails = UserDetail::where('user_id', $user_id)->exists();
    //         $hasAudition = Audition::where('user_id', $user_id)->where('plan_id', $plan)->exists();

    //         $uploaded_videos_count = Payment::where('payments.user_id', $user_id)
    //             ->where('payments.payment_id', '!=', '')
    //             ->where('payments.plan_id', '=', $plan)
    //             ->join('videos', 'payments.payment_id', '=', 'videos.payment_id')
    //             ->count();

    //         if ($uploaded_videos_count >= 2) {

    //             return view('thanks');
    //         } else if ($hasUserDetails && $hasAudition)
    //             return view('upload-video');
    //         else if ($hasUserDetails) {
    //             $userDetail = Audition::where('user_id', Auth::id())->where('plan_id', '=', $plan)->first();
    //             return view('audition', compact('userDetail'));
    //         }
    //     }

    //     $userDetail = UserDetail::where('user_id', Auth::id())->first();
    //     return view('details', compact('userDetail'));
    // }
    public function upload(Request $request)
    {
        $user = auth()->user();
        if (!empty($request->plan)) {
            $plan = Plan::where('name', $request->plan)->first();
            $payment = Payment::where('user_id', $user->id)->where('plan_id', $plan->id)->where('payment_id', '!=', '')->where('status', '=', 'COMPLETED')->first();
        } else {
            $payment = Payment::where('user_id', $user->id)->where('payment_id', '!=', '')->where('status', '=', 'COMPLETED')->latest()->first() ?? "";
            $plan = Plan::find($payment->plan_id);
        }

        if (!$plan || !$payment) {
            return redirect()->back()->with('error', 'No plan found #P404');
        }

        $audition = Audition::where('plan_id', $plan->id)->where('user_id', $user->id)->first();

        #TODO: Disable validation and add to S3 Bucket
        $validator = Validator::make(
            $request->all(),
            [

                'videoDescription' => 'required',
                'videoFile' => [
                    'required',
                    'mimetypes:video/*',
                    'max:100000',

                ],
            ],

        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $path = $request->filePath;
        $oname = $request->oname;
        $video = new Video();
        $video->user_id = $user->id;
        $video->plan_id = $plan->id;
        $video->payment_id = $payment->payment_id;
        $video->file_path = $path;
        $video->original_name = $oname;
        $video->title = $request->videoTitle;

        $video->status = $audition->status;
        $video->audition_id = $audition->id;
        $video->description = $request->videoDescription;
        $video->save();
        $successMessage = "Video uploaded successfully, you will be notified once it is qualified or disqualified for next round.";
        session()->flash('success', $successMessage);
        return response()->json(['success' => true, 'message' => $successMessage], 200);



        // if ($request->hasFile('videoFile')) {
        //     $videoFile = $request->file('videoFile');

        //     $fileName = uniqid() . '.' . $videoFile->getClientOriginalExtension();
        //     $oname = $videoFile->getClientOriginalName();

        //     $path = $videoFile->storeAs('videos/' . $plan->name, $fileName, 'public');

        //     $folder = $plan->name;

        //     /* $path = $videoFile->storeAs(
        //         $folder,
        //         $fileName,
        //         's3'
        //     );*/

        //     $video = new Video();
        //     $video->user_id = $user->id;
        //     $video->plan_id = $plan->id;
        //     $video->payment_id = $payment->payment_id;
        //     $video->file_path = $path;
        //     $video->original_name = $oname;
        //     $video->title = $request->videoTitle;

        //     $video->status = $audition->status;
        //     $video->audition_id = $audition->id;
        //     $video->description = $request->videoDescription;
        //     $video->save();

        //     return redirect()->route('thank-you')->withInput()->with('success', 'Video uploaded successfully, you will be notified once it is qualified or disqualified for next round.');
        // }

        return redirect()->back()->withErrors(['message' => 'No video file found.'])->withInput();
    }


    public function generatePreSignedUrl(Request $request)
    {
        $folder = $request->plan;
        $fileExtension =  $request->fileExtension ?? 'mp4';
        $filePath = $folder.'/'.uniqid() . '-' .time().'.'.$fileExtension; // Set your file path here

        $client = Storage::disk('s3')->getClient();
        $command = $client->getCommand('PutObject', [
            'Bucket' => env('AWS_BUCKET'),
            'Key'    => $filePath,
            'ACL'    => 'public-read',
        ]);
        $request = $client->createPresignedRequest($command, '+20 minutes');
        $preSignedUrl = (string) $request->getUri();

        return response()->json(['url' => $preSignedUrl, 'filePath' => $filePath]);
    }
}
