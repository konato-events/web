@extends('layout-master')

@section('header')
    <section id="page-header" class="header-inset page-section image breadcrumbs overlay small clearfix" style="background-image: url(@yield('header-bg'))">
        <div class="container">
            @yield('header-content')

            <h1>
                {{-- this @if clause is hackish way to work around @yield usage inside another directive --}}
                @if ($__env->yieldContent('header-link'))
                    <a href="@yield('header-link')">@yield('header-title')</a>
                @else
                    @yield('header-title')
                @endif
            </h1>
            <h2>@yield('header-subtitle')</h2>
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
