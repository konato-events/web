<?php
/** @var \App\Models\User $user */
/** @var \Illuminate\Support\MessageBag $errors */
$title     = _('Login');
$header    = _('Who\'s there?');
$subheader = _('Identify yourself to get access to the platform');
?>
@extends('auth._form')
@section('title', $title)
@section('header-title', $header)
@section('header-subtitle', $subheader)

@section('form')
    <? $intro = _('Currently you can only login with one of the following providers... Soon you\'ll be able to use username + password!') ?>
    @include('auth._providers_list', ['intro' => $intro])
@endsection
