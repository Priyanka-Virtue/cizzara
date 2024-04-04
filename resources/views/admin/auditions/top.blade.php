@extends('layouts.app-new')

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Contestants /</span><?php echo date('Y') ?></h4>
<hr class="my-5" />

<div class="card">
    <h5 class="card-header">Top contestants</h5>

    <div class="p-3">
        <div class="row">
            <div class="col-md-7">
                @include('partials.export-btns')
            </div>
            <div class="col-md-5">
                <form action="{{ route('admin.users.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" id="contestant" name="contestant" placeholder="Search by Contestant Name" aria-label="Search by Contestant Name" aria-describedby="button-addon2">
                        <button type="submit" name="submit" value="submit" class="btn btn-primary waves-effect" id="button-addon2">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-light">
                <tr>
                    <td><input class="form-check-input" type="checkbox" name="selectAll" id="selectAll" value="selectAll"></td>
                    <th>Contestant</th>
                    <th>Videos</th>

                    <th>Rating</th>
                    <th>Email</th>

                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($topUsers as $user)
                @php
                $user = App\Models\User::find($user['id']);
                @endphp
                <tr>
                    <td><input class="form-check-input" type="checkbox" name="selectedRecords[]" value="{{ $user->id }}"></td>
                    <td><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></td>
                    <td>
                        @php


                        $videoRatings = [];
                        foreach ($user->videos as $video) {

                        echo '<a href="'. route('admin.videos.show', $video) .'">' .$video->original_name.' </a>
                        <span class="badge rounded-pill bg-label-secondary">'.$video->style.'</span>
                        <br />';

                        $averageRating = $video->ratings->avg('rating');
                        $videoRatings[] = $averageRating;
                        }


                        if (count($videoRatings) > 1) {
                        $userAverageRating = array_sum($videoRatings) / count($videoRatings);
                        } else {
                        $userAverageRating = $videoRatings[0] ?? 0;
                        }
                        @endphp
                    </td>
                    <td>{{ $userAverageRating }}</td>
                    <td>{{ $user->email }}</td>


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
            {{ $paginatedTopUsers->appends(request()->input())->links() }}
        </div>
    </div>

</div>

@endsection

@section('bottom')
<script src="{{ asset('assets/js/export.js') }}"></script>
@endsection
