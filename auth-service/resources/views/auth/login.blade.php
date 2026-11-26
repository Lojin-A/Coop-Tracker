@extends('layouts.guest')

@section('title', __('messages.sign_in') . ' - Coop Tracker')

@section('content')
<div class="eyebrow">{{ __('messages.welcome_back') }}</div>
<h2 class="page-title">{{ __('messages.sign_in') }}</h2>

<form method="POST" action="{{ route('login') }}">
    {{-- CSRF token: required for every POST form in Laravel --}}
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">{{ __('messages.email') }}</label>
        {{-- old() keeps the typed email after a failed attempt; @error shows validation messages --}}
        <input id="email" type="email" name="email" value="{{ old('email') }}"
               class="form-control form-control-lg @error('email') is-invalid @enderror" required autofocus>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">{{ __('messages.password') }}</label>
        <input id="password" type="password" name="password"
               class="form-control form-control-lg @error('password') is-invalid @enderror" required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" name="remember" id="remember">
        <label class="form-check-label" for="remember">{{ __('messages.remember_me') }}</label>
    </div>

    <button type="submit" class="btn btn-accent w-100">{{ __('messages.login') }}</button>
</form>

<p class="mt-4 mb-0 text-muted-2">
    {{ __('messages.new_student') }} <a href="{{ route('register') }}">{{ __('messages.create_account_link') }}</a>
</p>
@endsection