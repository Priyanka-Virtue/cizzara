<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Http\Requests\StoreGuruRequest;
use App\Http\Requests\UpdateGuruRequest;
use App\Models\Plan;
use App\Models\User;
use App\Notifications\RatingReminder;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gurus = User::role('guru')->paginate(env('RECORDS_PER_PAGE', 10));
        return view('admin.gurus.index', compact('gurus'));
    }
    public function create()
    {

        return view('admin.gurus.create-update');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'unique:users,phone',
            'is_active' => 'required|in:0,1',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->is_active = $request->input('is_active');
        $user->password = bcrypt('password!!!');
        $user->save();

        $user->assignRole('guru');

        return redirect()->route('gurus.index')->with('success', 'Guru has been added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     $guru = User::findOrFail($id);
    //     return view('gurus.show', compact('guru'));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userDetail = User::findOrFail($id);
        return view('admin.gurus.create-update', compact('userDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'is_active' => 'required|boolean',
        ]);

        // Update user
        $user->update($validatedData);

        return redirect()->route('gurus.index')->with('success', 'Guru updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $user = User::findOrFail($id);
    //     $user->delete();

    //     return redirect()->route('gurus.index')->with('success', 'Guru deleted successfully.');
    // }

    public function updateStatus(Request $request)
    {
        $updated = User::where('id', $request->input('user_id'))->update(['is_active' => $request->input('is_active')]);

        return response()->json(['success' => true]);
    }
    public function updateAudition(Request $request)
    {
        $plan = Plan::where('id', $request->input('plan_id'))->first();

        $gurus = $plan->gurus ?? [];

        if ($request->input('status') == '1') {
            $gurus[] = (int)$request->input('user_id');
            $msg = 'Guru assigned to audition ' . $plan->name;
        } else {
            $gurus = array_diff($gurus, [$request->input('user_id')]);
            $msg = 'Guru has been removed from audition ' . $plan->name;
        }

        $pd = $plan->update(['gurus' => $gurus]);
        return response()->json(['success' => true, 'message' => $msg]);
    }
    public function ratingReminder(Request $request){
        $guru = User::findOrFail($request->input('guru_id'));
        $guru->notify(new RatingReminder($guru));
        return response()->json(['success' => true, 'message' => 'Rating reminder sent successfully to '.$guru->name]);
    }
}
