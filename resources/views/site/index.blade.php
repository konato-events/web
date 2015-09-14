@extends('layout-master')
@section('title', 'Event Discovery')

@section('sidebar')
    @parent
    Additional info for sidebar
@endsection

@section('content')
    <div class="title">Welcome, {{ ucfirst($name?:'sir') }}!</div>
@endsection