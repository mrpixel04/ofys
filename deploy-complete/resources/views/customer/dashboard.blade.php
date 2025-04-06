<x-app-layout>
    @livewire('customer.dashboard', ['tab' => request()->query('tab')])
</x-app-layout>