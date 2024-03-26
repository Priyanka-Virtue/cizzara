<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\Singing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SingingController extends Controller
{
    public function index()
    {
        // Retrieve all user details
        $userDetail = Singing::all();

        // Pass user details to the view
        return view('singing', compact('userDetail'));
    }

    public function create()
    {
        // Return the view for creating a new user detail
        return view('singing');
    }
    function plan_id($plan)
    {
        return Plan::where('name', $plan)->first()->id ?? null;
    }
    public function store(Request $request)
    {
        $plan = $request->plan;
        $validatedData = $request->validate([
            'auditioncity' => 'required',
            // 'plan' => 'required',
            'stagename' => 'nullable|string|max:255',
            'why_tup_expectations' => 'nullable|string|max:5000',
            'why_we_select_you' => 'nullable|string|max:5000',
            'future_plan_if_win' => 'nullable|string|max:5000',
            'opinion_new_season_tup' => 'nullable|string|max:5000',
            'written_composed_song_inspiration' => 'nullable|string|max:5000',
            'life_changing_incident' => 'nullable|string|max:5000',
            'change_about_self_love_about_self' => 'nullable|string|max:5000',
            'unique_qualities' => 'nullable|string|max:5000',
            'main_goal_difficulties' => 'nullable|string|max:5000',
            'biggest_strength_support' => 'nullable|string|max:5000',
            'favorite_judge_why' => 'nullable|string|max:5000',
            'role_model_inspiration' => 'nullable|string|max:5000',
            'prepared_songs' => 'nullable|string|max:5000',
            'how_know_about_auditions' => 'required|max:5000',
            'how_know_about_auditions_details' => 'nullable|string|max:5000',

            'genre_of_singing' => 'nullable|string|max:300',
            'previous_performance' => 'nullable|string|max:5000',
            'music_experience' => 'nullable|string|max:5000',
            'music_qualification' => 'nullable|string|max:5000',
        ]);
        $plan_id = $this->plan_id($plan);
        if (!$plan_id) {
            return redirect()->route('home')->with('error', 'Plan not found');
        }
        if (!Payment::where('user_id', Auth::id())->where('plan_id', $plan_id)->where('stripe_payment_id', '!=', '')->exists()) {
            return redirect()->route('upload-video', ['plan' => $plan]);
        }
        $validatedData['plan_id'] = $plan_id;
        $validatedData['user_id'] = auth()->user()->id;
        // Create or update user details
        Singing::updateOrCreate(
            ['user_id' => auth()->id(), 'plan_id' => $plan_id], // Assuming user_id is associated with the user details
            $validatedData
        );

        return redirect()->route('upload-video')->with('success', 'Audition details created successfully, Now you can upload your video.');
    }

    public function show(Singing $userDetail)
    {
        // Return the view to show a specific user detail
        return view('singing.show', compact('userDetail'));
    }

    public function edit(Singing $userDetail)
    {
        // Return the view for editing a user detail
        return view('singing.edit', compact('userDetail'));
    }

    public function update(Request $request, Singing $userDetail)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'auditioncity' => 'required',
            // 'plan' => 'required',
            'stagename' => 'nullable|string|max:5000',
            'why_tup_expectations' => 'nullable|string|max:5000',
            'why_we_select_you' => 'nullable|string|max:5000',
            'future_plan_if_win' => 'nullable|string|max:5000',
            'opinion_new_season_tup' => 'nullable|string|max:5000',
            'written_composed_song_inspiration' => 'nullable|string|max:5000',
            'life_changing_incident' => 'nullable|string|max:5000',
            'change_about_self_love_about_self' => 'nullable|string|max:5000',
            'unique_qualities' => 'nullable|string|max:5000',
            'main_goal_difficulties' => 'nullable|string|max:5000',
            'biggest_strength_support' => 'nullable|string|max:5000',
            'favorite_judge_why' => 'nullable|string|max:5000',
            'role_model_inspiration' => 'nullable|string|max:5000',
            'prepared_songs' => 'nullable|string|max:5000',
            'how_know_about_auditions' => 'required|max:5000',
            'how_know_about_auditions_details' => 'nullable|string|max:5000',

            'genre_of_singing' => 'nullable|string|max:300',
            'previous_performance' => 'nullable|string|max:5000',
            'music_experience' => 'nullable|string|max:5000',
            'music_qualification' => 'nullable|string|max:5000',
        ]);

        // Update the user detail with the validated data
        $userDetail->update($validatedData);

        // Redirect to the index page with success message
        return redirect()->route('upload-video')->with('success', 'Audition details updated successfully, Now you can upload your video.');
    }

    public function destroy(Singing $userDetail)
    {
        // Delete the user detail
        $userDetail->delete();

        // Redirect to the index page with success message
        return redirect()->route('singing')->with('success', 'Audition details updated successfully, Now you can upload your video.');
    }
}
