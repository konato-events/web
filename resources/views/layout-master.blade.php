<?php
use App\Providers\L10nServiceProvider as l10n;
/** @var bool $prod */
/** @var string $action */
/** @var string $controller */
$lang_tag = substr(LOCALE, 0, 2);
$available_locales = l10n::getAvailableLocales();
?>
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
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@section('title')<?=_('Event Discovery')?>@show [Konato]</title>{{-- https://moz.com/learn/seo/title-tag --}}
    <meta content="Konato" name="apple-mobile-web-app-title">
    <meta content="Konato" name="application-name">

    @include('_favicons')

    <meta name="theme-color" content="#5d78bd"> {{-- Chrome, Firefox OS and Opera --}}
    <meta name="msapplication-navbutton-color" content="#5d78bd"> {{-- Windows Phone --}}
    <meta name="apple-mobile-web-app-status-bar-style" content="#5d78bd"> {{-- iOS Safari --}}

    <?// FIXME: COMPILE THIS STUFF!!!!!!!1111ONE11! ?>

    <? if($prod): ?>
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Raleway:400,100,700,900|Roboto:400,700|Roboto+Slab">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ elixir('css/styles.css') }}">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <? else: ?>
        <link rel="stylesheet" href="/assets/fonts/fonts.css">
        <link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/styles.css">
        <link rel="stylesheet" href="/assets/plugins/fontawesome/css/font-awesome.min.css">
    <? endif ?>

    <link rel="stylesheet" href="/img/icons/extra-sites/extra-sites.css">
    <link rel="stylesheet" href="/assets/plugins/animate/animate.min.css"><?//TODO see if those animations are used anywhere ?>

    <!--[if lt IE 9]>
        <script src="/assets/plugins/iesupport/html5shiv.js"></script>
        <script src="/assets/plugins/iesupport/respond.min.js"></script>
    <![endif]-->

    @yield('css')
    @yield('head-js')

    <?php
        $host  = (isset($_SERVER['HTTPS'])? 'https://' : 'http://').$_SERVER['HTTP_HOST'];
        $path  = $host.$_SERVER['REQUEST_URI'];
        $query = $_SERVER['QUERY_STRING']? '&'.$_SERVER['QUERY_STRING'] : '';
        foreach ($available_locales as $locale) {
            echo "<link rel='alternate' hreflang='$locale' href='{$path}?locale={$locale}{$query}' />";
        }
    ?>
    <link rel="alternate" hreflang="x-default" href="<?=$path?><?=$query? '?'.$query : ''?>" />
</head>

<body id="<?=$controller?>" class="wide body-light multipage <?=$controller?>-<?=$action?>">

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

        <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed btn-theme-light" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only"><?=_('Toggle navigation')?></span>
                    <i class="fa fa-bars"></i>
                </button>

                <div class="logo">
                    <a href="/" class="scroll-to">
                        <span class="fa-stack">
                            <i class="fa logo-hex fa-stack-2x"></i>
                            <i class="fa logo-fa fa-cloud fa-stack-1x"></i>
                        </span>
                        Konato
                    </a>
                </div>
            </div>

            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <?//=activableLink(icon('table')._('Dashboard'), 'user@dashboard')?>
                    <?//=activableLink(icon('map-marker')._('Places'), 'events@places')?>
                    <?=activableLink(icon('comments-o')._('Speakers'), 'user@speakers')?>

                    <li id="header-search-wrapper">
                        <form action="<?=act('event@search')?>" method="get" class="header-search-form">
                            <input type="search" name="q" class="form-control header-search" placeholder="<?=_('Find events')?>" />
                            <input type="submit" hidden="hidden" />
                        </form>
                    </li>
                    <li><a href="#" id="btn-search-toggle"><i class="fa fa-search"></i></a></li>

                    <? if (\Auth::check()): ?>
                        <? /** @var \App\Models\User $user */ $user = \Auth::getUser() ?>

                        <li class="nav-btn">
                            <a href="<?=act('event@submit')?>" class="btn btn-theme <? if ($action == 'submit'): ?>btn-theme-dark<? endif ?>">
                                <i class="fa fa-calendar-plus-o"></i> <?=_('Submit event')?>
                            </a>
                        </li>

                        <li class="nav-btn user-profile">
                            <div class="dropdown">
                                <button class="btn btn-theme btn-theme-light" data-target="#" data-toggle="dropdown"
                                        role="button" aria-haspopup="true" aria-expanded="false" id="profileButton">
                                    <img src="<?=$user->avatar?>" alt="<?=$user->name?>" />
                                    <?=$user->name?>
                                    <i class="fa fa-caret-down"></i>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="profileButton">
                                    <?=activableLink(icon('user')._('My profile'), 'user@profile', [$user->slug])?>
                                    <?=activableLink(icon('edit')._('Edit my profile'), 'user@edit')?>
                                    <?=activableLink(icon('sign-out')._('Logout'), 'auth@logout')?>
                                </ul>
                            </div>
                        </li>
                    <? else: ?>
                        <?=activableLink(icon('user-plus')._('Sign up'), 'auth@signUp', [], 'li', [
                            'wrap' => ['class' => 'nav-btn'],
                            'link' => ['class' => 'btn btn-theme']
                        ])?>
                        <?=activableLink(icon('at')._('Login'), 'auth@login', [], 'li', [
                            'wrap' => ['class' => 'nav-btn'],
                            'link' => ['class' => 'btn btn-theme btn-theme-light']
                        ])?>
                    <? endif ?>
                </ul>
            </div>
        </div>
        </nav>

    </header>

    <div class="content-area">
        @yield('header')
        @yield('content')
    </div>

    <div class="footer-container">
        <footer class="text-center">
            {{--TIP: cool block with several social icons. Certainly useful later!--}}
            <!--{{--<div class="clearfix">--}}
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
            {{--</div>--}}-->
            <span><?=_('Discover amazing events on Konato')?>&nbsp;&copy;&nbsp;<?=date('Y')?></span>
            <small>
                <?=sprintf(_('%sHard work (and poutine!)%s made this real @ Rio&nbsp;de&nbsp;Janeiro'),
                    '<a href="https://about.me/igorsantos07" target="_blank">', '</a>') ?>
                <img src="/img/sugar-loaf-icon.png" title="<?=_('Marvelous City, place of the Sugar Loaf')?>">
            </small>
            <ul>
                <li><a href="<?=act('site@about')?>"><?=_('About us')?></a></li>
                <li><a href="#"><?=_('Get in touch')?></a></li>
                <li><a href="https://bitbucket.org/konato/web"><?=_('We &#9829; open source')?></a></li>
                <li><a target="_blank" href="http://igorsantos.com.br"><?=_('by igorsantos07')?></a></li>

                <li>
                    <div class="btn-group dropup">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-language"></i> <?=_('Language')?> <i class="fa fa-caret-up"></i>
                        </a>
                        <ul class="dropdown-menu language-menu">
                            <? foreach ($available_locales as $code): ?>
                                <li>
                                    <a href="?locale=<?=$code?>">
                                        <?=l10n::localeNames()[$code][0]?>
                                        <small> - <?=_(l10n::localeNames()[$code][1])?></small>
                                    </a>
                                </li>
                            <? endforeach ?>
                        </ul>
                    </div>
                </li>
            </ul>
        </footer>
    </div>

@yield('popups')

</div>

{{-- JS Global --}}
<script type="text/javascript" src="/js/alertify.js"></script>
<script type="text/javascript">
    alertify
        .closeLogOnClick(true)
        .delay(10000)
        .logPosition('top left');

    <? foreach (['info', 'success', 'warning', 'error'] as $msg_name): ?>
        <? if(session($msg_name)): ?>
            alertify.log("<?=addslashes(session($msg_name))?>");
        <? endif ?>
    <? endforeach ?>
</script>

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
<?php if (!$prod): ?>
    <script src="/js/app.js"></script>
<?php else: ?>
    <script src="{{ elixir('js/app.js') }}"></script>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-58159624-2', 'auto');
        ga('require', 'linkid');
        <? if (\Auth::check()): ?>
            ga('set', '&uid', '<?=Auth::user()->id?>');
        <? endif ?>
        ga('send', 'pageview');
    </script>
<?php endif ?>

<script src="/assets/js/theme.js"></script>

@yield('js')

</body>
</html>
