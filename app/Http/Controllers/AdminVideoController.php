<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminVideoController extends Controller
{
    public function index(Request $request)
    {
        $query = Video::with('user');

        if (empty($request->submit)) {
            $query->where('state', '!=', 'rejected');
        } else {
            if ($request->has('status') && !empty($request->status)) {
                $query->where('state', $request->status);
            }

            if ($request->has('contestant') && !empty($request->contestant)) {
                $query->whereHas('user', function ($userQuery) use ($request) {
                    $userQuery->where('name', 'like', '%' . $request->contestant . '%');
                });
            }
        }

        $videos = $query->paginate(2);

        return view('admin.videos', compact('videos'));
    }
    public function show(Video $video)
    {
        $video->auditionDetails = $video->auditionDetails();
        return view('admin.show', compact('video'));
    }

    public function user($user_id)
    {
        $user = User::where('id', $user_id)->with('details')->first();
        return view('admin.users.show', compact('user'));
    }

    public function updateStatus(Request $request, Video $video)
    {
        $request->validate([
            'status' => 'required|in:pending,top-500,top-10,rejected',
        ]);
        $video->state = $request->status;
        $video->save();

        return redirect()->route('admin.videos.index')->with('success', 'Video status updated successfully.');
    }



    public function userList(Request $request)
    {
        $query = User::where('id', '!=', auth()->user()->id);

        if ($request->has('contestant') && !empty($request->contestant)) {
            $query->whereHas('details', function ($userQuery) use ($request) {
                $userQuery->where('first_name', 'like', '%' . $request->contestant . '%')
                    ->orWhere('last_name', 'like', '%' . $request->contestant . '%');
            });
        } else {
            $query->whereHas('details');
        }
        $users = $query->paginate(2);
        return view('admin.users.index', compact('users'));
    }


    // public function rateVideo(Request $request, $videoId)
    // {
    //     $user = auth()->user();

    //     // Check if the user is a guru
    //     if (!$user->hasRole('guru')) {
    //         return redirect()->back()->with('error', 'You do not have permission to rate videos.');
    //     }

    //     // Find the video
    //     $video = Video::findOrFail($videoId);

    //     // Find the associated plan
    //     $plan = $video->plan;

    //     // Check if the guru is associated with the plan
    //     if (!$plan->gurus()->where('guru_id', $user->id)->exists()) {
    //         return redirect()->back()->with('error', 'You are not authorized to rate videos for this plan.');
    //     }

    //     // Validate the rating
    //     $validator = Validator::make($request->all(), [
    //         'rating' => 'required|integer|between:1,10',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     // Store the rating
    //     $video->ratings()->create([
    //         'guru_id' => $user->id,
    //         'rating' => $request->rating,
    //     ]);

    //     return redirect()->back()->with('success', 'Video rated successfully.');
    // }
}
