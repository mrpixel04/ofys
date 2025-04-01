@extends('layouts.provider.app')

@section('header', 'Shop Information')

@section('content')
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @livewire('provider.edit-shop-info')
    </div>
@endsection
