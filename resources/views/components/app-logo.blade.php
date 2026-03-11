@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand {{ $attributes }}>
        <x-slot name="logo">
            <span class="inline-flex h-8 w-[89px] items-center overflow-hidden"><img src="{{ asset('images/logo.png') }}" class="block h-8 w-[89px] shrink-0 object-contain" width="89" height="32" loading="eager" decoding="async" alt="OBRIK"></span>
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand {{ $attributes }}>
        <x-slot name="logo">
            <span class="inline-flex h-8 w-[89px] items-center overflow-hidden"><img src="{{ asset('images/logo.png') }}" class="block h-8 w-[89px] shrink-0 object-contain" width="89" height="32" loading="eager" decoding="async" alt="OBRIK"></span>
        </x-slot>
    </flux:brand>
@endif
