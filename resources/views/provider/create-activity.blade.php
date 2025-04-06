@extends('layouts.provider.simple-app')

@section('header', $activityId ? 'Edit Activity' : 'Create New Activity')

@section('content')
    @livewire('provider.create-activity', ['activityId' => $activityId])
@endsection
