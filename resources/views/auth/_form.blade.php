@extends('layout-header')
@section('title', $title)
@section('header-title', $header)
@section('header-subtitle', $subheader)

@section('content')
    <section class="page-section first-section">
        <div class="container">

            <div class="row">
                <div class="col-xs-12   col-sm-8 col-sm-offset-2   col-md-6 col-md-offset-3   col-lg-4 col-lg-offset-4">
                    @yield('form')
                </div>
            </div>

        </div>
    </section>
@endsection
