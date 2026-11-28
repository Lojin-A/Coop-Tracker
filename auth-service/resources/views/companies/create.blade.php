@extends('layouts.panel')

@section('title', __('messages.add_company_title'))

@section('content')
<h1 class="page-title">{{ __('messages.add_company_title') }}</h1>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('companies.store') }}">
            @csrf
            @include('companies._form')
            <button type="submit" class="btn btn-accent px-4">{{ __('messages.save') }}</button>
            <a href="{{ route('companies.index') }}" class="btn btn-quiet px-4 d-inline-flex align-items-center">{{ __('messages.cancel') }}</a>
        </form>
    </div>
</div>
@endsection