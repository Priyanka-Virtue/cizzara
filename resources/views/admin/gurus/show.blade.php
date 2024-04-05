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
    <!-- <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">

        <div class="card mb-4">
            <div class="card-body">
                <div class="user-avatar-section">
                    <div class=" d-flex align-items-center flex-column">
                        <img class="img-fluid rounded mb-3 mt-4" src="{{asset('/storage/'.$user->details->photo)}}" height="120" width="120" alt="User avatar">

                    </div>
                </div>


                <h5 class="pb-3 border-bottom mb-3">{{ $user->name }}</h5>
                <div class="info-container">
                    <ul class="list-unstyled mb-4">
                        <li class="mb-3">
                            <span class="h6">Relationship status:</span>
                            <span>{{ $user->details->relationship_status }}</span>
                        </li>
                    </ul>
                    <hr />
                    <ul class="list-unstyled mb-4">
                        <li class="mb-3">
                            <span class="h6">Contestant Name:</span>
                            <span>{{ $user->name }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="h6">Email:</span>
                            <span>{{$user->email}}</span>
                        </li>

                    </ul>


                </div>
            </div>
        </div>



    </div> -->


    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
        <div class="card mb-4">
            <div class="card-body">
                <div class="user-avatar-section">
                    <div class=" d-flex align-items-center flex-column">
                        <img class="img-fluid rounded mb-3 mt-4" src="{{asset('/storage/'.$user->details->photo)}}" height="120" width="120" alt="User avatar">
                        <!-- <div class="user-info text-center">
                            <h4>{{ $user->details->first_name }}</h4>
                            <span class="badge bg-label-info rounded-pill">Pending</span>
                        </div> -->
                    </div>
                </div>
                <hr />
                <form method="POST" action="{{ isset($user->details) ? route('user-details.update', $user->details->id) : route('user-details.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if(isset($user->details))
                    @method('PUT')
                    @endif

                    @php
                    $proviences = [
                    'Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','Florida','Georgia','Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi','Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma','Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia','Wisconsin','Wyoming'];

                    $how_know = [
                    'TV ads',
                    'Social Media',
                    'Newspaper ads',
                    'Outdoor ads',
                    'Others'
                    ];
                    @endphp



                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', isset($user->details) ? $user->details->first_name : '') }}" placeholder="Enter your first name">
                                <label for="first_name">First Name</label>

                                <input disabled type="hidden" value="{{request()->plan}}" name="plan">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', isset($user->details) ? $user->details->last_name : '') }}" placeholder="Enter your last name">
                                <label for="last_name">Last Name</label>
                            </div>
                        </div>

                        <!-- <div class="col-md-4">
            <div class="form-floating form-floating-outline mb-3">
                <input disabled type="text" class="form-control" id="stagename" name="stagename" value="{{ old('stagename', isset($user->details) ? $user->details->stagename : '') }}" placeholder="Enter your stage name">
                <label for="stagename">Stage Name</label>
            </div>
        </div> -->
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <select disabled class="form-select" id="gender" name="gender">
                                    <option value="male" {{ old('gender', isset($user->details) ? $user->details->gender : '') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', isset($user->details) ? $user->details->gender : '') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', isset($user->details) ? $user->details->gender : '') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <label for="gender">Gender</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <select disabled class="form-select" id="relationship_status" name="relationship_status">
                                    <option value="single" {{ old('relationship_status', isset($user->details) ? $user->details->relationship_status : '') == 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="married" {{ old('relationship_status', isset($user->details) ? $user->details->relationship_status : '') == 'married' ? 'selected' : '' }}>Married</option>
                                </select>
                                <label for="relationship_status">Relationship Status</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', isset($user->details) ? $user->details->date_of_birth : '') }}">
                                <label for="date_of_birth">Date of Birth</label>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="text" class="form-control" id="city" name="city" value="{{ old('city', isset($user->details) ? $user->details->city : '') }}" placeholder="Enter your city">
                                <label for="city">City</label>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <select disabled class="form-select" id="state" name="state">
                                    <option value="" selected disabled>Select state</option>
                                    @foreach($proviences as $provience)
                                    <option value="{{$provience}}" {{ old('state', isset($user->details) ? $user->details->state : '') == $provience ? 'selected' : '' }}>{{$provience}}</option>
                                    @endforeach
                                </select>
                                <label for="state">State</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="text" class="form-control" id="pin_code" name="pin_code" value="{{ old('pin_code', isset($user->details) ? $user->details->pin_code : '') }}" placeholder="Enter your postal code">
                                <label for="pin_code">Postal Code</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', isset($user->details) ? $user->details->phone : '') }}" placeholder="Enter your phone number">
                                <label for="phone">Phone</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="text" class="form-control" id="address" name="address" value="{{ old('address', isset($user->details) ? $user->details->address : '') }}" placeholder="Enter your address">
                                <label for="address">Address</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="text" class="form-control" id="education" name="education" value="{{ old('education', isset($user->details) ? $user->details->education : '') }}" placeholder="Enter your education">
                                <label for="education">Education</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="text" class="form-control" id="occupation" name="occupation" value="{{ old('occupation', isset($user->details) ? $user->details->occupation : '') }}" placeholder="Enter your occupation">
                                <label for="occupation">Occupation</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="text" class="form-control" id="work_experience" name="work_experience" value="{{ old('work_experience', isset($user->details) ? $user->details->work_experience : '') }}" placeholder="Enter your work experience">
                                <label for="work_experience">Work Experience</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="url" class="form-control" id="instagram" name="instagram" value="{{ old('instagram', isset($user->details) ? $user->details->instagram : '') }}" placeholder="Enter your Instagram link">
                                <label for="instagram">Instagram Link</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="url" class="form-control" id="youtube" name="youtube" value="{{ old('youtube', isset($user->details) ? $user->details->youtube : '') }}" placeholder="Enter your YouTube link">
                                <label for="youtube">YouTube Link</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="url" class="form-control" id="facebook" name="facebook" value="{{ old('facebook', isset($user->details) ? $user->details->facebook : '') }}" placeholder="Enter your Facebook link">
                                <label for="facebook">Facebook Link</label>
                            </div>
                        </div>

                    </div>


                    <!-- Guardian Information -->
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="text" class="form-control" id="g_first_name" name="g_first_name" value="{{ old('g_first_name', isset($user->details) ? $user->details->g_first_name : '') }}" placeholder="Enter guardian's first name">
                                <label for="g_first_name">Guardian's First Name</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="text" class="form-control" id="g_last_name" name="g_last_name" value="{{ old('g_last_name', isset($user->details) ? $user->details->g_last_name : '') }}" placeholder="Enter guardian's last name">
                                <label for="g_last_name">Guardian's Last Name</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="tel" class="form-control" id="g_phone" name="g_phone" value="{{ old('g_phone', isset($user->details) ? $user->details->g_phone : '') }}" placeholder="Enter guardian's phone number">
                                <label for="g_phone">Guardian's Phone</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="text" class="form-control" id="g_address" name="g_address" value="{{ old('g_address', isset($user->details) ? $user->details->g_address : '') }}" placeholder="Enter guardian's address">
                                <label for="g_address">Guardian's Address</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="text" class="form-control" id="g_pin_code" name="g_pin_code" value="{{ old('g_pin_code', isset($user->details) ? $user->details->g_pin_code : '') }}" placeholder="Enter guardian's postal code">
                                <label for="g_pin_code">Guardian's Postal Code</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="text" class="form-control" id="g_city" name="g_city" value="{{ old('g_city', isset($user->details) ? $user->details->g_city : '') }}" placeholder="Enter guardian's city">
                                <label for="g_city">Guardian's City</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="text" class="form-control" id="g_state" name="g_state" value="{{ old('g_state', isset($user->details) ? $user->details->g_state : '') }}" placeholder="Enter guardian's state">
                                <label for="g_state">Guardian's State</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input disabled type="email" class="form-control" id="g_email" name="g_email" value="{{ old('g_email', isset($user->details) ? $user->details->g_email : '') }}" placeholder="Enter guardian's email">
                                <label for="g_email">Guardian's Email</label>
                            </div>
                        </div>
                    </div>








                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="hobbies" name="hobbies" rows="3">{{ old('hobbies', isset($user->details) ? $user->details->hobbies : '') }}</textarea>
                        <label for="hobbies">Hobbies</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <textarea disabled class="form-control" id="describe_yourself" name="describe_yourself" rows="3">{{ old('describe_yourself', isset($user->details) ? $user->details->describe_yourself : '') }}</textarea>
                        <label for="describe_yourself">Describe Yourself</label>
                    </div>


                </form>
            </div>
        </div>
    </div>





</div>

@endsection
