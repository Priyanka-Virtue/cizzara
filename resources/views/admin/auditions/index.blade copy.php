@extends('layouts.app-new')

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Auditions /</span><?php echo date('Y') ?></h4>
<hr class="my-5" />

<div class="card">
    <h5 class="card-header">All Entries</h5>
    <div class="p-3">
        <div class="row">
            @role('admin')
            <div class="col-md-7">
                @include('partials.export-btns', ['exportAction' => route('export.audition')])
            </div>
            @endrole
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
                @role('admin') <td><input class="form-check-input" type="checkbox" name="selectAll" id="selectAll" value="selectAll"></td> @endrole
                    <th>Contestant</th>
                    <th>Videos</th>

                    @role('guru')<th>Rating</th>@endrole
                    @role('admin')<th>Guru's Avg. Rating</th>@endrole

                    <th>Email</th>

                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($users as $user)
                <tr>
                @role('admin')<td><input class="form-check-input" type="checkbox" name="selectedRecords[]" value="{{ $user->id }}"></td>@endrole
                    <td><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></td>
                    <td>
                        @php
                        $guruRatings = [];
                        $videoRatings = [];
                        foreach ($user->videos as $video) {

                            $guruRatings[] = $video->guruRatings->rating ?? 'N/A'.' / 10 ';

                        echo '<a href="'. route('admin.videos.show', $video) .'">' .$video->original_name.' </a>
                        <span class="badge rounded-pill bg-label-secondary">'.$video->style.'</span>
                        <br/>';

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

                    @role('guru')
                    <td>@foreach($guruRatings as $rating)
                        {{ $rating }} <br/>
                        @endforeach
                    </td>
                    @endrole
                    @role('admin')
                    <td>{{ $userAverageRating }}</td>
                    @endrole
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
            {{ $users->appends(request()->input())->links() }}
        </div>
    </div>

</div>

@endsection
@section('bottom')
<script src="{{ asset('assets/js/export.js') }}"></script>
@endsection
