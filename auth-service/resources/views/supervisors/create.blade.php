@extends('layouts.panel')

@section('title', __('messages.add_supervisor_title'))

@section('content')
<h1 class="page-title">{{ __('messages.add_supervisor_title') }}</h1>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('supervisors.store') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">{{ __('messages.full_name') }}</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}"
                       class="form-control @error('name') is-invalid @enderror" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('messages.email') }}</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('messages.password') }}</label>
                <input id="password" name="password" type="password"
                       class="form-control @error('password') is-invalid @enderror" required>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">{{ __('messages.confirm_password') }}</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-accent px-4">{{ __('messages.save') }}</button>
            <a href="{{ route('supervisors.index') }}" class="btn btn-quiet px-4 d-inline-flex align-items-center">{{ __('messages.cancel') }}</a>
        </form>
    </div>
</div>
@endsection