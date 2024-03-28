@extends('layouts.auth', ['title' => 'Login', 'description' => 'Login', 'width' => 'col-md-3'])

@section('content')

<h4 class="mb-2">Welcome to {{env('APP_NAME')}}! 👋</h4>
<p class="mb-4">Please sign-in to your account to continue.</p>
<form id="formAuthentication" class="mb-3" method="POST" action="{{ route('login') }}">
    <div class="form-floating form-floating-outline mb-3">
    @csrf
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" autofocus />
        <label for="email">Email</label>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="mb-3">
        <div class="form-password-toggle">
            <div class="input-group input-group-merge">
                <div class="form-floating form-floating-outline">
                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                    <label for="password">Password</label>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
            </div>
        </div>
    </div>
    <div class="mb-3 d-flex justify-content-between">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember" {{ old('remember') ? 'checked' : '' }} />
            <label class="form-check-label" for="remember"> {{ __('Remember Me') }} </label>
        </div>

        @if (Route::has('password.request'))
        <a class="float-end mb-1" href="{{ route('password.request') }}">
            {{ __('Forgot Your Password?') }}
        </a>
        @endif
    </div>
    <div class="mb-3">
        <button class="btn btn-primary d-grid w-100" type="submit">{{ __('Login') }}</button>
    </div>
</form>

<p class="text-center">
    <span>New on our platform?</span>
    <a href="{{route('register')}}">
        <span>Create an account</span>
    </a>
</p>
@endsection
