@extends('layouts.app-new')

@section('content')

<div class="row">
    <div class="col-md-8">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Auditions /</span><?php echo date('Y') ?></h4>
    </div>
    <div class="col-md-4">
        <form action="{{ route('admin.auditions.index') }}" method="GET">
            <div class="input-group">
                <select name="audition" style="min-width: 110px;" class="form-select form-select-lg">
                    @foreach($plans as $p)
                    <option value="{{$p->name}}" @if($p->name==request()->audition) selected @endif >{{$p->name}}</option>
                    @endforeach
                </select>
                <!-- <select name="status" style="min-width: 110px;" class="form-select">
                    <option value="">All</option>
                    @foreach(config('app.audition_status') as $key => $value)
                    <option value="{{$value}}" @if($value==request()->status) selected @endif >{{$value}}</option>
                    @endforeach
                </select> -->

                <button type="submit" class="btn btn-primary waves-effect" type="button">Filter</button>
            </div>
        </form>
    </div>

</div>
<hr class="mt-0" />

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
                @forelse ($auditions as $audition)
                <tr>
                @role('admin')<td><input class="form-check-input" type="checkbox" name="selectedRecords[]" value="{{ $audition->user->id }}"></td>
                <td>
                        <a href="{{ route('admin.users.show', $audition->user) }}">{{ $audition->user->details->first_name.' '.$audition->user->details->last_name }}</a>
                    </td>
                @endrole
                @role('guru')
                    <td>
                        {{ $audition->user->details->first_name.' '.$audition->user->details->last_name }}
                    </td>
                    @endrole
                    <td>
                    @php
                        $guruRatings = [];
                        $videoRatings = [];

                        foreach ($audition->user->videos as $video) {

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
                    <td>{{ $audition->user->email }}</td>



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
            {{ $auditions->appends(request()->input())->links() }}
        </div>
    </div>

</div>

@endsection
@section('bottom')
<script src="{{ asset('assets/js/export.js') }}"></script>
@endsection
