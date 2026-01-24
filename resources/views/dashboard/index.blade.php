@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
<div class="px-4 py-6 sm:px-0">
    @if(auth()->user()->isAdmin())
        @include('admin.dashboard')
    @else
        @include('dashboard.user')
    @endif
</div>
@endsection