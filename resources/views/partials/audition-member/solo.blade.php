@php
    $userDetail = isset($video->auditionDetails) ? $video->auditionDetails : $userDetail; // for SHOW VIDEO ADMIN
@endphp

<div class="form-floatingXXX  d-flex flex-column-reverse form-floating-outline mb-3">
    <textarea class="form-control" id="contract" name="contract" rows="3" required>{{ old('contract', isset($userDetail) ? $userDetail->contract : '') }}</textarea>
    <label for="contract">Are you in a contract with any production house or same? <span class="required">*</span></label>
</div>

<div class="form-floatingXXX  d-flex flex-column-reverse form-floating-outline mb-3">
    <textarea class="form-control" id="previous_performance" name="previous_performance" rows="3" required>{{ old('previous_performance', isset($userDetail) ? $userDetail->previous_performance : '') }}</textarea>
    <label for="previous_performance">Have you participated in any Reality Show? <span class="required">*</span></label>
</div>
<div class="form-floatingXXX  d-flex flex-column-reverse form-floating-outline mb-3">
    <textarea class="form-control" id="why_tup_expectations" name="why_tup_expectations" rows="3" required>{{ old('why_tup_expectations', isset($userDetail) ? $userDetail->why_tup_expectations : '') }}</textarea>
    <label for="why_tup_expectations">Why “The Next {{ $ing }} Superstar” and what are your expectations from
        the show? <span class="required">*</span></label>
</div>

<div class="form-floatingXXX  d-flex flex-column-reverse form-floating-outline mb-3">
    <textarea class="form-control" id="why_we_select_you" name="why_we_select_you" rows="3" required>{{ old('why_we_select_you', isset($userDetail) ? $userDetail->why_we_select_you : '') }}</textarea>
    <label for="why_we_select_you">Why should we select you? <span class="required">*</span></label>
</div>

<div class="form-floatingXXX  d-flex flex-column-reverse form-floating-outline mb-3">
    <textarea class="form-control" id="probability" name="probability" rows="3" required>{{ old('probability', isset($userDetail) ? $userDetail->probability : '') }}</textarea>
    <label for="probability">What are the probability of you winning the competition? <span
            class="required">*</span></label>
</div>

<div class="form-floatingXXX  d-flex flex-column-reverse form-floating-outline mb-3">
    <textarea class="form-control" id="future_plan_if_win" name="future_plan_if_win" rows="3" required>{{ old('future_plan_if_win', isset($userDetail) ? $userDetail->future_plan_if_win : '') }}</textarea>
    <label for="future_plan_if_win">What do you feel about the opportunities after participation in this show? <span
            class="required">*</span></label>
</div>

<div class="form-floatingXXX  d-flex flex-column-reverse form-floating-outline mb-3">
    <textarea class="form-control" id="written_composed_song_inspiration" name="written_composed_song_inspiration"
        rows="3" required>{{ old('written_composed_song_inspiration', isset($userDetail) ? $userDetail->written_composed_song_inspiration : '') }}</textarea>
    <label for="written_composed_song_inspiration">Have you ever composed or performed any dance choreography with the
        Bollywood theme by your own? If yes, we would like to know about your journey for the same. <span
            class="required">*</span></label>
</div>


<div class="form-floatingXXX  d-flex flex-column-reverse form-floating-outline mb-3">
    <textarea class="form-control" id="biggest_strength_support" name="biggest_strength_support" rows="3" required>{{ old('biggest_strength_support', isset($userDetail) ? $userDetail->biggest_strength_support : '') }}</textarea>
    <label for="biggest_strength_support">Tell us some of your strengths and weaknesses. <span
            class="required">*</span></label>
</div>

<div class="form-floatingXXX  d-flex flex-column-reverse form-floating-outline mb-3">
    <textarea class="form-control" id="main_goal_difficulties" name="main_goal_difficulties" rows="3" required>{{ old('main_goal_difficulties', isset($userDetail) ? $userDetail->main_goal_difficulties : '') }}</textarea>
    <label for="main_goal_difficulties">What is your goal and what are the difficulties you are facing to achieve the
        same? <span class="required">*</span></label>
</div>

<div class="form-floatingXXX  d-flex flex-column-reverse form-floating-outline mb-3">
    <textarea class="form-control" id="unique_qualities" name="unique_qualities" rows="3" required>{{ old('unique_qualities', isset($userDetail) ? $userDetail->unique_qualities : '') }}</textarea>
    <label for="unique_qualities">What makes you better than others? <span class="required">*</span></label>
</div>

<div class="form-floatingXXX  d-flex flex-column-reverse form-floating-outline mb-3">
    <textarea class="form-control" id="role_model_inspiration" name="role_model_inspiration" rows="3" required>{{ old('role_model_inspiration', isset($userDetail) ? $userDetail->role_model_inspiration : '') }}</textarea>
    <label for="role_model_inspiration">What/who is your inspiration for taking a step forward in {{ $ing }}?
        <span class="required">*</span></label>
</div>


<div class="form-floatingXXX  d-flex flex-column-reverse form-floating-outline mb-3">
    <textarea class="form-control" id="favorite_judge_why" name="favorite_judge_why" rows="3" required>{{ old('favorite_judge_why', isset($userDetail) ? $userDetail->favorite_judge_why : '') }}</textarea>
    <label for="favorite_judge_why">Who is your favorite Bollywood {{ $er }} and why? <span
            class="required">*</span></label>
</div>

<div class="form-floatingXXX  d-flex flex-column-reverse form-floating-outline mb-3">
    <textarea class="form-control" id="rolemodel" name="rolemodel" rows="3" required>{{ old('rolemodel', isset($userDetail) ? $userDetail->rolemodel : '') }}</textarea>
    <label for="rolemodel">Who you consider to be your role model in Bollywood? <span class="required">*</span></label>
</div>

<div class="form-floatingXXX  d-flex flex-column-reverse form-floating-outline mb-3">
    <textarea class="form-control" id="prepared_songs" name="prepared_songs" rows="3" required>{{ old('prepared_songs', isset($userDetail) ? $userDetail->prepared_songs : '') }}</textarea>
    <label for="prepared_songs">What Bollywood {{ $er }}’s style you can perform the best? (Any 2 Atleast)
        <span class="required">*</span></label>
</div>
