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
    public function rateVideo(Request $request, $videoId)
    {

        $user = auth()->user();

        // if (!$user->hasRole('guru')) {
        //     return redirect()->back()->with('error', 'You do not have permission to rate videos.');
        // }

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
        $video = Video::findOrFail($videoId);

        // Create a new video rating
        $video->ratings()->create([
            'guru_id' => $user->id,
            'rating' => $request->rating,
            'comments' => $request->comments,
        ]);

        $averageRating = $video->ratings()->avg('rating');

    // Update the audition table with the calculated average rating for that video
    $audition = Audition::findOrFail($video->audition_id);
    $audition->avg_rating = $averageRating;
    $audition->save();

    $allVideos = $audition->videos;
    $totalRatings = 0;
    $totalVideos = count($allVideos);
    foreach ($allVideos as $v) {
        $totalRatings += $v->ratings()->avg('rating');
    }
    $overallAverageRating = $totalRatings / $totalVideos;
    // dd($overallAverageRating);
    $audition->overall_average_rating = $overallAverageRating;
    $audition->save();


        if($request->comments != "" && ( $request->send_to_contestant != "")) {
            $contestant = User::find($video->user_id);
            $contestant->notify(new GurusCommentNotification($request->comments));
        }


        return redirect()->route('admin.auditions.index')->with('success', 'Video rated successfully.');
    }
}
