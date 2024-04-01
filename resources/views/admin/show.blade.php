@extends('layouts.app-new')

@section('content')
<style>
    input:not(button)[disabled],
    textarea[disabled],
    select[disabled] {
        border: none !important;
        background: transparent !important;
    }

    label::after {
        background: none !important;
    }

    textarea {
        resize: none;
    }
</style>
<div class="row">
    <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
        <!-- User Card -->
        <div class="card mb-4">
            <div class="card-body">

                @if (session('succcess'))
                <div class="alert alert-success" role="alert">
                    {{ session('succcess') }}
                </div>
                @endif
                <h5 class="pb-3 border-bottom mb-3">Details</h5>
                <div class="info-container">
                    <ul class="list-unstyled mb-4">
                        <li class="mb-3">
                            <span class="h6">Title:</span>
                            <span>{{ $video->title }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="h6">Description:</span>
                            <span>{{ $video->description }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="h6">Upload Time:</span>
                            <span>{{ $video->created_at->format('Y-m-d H:i:s') }}</span>
                        </li>


                        <li class="mb-3">
                            <span class="h6">StageName:</span>
                            <span>{{$video->auditionDetails->stagename}}</span>
                        </li>
                        <li class="mb-3">
                            <span class="h6">Audition city:</span>
                            <span>{{$video->auditionDetails->auditioncity}}</span>
                        </li>
                        <li class="mb-3">
                            <span class="h6">Genre of Singing:</span>
                            <span>{{$video->auditionDetails->genre_of_singing}}</span>
                        </li>


                    </ul>
                    @role('admin')
                    <hr />
                    <ul class="list-unstyled mb-4">
                        <li class="mb-3">
                            <span class="h6">Contestant Name:</span>
                            <span><a href="{{ route('admin.users.show', $video->user) }}"> {{ $video->user->name }} </a></span>
                        </li>
                        <li class="mb-3">
                            <span class="h6">Email:</span>
                            <span>{{$video->user->email}}</span>
                        </li>
                        <li class="mb-3">
                            <span class="h6">Status:</span>
                            <span class="badge bg-label-success rounded-pill text-uppercase">{{$video->state}}</span>
                        </li>


                        <li class="mb-3">
                            <span class="h6">Contact:</span>
                            <span>(123) 456-7890</span>
                        </li>
                        <li class="mb-3">
                            <span class="h6">Languages:</span>
                            <span>French</span>
                        </li>
                        <li class="mb-3">
                            <span class="h6">Country:</span>
                            <span>United Kingdom</span>
                        </li>
                    </ul>
                    @endrole

                    <div class="d-grid w-100 mt-4">
                        <form action="{{ route('admin.videos.updateStatus', $video) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- <div class="input-group">
                            <select class="form-select" id="inputGroupSelect03" id="status" name="status" aria-label="status">
                            <option value="pending" @if ($video->state == 'pending') selected @endif>Pending</option>
                                    <option value="round-1" @if ($video->state == 'round-1') selected @endif>Round 1</option>
                                    <option value="round-2" @if ($video->state == 'round-2') selected @endif>Round 2</option>
                                    <option value="rejected" @if ($video->state == 'rejected') selected @endif>Rejected</option>
                            </select>
                            <button class="btn btn-primary waves-effect" type="submit">Change Status</button>
                          </div> -->
                            <div class="form-group">
                                <label for="status">Change Status:</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="pending" @if ($video->state == 'pending') selected @endif>Pending</option>
                                    <option value="round-1" @if ($video->state == 'round-1') selected @endif>Round 1</option>
                                    <option value="round-2" @if ($video->state == 'round-2') selected @endif>Round 2</option>
                                    <option value="rejected" @if ($video->state == 'rejected') selected @endif>Rejected</option>
                                </select>
                            </div>
                            <button class="btn btn-primary waves-effect mt-1 waves-light w-100">Change Status</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
        <!-- /User Card -->


    </div>


    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
        <div class="card mb-4">
            <div class="card-body">
                <video width="100%" controls>
                    <source src="{{ asset('storage/' . $video->file_path) }}">
                    Your browser does not support the video tag.
                </video>
                <form action="{{ route('guru.rate.video', $video->id) }}" method="post">
            @csrf
            <label for="rating">Rate this video:</label>
            <div class="rating-options">
                @for ($i = 1; $i <= 10; $i++)
                    <input type="radio" id="rating{{ $i }}" name="rating" value="{{ $i }}">
                    <label for="rating{{ $i }}">{{ $i }}</label>
                @endfor
            </div>
            <button type="submit">Submit Rating</button>
        </form>
                <hr />
                <form method="POST" action="{{ isset($video->auditionDetails) ? route('singing.update', [$video->auditionDetails->id, 'plan' => request()->plan]) : route('singing.store',['plan' => request()->plan]) }}">




                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="previous_performance" name="previous_performance" rows="3">{{ old('previous_performance', isset($video->auditionDetails) ? $video->auditionDetails->previous_performance : '') }}</textarea>
                        <label for="previous_performance">Previous Performance</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="music_experience" name="music_experience" rows="3">{{ old('music_experience', isset($video->auditionDetails) ? $video->auditionDetails->music_experience : '') }}</textarea>
                        <label for="music_experience">Music Experience</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="music_qualification" name="music_qualification" rows="3">{{ old('music_qualification', isset($video->auditionDetails) ? $video->auditionDetails->music_qualification : '') }}</textarea>
                        <label for="music_qualification">Music Qualification</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="how_know_about_auditions" name="how_know_about_auditions" rows="3">{{ $video->auditionDetails->how_know_about_auditions }}</textarea>
                        <label for="music_qualification">How did you know about auditions?</label>
                    </div>




                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="how_know_about_auditions_detail" name="how_know_about_auditions_detail" rows="3">{{ old('how_know_about_auditions_detail', isset($video->auditionDetails) ? $video->auditionDetails->how_know_about_auditions_detail : '') }}</textarea>
                        <label for="how_know_about_auditions_detail">Please provide details</label>
                    </div>


                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="why_tup_expectations" name="why_tup_expectations" rows="3">{{ old('why_tup_expectations', isset($video->auditionDetails) ? $video->auditionDetails->why_tup_expectations : '') }}</textarea>
                        <label for="why_tup_expectations">Why do you have expectations from us?</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="why_we_select_you" name="why_we_select_you" rows="3">{{ old('why_we_select_you', isset($video->auditionDetails) ? $video->auditionDetails->why_we_select_you : '') }}</textarea>
                        <label for="why_we_select_you">Why should we select you?</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="future_plan_if_win" name="future_plan_if_win" rows="3">{{ old('future_plan_if_win', isset($video->auditionDetails) ? $video->auditionDetails->future_plan_if_win : '') }}</textarea>
                        <label for="future_plan_if_win">What are your future plans if you win?</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="opinion_new_season_tup" name="opinion_new_season_tup" rows="3">{{ old('opinion_new_season_tup', isset($video->auditionDetails) ? $video->auditionDetails->opinion_new_season_tup : '') }}</textarea>
                        <label for="opinion_new_season_tup">What's your opinion on the new season ?</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="written_composed_song_inspiration" name="written_composed_song_inspiration" rows="3">{{ old('written_composed_song_inspiration', isset($video->auditionDetails) ? $video->auditionDetails->written_composed_song_inspiration : '') }}</textarea>
                        <label for="written_composed_song_inspiration">Have you written/composed any song? What's the inspiration behind it?</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="life_changing_incident" name="life_changing_incident" rows="3">{{ old('life_changing_incident', isset($video->auditionDetails) ? $video->auditionDetails->life_changing_incident : '') }}</textarea>
                        <label for="life_changing_incident">Share a life-changing incident you've experienced.</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="change_about_self_love_about_self" name="change_about_self_love_about_self" rows="3">{{ old('change_about_self_love_about_self', isset($video->auditionDetails) ? $video->auditionDetails->change_about_self_love_about_self : '') }}</textarea>
                        <label for="change_about_self_love_about_self">What would you like to change about yourself and what do you love about yourself?</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="unique_qualities" name="unique_qualities" rows="3">{{ old('unique_qualities', isset($video->auditionDetails) ? $video->auditionDetails->unique_qualities : '') }}</textarea>
                        <label for="unique_qualities">Share your unique qualities.</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="main_goal_difficulties" name="main_goal_difficulties" rows="3">{{ old('main_goal_difficulties', isset($video->auditionDetails) ? $video->auditionDetails->main_goal_difficulties : '') }}</textarea>
                        <label for="main_goal_difficulties">What are your main goals and what difficulties have you faced in achieving them?</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="biggest_strength_support" name="biggest_strength_support" rows="3">{{ old('biggest_strength_support', isset($video->auditionDetails) ? $video->auditionDetails->biggest_strength_support : '') }}</textarea>
                        <label for="biggest_strength_support">What's your biggest strength and what support do you have?</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="favorite_judge_why" name="favorite_judge_why" rows="3">{{ old('favorite_judge_why', isset($video->auditionDetails) ? $video->auditionDetails->favorite_judge_why : '') }}</textarea>
                        <label for="favorite_judge_why">Who's your favorite judge and why?</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="role_model_inspiration" name="role_model_inspiration" rows="3">{{ old('role_model_inspiration', isset($video->auditionDetails) ? $video->auditionDetails->role_model_inspiration : '') }}</textarea>
                        <label for="role_model_inspiration">Who's your role model and what inspires you about them?</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="prepared_songs" name="prepared_songs" rows="3">{{ old('prepared_songs', isset($video->auditionDetails) ? $video->auditionDetails->prepared_songs : '') }}</textarea>
                        <label for="prepared_songs">What songs are you prepared to perform?</label>
                    </div>
                </form>

            </div>
        </div>
    </div>


</div>

@endsection
