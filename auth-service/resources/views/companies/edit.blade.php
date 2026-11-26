@extends('layouts.panel')

@section('title', __('messages.edit_company'))

@section('content')
<h1 class="page-title">{{ __('messages.edit_company') }}</h1>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('companies.update', $company) }}">
            @csrf
            @method('PUT')
            @include('companies._form')
            <button type="submit" class="btn btn-accent px-4">{{ __('messages.update') }}</button>
            <a href="{{ route('companies.index') }}" class="btn btn-quiet px-4 d-inline-flex align-items-center">{{ __('messages.cancel') }}</a>
        </form>
    </div>
</div>
@endsection