@props(['status' => 'draft'])
@php
  $colors = ['draft' => 'secondary', 'submitted' => 'warning',
             'reviewed' => 'success', 'changes_requested' => 'danger'];
@endphp
<span {{ $attributes->merge(['class' => 'badge-soft '.($colors[$status] ?? 'secondary')]) }}>
  {{ __('reports.status_'.$status) }}
</span>

