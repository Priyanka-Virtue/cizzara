@extends('layouts.app-new')

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Contestants /</span><?php echo date('Y') ?></h4>
<hr class="my-5" />

<div class="card">
    <h5 class="card-header">Top contestants</h5>

    <div class="p-3">
        <div class="row">
            <div class="col-md-4">
                @include('partials.export-btns')
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <select class="form-select status-dropdown-all" data-user-id="">
                    @foreach(config('app.audition_status') as $key => $value)
                            <option value="{{$value}}">{{$value}}</option>
                            @endforeach
                    </select>
                    <button class="btn btn-primary waves-effect" type="button">Move selected to</button>
                </div>
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
                    <th>Action</th>
                    <th>Rating</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Birthdate</th>
                    <th>Education</th>
                    <th>Occupation</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zip</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">

                @forelse ($topUsers as $user)
                @php
                $user = App\Models\User::where('id',$user['id'])->with('details')->first();
                @endphp
                <tr>
                    <td><input class="form-check-input" type="checkbox" name="selectedRecords[]" value="{{ $user->id }}"></td>
                    <td><a href="{{ route('admin.users.show', $user) }}">{{ $user->details->first_name . ' ' . $user->details->last_name }}</a></td>
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

                        //$status = $video->audition;


                        @endphp
                    </td>
                    <td>


                        <select style="min-width: 110px;" class="form-select status-dropdown" data-plan="{{ $audition }}" data-user="{{ $user->id }}">
                            @foreach(config('app.audition_status') as $key => $value)
                            <option value="{{$value}}">{{$value}}</option>
                            @endforeach
                        </select>


                    </td>
                    <td>{{ $userAverageRating }}</td>
                    <td>{{ $user->email }}</td>

                    <td>{{ $user->details->phone }}</td>
                    <td>{{ $user->details->date_of_birth }}</td>
                    <td>{{ $user->details->education }}</td>
                    <td>{{ $user->details->occupation }}</td>
                    <td>{{ $user->details->city }}</td>
                    <td>{{ $user->details->state }}</td>
                    <td>{{ $user->details->pin_code }}</td>
                    <td>{{ $user->details->address }}</td>


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
<script>
    $(document).ready(function() {
        $('.status-dropdown').change(function() {
            var userId = $(this).data('user');
            var auditionId = $(this).data('plan');
            var newStatus = $(this).val();
            console.log(newStatus, auditionId, userId);
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.auditions.updateStatus') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    status: newStatus,
                    audition: auditionId,
                    user: userId,
                },
                success: function(response) {
                    Toast.fire({
    icon: 'success',
    title: 'Status updated successfully',
  });
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    Toast.fire({
    icon: 'Error',
    title: 'Could not update status',
  });
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
