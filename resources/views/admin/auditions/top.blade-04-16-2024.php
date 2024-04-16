@extends('layouts.app-new')

@section('content')


<div class="row">
    <div class="col-md-6">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Contestants /</span><?php echo date('Y') ?></h4>
    </div>
    <div class="col-md-6">
        <form action="{{ route('admin.auditions.top') }}" method="GET">
            <div class="input-group">
                <select name="audition" style="min-width: 110px;" class="form-select form-select-lg">
                    @foreach($plans as $p)
                    <option value="{{$p->name}}" @if($p->name==request()->audition) selected @endif >{{$p->name}}</option>
                    @endforeach
                </select>
                <select name="status" style="min-width: 110px;" class="form-select">
                    <option value="">All</option>
                    @foreach(config('app.audition_status') as $key => $value)
                    <option value="{{$value}}" @if($value==request()->status) selected @endif >{{$value}}</option>
                    @endforeach
                </select>
                <select name="sort" style="min-width: 50px;" class="form-select">
                    <option value="highest-rating">Sort Highest Rating</option>
                    <option value="lowest-rating">Sort Lowest Rating</option>
                    <option value="pending-rating">Sort Pending to Rate</option>
                    <option value="has-comments">Sort Has comments</option>
                </select>

                <button type="submit" class="btn btn-primary waves-effect" type="button">Filter</button>
            </div>
        </form>
    </div>

</div>
<hr class="mt-0" />

