<?php $lang_tag = substr(LOCALE, 0, 2); ?>
<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html class="ie ie6" lang="<?=$lang_tag?>"><![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7" lang="<?=$lang_tag?>"><![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8" lang="<?=$lang_tag?>"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="<?=$lang_tag?>"><!--<![endif]-->
<head>
    <meta charset="utf-8">
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@section('title')<?=_('Event Discovery')?>@show [Konato]</title>{{-- https://moz.com/learn/seo/title-tag --}}
    <meta content="Konato" name="apple-mobile-web-app-title">
    <meta content="Konato" name="application-name">

    @include('_favicons')

    {{-- FIXME: COMPILE THIS STUFF!!!!!!!1111ONE11! --}}
    <link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/plugins/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/plugins/bootstrap-select/bootstrap-select.min.css">
    {{--<link rel="stylesheet" href="/assets/plugins/owlcarousel2/assets/owl.carousel.min.css">--}}
    {{--<link rel="stylesheet" href="/assets/plugins/owlcarousel2/assets/owl.theme.default.min.css">--}}
    <link rel="stylesheet" href="/assets/plugins/prettyphoto/css/prettyPhoto.css">
    <link rel="stylesheet" href="/assets/plugins/animate/animate.min.css">
    <link rel="stylesheet" href="/assets/plugins/countdown/jquery.countdown.css">
    <link rel="stylesheet" href="/css/styles.css">

    <!--[if lt IE 9]>
        <script src="/assets/plugins/iesupport/html5shiv.js"></script>
        <script src="/assets/plugins/iesupport/respond.min.js"></script>
    <![endif]-->

    @yield('css')
    @yield('head-js')
</head>
<body id="home" class="wide body-light multipage">

<div class="wrapper">

    <!-- TODO: reevaluate H1~H6 usage, it's a little messy right now -->
    <header class="header fixed">

        {{-- Notification bar. Could be used later }}
            <div class="top-line">
                <div class="container">
                    <ul class="user-menu">
                        <li><a href="#popup-login"  data-toggle="modal"><i class="fa fa-file-text-o"></i> Register Now</a></li>
                        <li><a href="#popup-login" data-toggle="modal"><i class="fa fa-user"></i> Login</a></li>
                    </ul>
                    <div class="hot-line"><span><i class="fa fa-calendar"></i> <strong>Latest Event:</strong></span>  Standart Event Name Here  "15 October at 20:00 - 22:00 on Manhattan / New York"</div>
                </div>
            </div>
        {{ --}}

        <div class="container">
            <div class="header-wrapper clearfix">

                <div class="logo">
                    <a href="/" class="scroll-to">
                        <span class="fa-stack">
                            <i class="fa logo-hex fa-stack-2x"></i>
                            <i class="fa logo-fa fa-cloud fa-stack-1x"></i>
                        </span>
                        Konato
                    </a>
                </div>

                <!-- Navigation -->
                <div id="mobile-menu"></div>
                <nav class="navigation closed clearfix">
                    <a href="#" class="menu-toggle btn"><i class="fa fa-bars"></i></a>
                    <ul class="sf-menu nav">
                        <li{{-- class="active"--}}><a href="/"><i class="fa fa-table"></i> <?=_('Dashboard')?></a></li>
                        <!--<li><a href="#"><i class="fa fa-map-marker"></i> <?=_('Places')?></a></li>-->
                        <li><a href="{{act('speaker')}}"><i class="fa fa-comments-o"></i> <?=_('Speakers')?></a></li>

                        <li class="header-search-wrapper">
                            <form action="#" class="header-search-form">
                                <input type="text" class="form-control header-search" placeholder="Search" />
                                <input type="submit" hidden="hidden" />
                            </form>
                        </li>
                        <li><a href="#" class="btn-search-toggle"><i class="fa fa-search"></i></a></li>
                        <li>
                            <a href="#" class="btn btn-theme">
                                <i class="fa fa-user-plus"></i> <?=_('Sign up')?>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="btn btn-theme btn-theme-light">
                                <i class="fa fa-at"></i> <?=_('Login')?>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /Navigation -->

            </div>
        </div>
    </header>

    <div class="content-area">
        @yield('header')
        @yield('content')
    </div>
    <!-- /Content area -->

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-meta">
            <div class="container text-center">
                {{-- TIP: cool block with several social icons. Certainly useful later! --}}
                {{--<div class="clearfix">--}}
                    {{--<ul class="social-line list-inline">--}}
                        {{--<li>--}}
                            {{--<a href="#" class="twitter"><i class="fa fa-twitter"></i></a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#" class="dribbble"><i class="fa fa-dribbble"></i></a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#" class="facebook"><i class="fa fa-facebook"></i></a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#" class="google"><i class="fa fa-google-plus"></i></a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#" class="instagram"><i class="fa fa-instagram"></i></a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#" class="pinterest"><i class="fa fa-pinterest"></i></a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#" class="skype"><i class="fa fa-skype"></i></a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
                <span class="copyright">
                    <?=_('Discover amazing events on Konato')?> &copy; <?=date('Y')?>
                    <span>
                        <?=sprintf(_('%sHard work (and poutine!)%s made this real @ Rio de Janeiro'),
                            '<a href="https://about.me/igorsantos07" target="_blank">', '</a>') ?>
                        <img src="/img/sugar-loaf-icon.png" title="<?=_('Marvelous City, place of the Sugar Loaf')?>">
                    </span>
                    <ul>
                        <li><a href="#"><?=_('Get in touch')?></a></li>
                        <li><a href="#" title="<?=_('Sorting out some private key issues before publishing code. Check back soon or send me a message :)')?>"><?=_('We &#9829; open source')?></a></li>
                        <li><a target="_blank" href="http://igorsantos.com.br"><?=_('by igorsantos07')?></a></li>
                    </ul>
                </span>
            </div>
        </div>
    </footer>
    <!-- /FOOTER -->

    <!--<div class="to-top"><?=_('Go to top')?> <i class="fa fa-angle-up"></i></div>-->

@yield('popups')

</div>
<!-- /Wrap all content -->

<!-- JS Global -->

<?php
    const JQUERY_VERSION = '2.1.4';
    const JQUERY_COMPAT_VERSION = '1.11.3';
    if ($prod):
?>
    <!--[if lt IE 9]><script src="//code.jquery.com/jquery-{{ JQUERY_COMPAT_VERSION }}.min.js"></script><![endif]-->
    <!--[if gte IE 9]><!--><script src="//code.jquery.com/jquery-{{ JQUERY_VERSION }}.min.js"></script><!--<![endif]-->
<?php else: ?>
    <!--[if lt IE 9]><script src="/js/jquery-{{ JQUERY_COMPAT_VERSION }}.js"></script><![endif]-->
    <!--[if gte IE 9]><!--><script src="/js/jquery-{{ JQUERY_VERSION }}.js"></script><!--<![endif]-->
<?php endif ?>

<script src="/assets/plugins/modernizr.custom.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="/assets/plugins/superfish/js/superfish.js"></script>
<script src="/assets/plugins/prettyphoto/js/jquery.prettyPhoto.js"></script>
<script src="/assets/plugins/placeholdem.min.js"></script>
<script src="/assets/plugins/jquery.smoothscroll.min.js"></script>
<script src="/assets/plugins/jquery.easing.min.js"></script>
<script src="/assets/plugins/smooth-scrollbar.min.js"></script>
<script src="/js/app.js"></script>

@yield('js')

</body>
</html>
