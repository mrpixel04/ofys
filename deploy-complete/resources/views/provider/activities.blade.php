@extends('layouts.provider.app')

@section('header', 'Activities & Services')

@section('content')
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @livewire('provider.manage-activities')
    </div>
@endsection
