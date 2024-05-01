@extends('layouts.auth')

@section('content')
<style>
    .wizard .nav-tabsxxx>li:not(.active) a i {
        color: #000 !important;
    }


</style>
@include('partials.steps', ['active' => 'Audition'])
<h4 class="mb-2">Adventure starts here 🚀</h4>
<p class="mb-4">Just one step away!</p>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form method="POST" action="{{ isset($userDetail) ? route('audition.update', [$userDetail->id, 'plan' => request()->plan]) : route('audition.store',['plan' => request()->plan]) }}">
    @csrf
    @if(isset($userDetail))
    @method('PUT')
    @endif


    @php
 $ing = 'Singing';
 $er = 'singer';
 $tnclink = env('TnCTNSS');
if(str_contains(request()->plan, 'TNDS'))  {
    $ing = 'Dancing';
    $er = 'dancer';
    $tnclink = env('TnCTNDS');
}

     /*$proviences = [
    'Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','Florida','Georgia','Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi','Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma','Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia','Wisconsin','Wyoming'];

    $how_know = [
    'TV ads',
    'Social Media',
    'Newspaper ads',
    'Outdoor ads',
    'Others'
    ];*/
    @endphp

    {{-- <div class="row">
        <div class="col-md-4">
            <div class="form-floating form-floating-outline mb-3">
                <select class="form-select" id="auditioncity" name="auditioncity">
                    <option value="" selected disabled>Select your audition city</option>
                    @foreach($proviences as $provience)
                    <option value="{{$provience}}" {{ old('auditioncity', isset($userDetail) ? $userDetail->auditioncity : '') == $provience ? 'selected' : '' }}>{{$provience}}</option>
                    @endforeach
                </select>
                <label for="auditioncity">Audition City <span class="required">*</span></label>
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control" id="stagename" name="stagename" value="{{ old('stagename', isset($userDetail) ? $userDetail->stagename : '') }}" placeholder="Enter your stage name">
                <label for="stagename">Stage Name <span class="required">*</span></label>
            </div>
        </div>
    </div> --}}


<div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="contract" name="contract" rows="3" required>{{ old('contract', isset($userDetail) ? $userDetail->contract : '') }}</textarea>
        <label for="contract">Are you in a contract with any production house or same?  <span class="required">*</span></label>
    </div>

    <div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="previous_performance" name="previous_performance" rows="3" required>{{ old('previous_performance', isset($userDetail) ? $userDetail->previous_performance : '') }}</textarea>
        <label for="previous_performance">Have you participated in any Reality Show? <span class="required">*</span></label>
    </div>
<div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="why_tup_expectations" name="why_tup_expectations" rows="3" required>{{ old('why_tup_expectations', isset($userDetail) ? $userDetail->why_tup_expectations : '') }}</textarea>
        <label for="why_tup_expectations">Why “The Next {{$ing}} Superstar” and what are your expectations from the show? <span class="required">*</span></label>
    </div>