<div class="card">

    <h5 class="card-header">Top contestants</h5>

    <div class="p-3">
        <div class="row">
            <div class="col-md-5">
                @include('partials.export-btns')
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <button id="btn-move" class="btn btn-primary waves-effect" type="button">Move selected to</button>
                    <select id="status-dropdown-all" class="form-select status-dropdown-all">
                        @foreach(config('app.audition_status') as $key => $value)
                        <option value="{{$value}}">{{$value}}</option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="col-md-3">
                <form action="{{ route('admin.users.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" id="contestant" name="contestant" placeholder="Search by Contestant Name" aria-label="Search by Contestant Name" aria-describedby="button-addon2">
                        <button type="submit" name="submit" value="submit" class="btn btn-primary waves-effect" id="button-addon2">Search</button>
                    </div>
                </form>
            </div>
            <div class="col-md-1 d-flex justify-content-end">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary btn-icon rounded-pill dropdown-toggle hide-arrow waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-account-reactivate mdi-24px" data-bs-toggle="tooltip" data-bs-placement="auto" title="Send Rating Reminder"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="">
                        @foreach($gurus ?? [] as $guru)

                        <li><a class="dropdown-item waves-effect" href="javascript:void(0);" onclick="$(this).sendRatingReminder({{$guru->id}})">{{$guru->name}}</a></li>
                        @endforeach


                    </ul>
                </div>
            </div>

        </div>


        <!-- <div class="row mt-2">
            <div class="col-md-2">
                <select name="sort" style="min-width: 50px;" class="form-select">
                    <option value="highest-rating">Highest Rating</option>
                    <option value="lowest-rating">Lowest Rating</option>
                    <option value="pending-rating">Pending to Rate</option>
                    <option value="comments">Has comments</option>
                </select>
            </div>
        </div> -->
    </div>


    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-light">
                <tr>
                    <td><input class="form-check-input" type="checkbox" name="selectAll" id="selectAll" value="selectAll"></td>
                    <th>Contestant</th>
                    <th>Videos</th>
                    <th>Action</th>
                    @foreach($gurus ?? [] as $guru)
                    <th>{{$guru->name}}</th>
                    @endforeach
                    <th>Avg Rating</th>
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

                @forelse ($topUsers as $audition)
                @php
                $prefix = 'DS';
                $season = 'S01';
                if($audition->plan_id == 1){
                $prefix = 'SS';
                }

                $zeros = 3 - strlen($audition->id);
                $zeros = str_repeat("0",$zeros);
                $planName = App\Models\Plan::where('id',$audition->plan_id)->first()->name;


                $rowno = $prefix.$season.$zeros.$audition->id;
                @endphp
                <tr>
                    <td><input data-plan="{{ $audition->plan_id }}" data-user="{{ $audition->user->id }}" class="form-check-input" type="checkbox" name="selectedRecords[]" value="{{ $audition->id }}">&nbsp; {{ $rowno }}</td>
                    <td><a href="{{ route('admin.users.show', $audition->user) }}">{{ $audition->user->details->first_name . ' ' . $audition->user->details->last_name }}</a></td>



                    <td>
                        @php
                        $videoRatings = [];

                        foreach ($audition->user->videos as $video) {


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

                    <td>
                        <select style="min-width: 110px;" class="form-select status-dropdown" data-plan="{{ $audition->plan_id }}" data-user="{{ $audition->user->id }}">
                            @foreach(config('app.audition_status') as $key => $value)
                            <option value="{{$value}}" @if($value==$audition->status) selected @endif >{{$value}}</option>
                            @endforeach
                        </select>
                    </td>
                    @foreach($gurus ?? [] as $guru)
                    <td>
                        @foreach ($audition->user->videos as $video)
                        @foreach($video->ratings as $guru_rating)
                        @if($guru_rating->guru_id == $guru->id)
                        <a href="{{ route('admin.videos.show-by-guru', ['video'=>$video, 'guru'=>$guru ]) }}">{{$guru_rating->rating}}</a>
                        @if($guru_rating->comments != "")
                        <i class="mdi mdi-comment" data-bs-toggle="tooltip" data-bs-placement="auto" title="{{$guru_rating->comments}}">
                        </i>
                        @endif
                        @endif
                        @php
                        $ratedGurus[] = $guru_rating->guru_id;
                        @endphp
                        @endforeach
                        @if(in_array($guru->id, $ratedGurus) == false)
                        &mdash;
                        @endif
                        <br />
                        @endforeach
                    </td>
                    @endforeach
                    <td>{{ $userAverageRating }}</td>
                    <td>{{ $audition->user->email }}</td>

                    <td>{{ $audition->user->details->phone }}</td>
                    <td>{{ $audition->user->details->date_of_birth }}</td>
                    <td>{{ $audition->user->details->education }}</td>
                    <td>{{ $audition->user->details->occupation }}</td>
                    <td>{{ $audition->user->details->city }}</td>
                    <td>{{ $audition->user->details->state }}</td>
                    <td>{{ $audition->user->details->pin_code }}</td>
                    <td>{{ $audition->user->details->address }}</td>


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
            {{$topUsers->appends(request()->input())->links()}}
        </div>
    </div>

</div>

@endsection

@section('bottom')
<script src="{{ asset('assets/js/export.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.status-dropdown').change(function() {

            var userIds = [],
                auditionIds = [];
            userIds.push($(this).data('user'));
            auditionIds.push($(this).data('plan'));

            var newStatus = $(this).val();


            moveSelectedTo(newStatus, userIds, auditionIds)


        });

        $.fn.sendRatingReminder = function(guruId) {
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.gurus.send-rating-reminder') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    guru_id: guruId
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message,
                    });
                },
                error: function(xhr, status, error) {
                    Toast.fire({
                        icon: 'error',
                        title: error,
                    });

                }
            })
        }

        $('#btn-move').click(async function(e) {
            e.preventDefault();
            var userIds = [],
                auditionIds = [];
            $('input[name="selectedRecords[]"]:checked').each(function() {
                userIds.push($(this).data('user'));
                auditionIds.push($(this).data('plan'));
            });
            if (userIds.length == 0) {
                Toast.fire({
                    icon: 'error',
                    title: 'Select at least one checkbox',
                });
                return;
            }
            var newStatus = $("#status-dropdown-all").val();
            try {
                await moveSelectedTo(newStatus, userIds, auditionIds);
                window.location.replace(window.location.href);
            } catch (error) {
                console.error(error);
                Toast.fire({
                    icon: 'error',
                    title: 'Could not update status',
                });
            }
        });

        function moveSelectedTo(newStatus, userIds, auditionIds) {
            console.log(newStatus, auditionIds, userIds);
            return new Promise(function(resolve, reject) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.auditions.updateStatus') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus,
                        audition: auditionIds,
                        user: userIds,
                    },
                    success: function(response) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Status updated successfully',
                        });
                        resolve(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        reject(error);
                    }
                });
            });
        }
    });
</script>
@endsection
