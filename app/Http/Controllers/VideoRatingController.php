<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideoRatingController extends Controller
{
    public function rateVideo(Request $request, $videoId)
    {

        $user = auth()->user();

        // if (!$user->hasRole('guru')) {
        //     return redirect()->back()->with('error', 'You do not have permission to rate videos.');
        // }

        // // Find the video
        // $video = Video::findOrFail($videoId);

        // // Find the associated plan
        // $plan = $video->plan;

        // // Check if the guru is associated with the plan
        // if (!$plan->gurus()->where('guru_id', $user->id)->exists()) {
        //     return redirect()->back()->with('error', 'You are not authorized to rate videos for this plan.');
        // }

        // Validate request data
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|between:1,10',
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
        ]);

        return redirect()->back()->with('success', 'Video rated successfully.');
    }
}
