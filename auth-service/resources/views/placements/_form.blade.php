{{-- Shared fields for the create and edit forms; old() keeps typed values after a validation error --}}
<div class="mb-3">
    <label for="student_id" class="form-label">{{ __('messages.student') }}</label>
    <select id="student_id" name="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
        <option value="">{{ __('messages.select_student') }}</option>
        @foreach ($students as $student)
            <option value="{{ $student->id }}" @selected(old('student_id', $placement->student_id ?? request('student_id')) == $student->id)>{{ $student->name }}</option>
        @endforeach
    </select>
    @error('student_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="supervisor_id" class="form-label">{{ __('messages.supervisor') }}</label>
    <select id="supervisor_id" name="supervisor_id" class="form-select @error('supervisor_id') is-invalid @enderror" required>
        <option value="">{{ __('messages.select_supervisor') }}</option>
        @foreach ($supervisors as $supervisor)
            <option value="{{ $supervisor->id }}" @selected(old('supervisor_id', $placement->supervisor_id ?? '') == $supervisor->id)>{{ $supervisor->name }}</option>
        @endforeach
    </select>
    @error('supervisor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="company_id" class="form-label">{{ __('messages.company') }}</label>
    <select id="company_id" name="company_id" class="form-select @error('company_id') is-invalid @enderror" required>
        <option value="">{{ __('messages.select_company') }}</option>
        @foreach ($companies as $company)
            <option value="{{ $company->id }}" @selected(old('company_id', $placement->company_id ?? '') == $company->id)>{{ $company->name }}</option>
        @endforeach
    </select>
    @error('company_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="start_date" class="form-label">{{ __('messages.start_date') }}</label>
        <input id="start_date" name="start_date" type="date" value="{{ old('start_date', $placement->start_date ?? '') }}"
               class="form-control @error('start_date') is-invalid @enderror" required>
        @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="end_date" class="form-label">{{ __('messages.end_date') }}</label>
        <input id="end_date" name="end_date" type="date" value="{{ old('end_date', $placement->end_date ?? '') }}"
               class="form-control @error('end_date') is-invalid @enderror" required>
        @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="required_weeks" class="form-label">{{ __('messages.required_weeks') }}</label>
        <input id="required_weeks" name="required_weeks" type="number" min="1" value="{{ old('required_weeks', $placement->required_weeks ?? 24) }}"
               class="form-control @error('required_weeks') is-invalid @enderror" required>
        @error('required_weeks') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="status" class="form-label">{{ __('messages.status') }}</label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            @foreach (['active', 'completed', 'cancelled'] as $value)
                <option value="{{ $value }}" @selected(old('status', $placement->status ?? 'active') === $value)>{{ __('messages.status_' . $value) }}</option>
            @endforeach
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>