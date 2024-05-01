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
    <form method="POST"
        action="{{ isset($userDetail) ? route('audition.update', [$userDetail->id, 'plan' => request()->plan]) : route('audition.store', ['plan' => request()->plan]) }}">
        @csrf
        @if (isset($userDetail))
            @method('PUT')
        @endif


        @php
            $ing = 'Singing';
            $er = 'singer';
            $tnclink = env('TnCTNSS');
            if (str_contains(request()->plan, 'TNDS')) {
                $ing = 'Dancing';
                $er = 'dancer';
                $tnclink = env('TnCTNDS');
            }
        @endphp


        @include('forms.audition-'. $payment['team_type'], ['members' => $payment['members'] ?? 1 ])


        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                <label class="form-check-label" for="terms-conditions">
                    I agree to
                    <a href="{{ $tnclink }}">privacy policy & terms</a>
                    <span class="required">*</span></label>
            </div>
        </div>
        <button class="btn btn-primary d-grid w-100">Next: Upload Video</button>

        <!-- Add other fields here -->


    </form>
@endsection
