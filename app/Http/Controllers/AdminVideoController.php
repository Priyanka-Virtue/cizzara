<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoRating;
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



    public function audition($user_id)
    {
        // $plan = Plan::where('name', 'SingTUV2024');
        // $auditions = Video::where('plan_id', $plan->id)->orderBy('user_id')->get();
        // dd($auditions);
        $user = User::where('id', $user_id)->with('details')->first();
        return view('admin.users.show', compact('user'));
    }
    public function auditionList(Request $request)
    {
        $plan = Plan::where('name', 'SingTUV2024')->first();
        // dd($plan);
        // $query = User::doesntHave('roles')->withVideosByAudition($plan->id);
        $query = User::withVideosByAudition($plan->id);//->get();


        // foreach ($usersWithVideos as $user) {
        //     echo "User: {$user->name}\n";
        //     foreach ($user->videos as $video) {
        //         echo "- Video: {$video->title}\n";
        //         foreach ($video->ratings as $rating) {
        //             echo "-- Rating: {$rating->rating}\n";
        //         }
        //     }
        // }
        // dd('done');
        // $auditions = Video::where('plan_id', $plan->id)->orderBy('user_id')->get();
        // dd($auditions);


        // if ($request->has('contestant') && !empty($request->contestant)) {
        //     $query->whereHas('details', function ($userQuery) use ($request) {
        //         $userQuery->where('first_name', 'like', '%' . $request->contestant . '%')
        //             ->orWhere('last_name', 'like', '%' . $request->contestant . '%');
        //     });
        // } else {
        //     $query->whereHas('details');
        // }
        $users = $query->paginate(2);
        return view('admin.auditions.index', compact('users'));
    }

    // public function auditionList(Request $request)
    // {
    //     $plan = Plan::where('name', 'SingTUV2024')->first();

    //     $query = User::withVideosByAudition($plan->id);//->get();

    //     $users = $query->paginate(2);
    //     return view('admin.auditions.index', compact('users'));
    // }
}
