@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand {{ $attributes }}>
        <x-slot name="logo">
            <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto object-contain" alt="OBRIK">
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand {{ $attributes }}>
        <x-slot name="logo">
            <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto object-contain" alt="OBRIK">
        </x-slot>
    </flux:brand>
@endif
