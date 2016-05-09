<?php
/** @var \App\Models\User $user */
$title       = _('Edit your profile');
$subtitle    = _('Editing your profile');
$total_links = $user->links()->count();
?>
@extends('layout-header')
@section('title', $title)
@section('header-bg', '/img/bg-event.jpg')
@section('header-link', act('user@profile', $user->slug))
@section('header-title', $user->name)
@section('header-subtitle', $subtitle)

@section('content')
    <section class="page-section with-sidebar sidebar-right first-section">
        <div class="container">

            <ul class="nav nav-tabs">
                <?=activableLink(_('General information'), 'user@edit')?>
                <?=activableLink(_('Social networks & external links')." <span class=\"badge\">$total_links</span>",
                    'user@editLinks')?>
            </ul>

            @yield('form_content')
        </div>
    </section>
@endsection
