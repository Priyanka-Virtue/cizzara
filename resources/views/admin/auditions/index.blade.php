@extends('layouts.app-new')

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Users /</span><?php echo date('Y') ?></h4>
<hr class="my-5" />

<div class="card">
    <h5 class="card-header">Show Users</h5>
    <form action="{{ route('admin.users.index') }}" method="GET">
        <div class="p-3">
            <div class="row">


                <div class="col-md-4">
                    <div class="form-group">
                        <label for="contestant">Search by Contestant Name:</label>
                        <input type="text" class="form-control" id="contestant" name="contestant" placeholder="Enter User Name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">

                        <button type="submit" name="submit" value="submit" class="btn btn-primary btn-block mt-4">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th>Contestant</th>
                    <th>Videos</th>

                    <th>Rating</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($users as $user)
                <tr>
                    <td><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></td>
                    <td>
                        @php


                        $videoRatings = [];
                        foreach ($user->videos as $video) {
                        //echo "<br>- Video: {$video->id} ";
                        echo '<a href="'. route('admin.videos.show', $video) .'">' .$video->original_name.' </a>
                        <span class="badge rounded-pill bg-label-secondary">'.$video->style.'</span>
                        <br/>';
                        foreach ($video->ratings as $rating) {
                        //echo "<br>";

                        // echo "-- Rating: {$rating->rating}\n";
                        //echo "-- Guru: {$rating->guru_id}\n";
                        }
                        $averageRating = $video->ratings->avg('rating');
                        $videoRatings[] = $averageRating;
                        }

                        // If the user has two videos, combine their average ratings into one
                        if (count($videoRatings) > 1) {
                        $userAverageRating = array_sum($videoRatings) / count($videoRatings);
                        } else {
                        $userAverageRating = $videoRatings[0] ?? 0;
                        }
                        @endphp
                    </td>
                    <td>{{ $userAverageRating }}</td>
                    <td>{{ $user->email }}</td>

                    <td>
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-primary">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">No records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="justify-content-center">
        <div class="col-md-6 mx-auto">
            <hr />
            {{ $users->appends(request()->input())->links() }}
        </div>
    </div>

</div>

@endsection
