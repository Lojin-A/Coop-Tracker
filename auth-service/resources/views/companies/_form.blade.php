{{-- Shared fields for the create and edit forms; old() keeps typed values after a validation error --}}
<div class="mb-3">
    <label for="name" class="form-label">{{ __('messages.name') }}</label>
    <input id="name" name="name" type="text" value="{{ old('name', $company->name ?? '') }}"
           class="form-control @error('name') is-invalid @enderror" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="city" class="form-label">{{ __('messages.city') }}</label>
    <input id="city" name="city" type="text" value="{{ old('city', $company->city ?? '') }}"
           class="form-control @error('city') is-invalid @enderror" required>
    @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="field" class="form-label">{{ __('messages.field') }}</label>
    <input id="field" name="field" type="text" value="{{ old('field', $company->field ?? '') }}"
           class="form-control @error('field') is-invalid @enderror" required>
    @error('field') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="seats" class="form-label">{{ __('messages.seats') }}</label>
    <input id="seats" name="seats" type="number" min="1" value="{{ old('seats', $company->seats ?? '') }}"
           class="form-control @error('seats') is-invalid @enderror" required>
    @error('seats') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>