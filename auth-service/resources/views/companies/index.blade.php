@extends('layouts.panel')

@section('title', __('messages.companies'))

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="page-title">{{ __('messages.companies') }}</h1>
    <a href="{{ route('companies.create') }}" class="btn btn-accent px-4 d-inline-flex align-items-center">{{ __('messages.add_company') }}</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __('messages.name') }}</th>
                    <th scope="col">{{ __('messages.city') }}</th>
                    <th scope="col">{{ __('messages.field') }}</th>
                    <th scope="col">{{ __('messages.seats') }}</th>
                    <th scope="col">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($companies as $company)
                    <tr>
                        <td class="num">{{ $company->id }}</td>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->city }}</td>
                        <td>{{ $company->field }}</td>
                        <td class="num">{{ $company->seats }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('companies.edit', $company) }}" class="btn btn-quiet btn-sm d-inline-flex align-items-center">{{ __('messages.edit') }}</a>

                                {{-- DELETE needs a form with @csrf and @method('DELETE') --}}
                                <form method="POST" action="{{ route('companies.destroy', $company) }}"
                                      onsubmit="return confirm('{{ __('messages.confirm_delete_company') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-reject btn-sm">{{ __('messages.delete') }}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted-2 py-4">{{ __('messages.no_companies') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection