@extends('layout-master')

@section('header')
    <section id="page-header" class="header-inset page-section image breadcrumbs overlay small clearfix" style="background-image: url(@yield('header-bg'))">
        <div class="container">
            @yield('header-content')

            <h1>@yield('header-title')</h1>
            @yield('header-breadcrumbs')

            @if (false) {{-- This is sample markup for breadcrumbs --}}
                <ul class="breadcrumb">
                    <li><a href="#">IT (Information Technologies)</a></li>
                    <li><a href="#">Languages</a></li>
                    <li class="active">PHP</li>
                </ul>
            @endif
        </div>
    </section>
@endsection