{{-- <div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="genre_of_singing" name="genre_of_singing" rows="3" required>{{ old('genre_of_singing', isset($userDetail) ? $userDetail->genre_of_singing : '') }}</textarea>
        <label for="genre_of_singing">Genre/Type of {{$atype}} <span class="required">*</span></label>
    </div>

    <div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="music_experience" name="music_experience" rows="3" required>{{ old('music_experience', isset($userDetail) ? $userDetail->music_experience : '') }}</textarea>
        <label for="music_experience">{{$atype}} Experience <span class="required">*</span></label>
    </div>

    <div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="music_qualification" name="music_qualification" rows="3" required>{{ old('music_qualification', isset($userDetail) ? $userDetail->music_qualification : '') }}</textarea>
        <label for="music_qualification">{{$atype}} Qualification <span class="required">*</span></label>
    </div>




 --}}



    {{-- <div class="form-floating form-floating-outline mb-3">
        <select class="form-select" id="how_know_about_auditions" name="how_know_about_auditions">
            @foreach($how_know as $hw)
            <option value="{{$hw}}" {{ old('how_know_about_auditions', isset($userDetail) ? $userDetail->how_know_about_auditions : '') == $hw ? 'selected' : '' }}>{{$hw}}</option>
            @endforeach
        </select>
        <label for="how_know_about_auditions">How did you know about auditions? <span class="required">*</span></label>
    </div> --}}


    {{-- <div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="how_know_about_auditions_detail" name="how_know_about_auditions_detail" rows="3" required>{{ old('how_know_about_auditions_detail', isset($userDetail) ? $userDetail->how_know_about_auditions_detail : '') }}</textarea>
        <label for="how_know_about_auditions_detail">Please provide details <span class="required">*</span></label>
    </div> --}}




    <div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="why_we_select_you" name="why_we_select_you" rows="3" required>{{ old('why_we_select_you', isset($userDetail) ? $userDetail->why_we_select_you : '') }}</textarea>
        <label for="why_we_select_you">Why should we select you? <span class="required">*</span></label>
    </div>

    <div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="probability" name="probability" rows="3" required>{{ old('probability', isset($userDetail) ? $userDetail->probability : '') }}</textarea>
        <label for="probability">What are the probability of you winning the competition?  <span class="required">*</span></label>
    </div>

    <div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="future_plan_if_win" name="future_plan_if_win" rows="3" required>{{ old('future_plan_if_win', isset($userDetail) ? $userDetail->future_plan_if_win : '') }}</textarea>
        <label for="future_plan_if_win">What do you feel about the opportunities after participation in this show?   <span class="required">*</span></label>
    </div>

    <div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="written_composed_song_inspiration" name="written_composed_song_inspiration" rows="3" required>{{ old('written_composed_song_inspiration', isset($userDetail) ? $userDetail->written_composed_song_inspiration : '') }}</textarea>
        <label for="written_composed_song_inspiration">Have you ever written and/or composed any song by your own? If yes, we would like to know about your journey for the same. <span class="required">*</span></label>
    </div>




    <div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="biggest_strength_support" name="biggest_strength_support" rows="3" required>{{ old('biggest_strength_support', isset($userDetail) ? $userDetail->biggest_strength_support : '') }}</textarea>
        <label for="biggest_strength_support">Tell us some of your strengths and weaknesses. <span class="required">*</span></label>
    </div>

    <div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="main_goal_difficulties" name="main_goal_difficulties" rows="3" required>{{ old('main_goal_difficulties', isset($userDetail) ? $userDetail->main_goal_difficulties : '') }}</textarea>
        <label for="main_goal_difficulties">What is your goal and what are the difficulties you are facing to achieve the same?  <span class="required">*</span></label>
    </div>

<div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="unique_qualities" name="unique_qualities" rows="3" required>{{ old('unique_qualities', isset($userDetail) ? $userDetail->unique_qualities : '') }}</textarea>
        <label for="unique_qualities">What makes you better than others?  <span class="required">*</span></label>
    </div>

    <div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="role_model_inspiration" name="role_model_inspiration" rows="3" required>{{ old('role_model_inspiration', isset($userDetail) ? $userDetail->role_model_inspiration : '') }}</textarea>
        <label for="role_model_inspiration">What/who is your inspiration for taking a step forward in {{$ing}}? <span class="required">*</span></label>
    </div>


    <div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="favorite_judge_why" name="favorite_judge_why" rows="3" required>{{ old('favorite_judge_why', isset($userDetail) ? $userDetail->favorite_judge_why : '') }}</textarea>
        <label for="favorite_judge_why">Who is your favorite Bollywood {{$er}} and why? <span class="required">*</span></label>
    </div>

 <div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="prepared_songs" name="prepared_songs" rows="3" required>{{ old('prepared_songs', isset($userDetail) ? $userDetail->prepared_songs : '') }}</textarea>
        <label for="prepared_songs">What Bollywood {{$er}}’s songs you can perform the best? (Any 2 Atleast) <span class="required">*</span></label>
    </div>


    {{-- <div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="opinion_new_season_tup" name="opinion_new_season_tup" rows="3" required>{{ old('opinion_new_season_tup', isset($userDetail) ? $userDetail->opinion_new_season_tup : '') }}</textarea>
        <label for="opinion_new_season_tup">What's your opinion on the new season ? <span class="required">*</span></label>
    </div>



    <div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="life_changing_incident" name="life_changing_incident" rows="3" required>{{ old('life_changing_incident', isset($userDetail) ? $userDetail->life_changing_incident : '') }}</textarea>
        <label for="life_changing_incident">Share a life-changing incident you've experienced. <span class="required">*</span></label>
    </div>

    <div class="form-floating form-floating-outline mb-3">
        <textarea class="form-control" id="change_about_self_love_about_self" name="change_about_self_love_about_self" rows="3" required>{{ old('change_about_self_love_about_self', isset($userDetail) ? $userDetail->change_about_self_love_about_self : '') }}</textarea>
        <label for="change_about_self_love_about_self">What would you like to change about yourself and what do you love about yourself? <span class="required">*</span></label>
    </div> --}}



    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
            <label class="form-check-label" for="terms-conditions">
                I agree to
                <a href="{{$tnclink}}">privacy policy & terms</a>
             <span class="required">*</span></label>
        </div>
    </div>
    <button class="btn btn-primary d-grid w-100">Next: Upload Video</button>

    <!-- Add other fields here -->


</form>


@endsection
