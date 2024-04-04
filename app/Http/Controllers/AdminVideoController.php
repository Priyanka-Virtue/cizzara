<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoRating;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
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
        $query->orderByRatings('asc');
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




    public function topList(Request $request)
    {
        $plan = Plan::where('name', 'SingTUV2024')->first();


        // Retrieve the top 3 users with their average ratings
        $topUsers = User::select('users.*', DB::raw('IFNULL(AVG(video_ratings.rating), 0) as average_rating'))
            ->leftJoin('videos', 'users.id', '=', 'videos.user_id')
            ->leftJoin('video_ratings', 'videos.id', '=', 'video_ratings.video_id')
            ->where('videos.plan_id', $plan->id)
            ->groupBy('users.id')
            ->orderByDesc('average_rating')
            ->take(3)
            ->get();

        // Manually create a LengthAwarePaginator instance for the top users
        $perPage = env('RECORDS_PER_PAGE', 10); // Set per page to 2 for the first page
        $currentPage = $request->query('page', 1);

        // Calculate the offset based on the current page
        $offset = ($currentPage - 1) * $perPage;

        // Get the items for the current page
        $items = collect(array_slice($topUsers->toArray(), $offset, $perPage));

        // Create a LengthAwarePaginator instance
        $paginatedTopUsers = new LengthAwarePaginator(
            $items,
            count($topUsers), // Total count of items
            $perPage, // Per page
            $currentPage // Current page
        );
        $topUsers = $items;

        $paginatedTopUsers->setPath($request->url());
        return view('admin.auditions.top', compact('paginatedTopUsers', 'topUsers'));
    }




    public function auditionList(Request $request)
    {
        $plan = Plan::where('name', 'SingTUV2024')->first();

        $query = User::withVideosByAudition($plan->id); //->get();

        $users = $query->paginate(2);
        return view('admin.auditions.index', compact('users'));
    }
}
