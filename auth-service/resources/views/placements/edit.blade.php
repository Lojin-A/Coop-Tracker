@extends('layouts.panel')

@section('title', __('messages.edit_placement'))

@section('content')
<h1 class="page-title">{{ __('messages.edit_placement') }}</h1>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('placements.update', $placement) }}">
            @csrf
            @method('PUT')
            @include('placements._form')
            <button type="submit" class="btn btn-accent px-4">{{ __('messages.update') }}</button>
            <a href="{{ route('placements.index') }}" class="btn btn-quiet px-4 d-inline-flex align-items-center">{{ __('messages.cancel') }}</a>
        </form>
    </div>
</div>
@endsection