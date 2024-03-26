@extends('layouts.app-new')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        @include('partials.steps', ['active' => 'registration'])
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    

                    {{ __('You are logged in!') }}

                    <a href="{{route('goToPayment', ['vu2024'])}}"><button>Upload your video for $25</button></a> &nbsp;
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
