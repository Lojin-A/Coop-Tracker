@extends('layouts.guest')

@section('title', __('messages.sign_up') . ' - Coop Tracker')

@section('content')
<div class="eyebrow">{{ __('messages.students') }}</div>
<h2 class="page-title">{{ __('messages.create_your_account') }}</h2>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">{{ __('messages.full_name') }}</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}"
               class="form-control form-control-lg @error('name') is-invalid @enderror" required autofocus>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">{{ __('messages.email') }}</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}"
               class="form-control form-control-lg @error('email') is-invalid @enderror" required>
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

    <div class="mb-4">
        <label for="password_confirmation" class="form-label">{{ __('messages.confirm_password') }}</label>
        {{-- The field name must be password_confirmation for the "confirmed" rule to work --}}
        <input id="password_confirmation" type="password" name="password_confirmation"
               class="form-control form-control-lg" required>
    </div>

    <button type="submit" class="btn btn-accent w-100">{{ __('messages.sign_up') }}</button>
</form>

<p class="mt-4 mb-0 text-muted-2">
    {{ __('messages.have_account') }} <a href="{{ route('login') }}">{{ __('messages.sign_in') }}</a>
</p>
@endsection