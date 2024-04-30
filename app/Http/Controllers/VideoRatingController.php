<?php

namespace App\Http\Controllers;

use App\Models\Audition;
use App\Models\Plan;
use App\Models\User;
use App\Models\Video;
use App\Notifications\GurusCommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VideoRatingController extends Controller
{
    public function countAvg(Request $request, $video = null)
    {
        // $plan = Plan::find(1);

        // if ($request->audition != "") {
        //     $plan = Plan::where('name', $request->audition)->first();
        // } else {
        //     $plan = Plan::latest()->first();
        // }

        $audition = Audition::where('id', $video->audition_id)->with(['user.videos.ratings' => function ($query) {
            // $query->withCount('ratings');
        }])->first();
// $rates = [];
        // dd($audition->user->videos);
        $plan = $video->plan;
        $gurus = User::whereIn('id', $plan->gurus ?? [])->get();
        foreach ($gurus ?? [] as $guru) {

            $ratedGurusCount[$guru->id] = 0;
            $sumRatingByVideos[$guru->id] = 0;

            foreach ($audition->user->videos as $uvideo) {
                // echo($uvideo->id . '<br>');
                foreach ($uvideo->ratings as $guru_rating) {

                    if ($guru_rating->guru_id == $guru->id) {
                        // $rates[] = $guru_rating->toArray($guru_rating);
                        $ratedGurusCount[$guru->id] += 1;
                        $sumRatingByVideos[$guru->id] += $guru_rating->rating;
                    }
                }
            }
        }

        $totl = 0;
        $totalRatedGurus = 0;
        foreach ($sumRatingByVideos ?? []  as $guru => $guruTotal) {

            if ($guruTotal != 0 && $ratedGurusCount[$guru] != 0) {
                $totl += ($guruTotal / $ratedGurusCount[$guru]);
                $totalRatedGurus++;
            }
        }

        // dd($rates, $ratedGurusCount, $sumRatingByVideos,  $totl, $totalRatedGurus);
        //print_r($ratedGurusCount);
        //echo '<br>'.$totl;
        //echo '<br>'.$totalRatedGurus;
        if($totl > 0 && $totalRatedGurus > 0)
        return number_format((float) $totl / $totalRatedGurus, 2);


        Log::info('dbg', [ $ratedGurusCount, $sumRatingByVideos,  $totl, $totalRatedGurus]);
        return 0; 

    }

    public function rateVideo(Request $request, $videoId)
    {

        $user = auth()->user();

        if (!$user->hasRole('guru')) {
            return redirect()->back()->with('error', 'You do not have permission to rate videos.');
        }

        // Find the video
        $video = Video::findOrFail($videoId);

        // Find the associated plan
        $plan = $video->plan;

        // Check if the guru is associated with the plan
        // if (!$plan->gurus()->where('guru_id', $user->id)->exists()) {
        // if (!Plan::where('id', $plan->id)->whereJsonContains('gurus', $user->id)->exists()) {
        //     return redirect()->back()->with('error', 'You are not authorized to rate videos for this audition.');
        // }

        // Validate request data
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|between:1,10'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find the video
        // $video = Video::findOrFail($videoId);

        // Create a new video rating
        $video->ratings()->create([
            'guru_id' => $user->id,
            'rating' => $request->rating,
            'comments' => $request->comments,
        ]);

        $averageRating = $this->countAvg($request, $video);
        // $averageRating = $video->ratings()->avg('rating');

        // Update the audition table with the calculated average rating for that video
        $audition = Audition::find($video->audition_id);
        $audition->avg_rating = $averageRating;
        $audition->save();

        // $allVideos = $audition->videos;
        // $totalRatings = 0;
        // $totalVideos = count($allVideos);
        // foreach ($allVideos as $v) {
        //     $totalRatings += $v->ratings()->avg('rating');
        // }
        // $overallAverageRating = $totalRatings / $totalVideos;
        // // dd($overallAverageRating);
        // $audition->overall_average_rating = $overallAverageRating;
        // $audition->save();


        if ($request->comments != "" && ($request->send_to_contestant != "")) {
            $contestant = User::find($video->user_id);
            $contestant->notify(new GurusCommentNotification($request->comments));
        }


        return redirect()->route('admin.auditions.index')->with('success', 'Video rated successfully.');
    }
}
