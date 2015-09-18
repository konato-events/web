{{-- http://laravel.com/docs/5.1/blade --}}
{{-- Sample theme: http://scripteden.com/preview/?preview=274 --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0{{--, maximum-scale=1.0--}}">

    <title>@yield('title') [Konato]</title> {{-- https://moz.com/learn/seo/title-tag --}}

    {{--<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato:100">--}}
    <link rel="stylesheet" type="text/css" href="/semantic/semantic.min.css">

    <script src="/semantic/semantic.min.js"></script>
    <style type="text/css">
        nav.ui.menu {
            border-radius: 0 0 5px 5px;
            margin-bottom: 25px;
        }
        nav.menu .item.header {
            padding: 10px;
            color: black;
        }
        nav.ui.inverted.menu a.item:hover {
            background-color: #3758A9;
        }
        nav.ui.inverted.menu a.header.item:hover {
            background-color: inherit;
        }
        nav.menu .header .image {
            width: 50px;
            margin-top: 0;
            margin-right: 5px;
        }
        nav.ui.inverted.menu a.orange.item:hover {
            background-color: #FB953E;
        }
        nav.ui.inverted .ui.search {
            background-color: whitesmoke !important;
        }
        nav.ui.inverted .ui.transparent.input input {
            background-color: whitesmoke !important;
        }
    </style>
</head>

<body id="home"><!-- TODO: change the body ID -->

<div class="ui page">
    <nav class="ui inverted large menu">
        {{--<div class="ui container">--}}
            <a href="/" class="ui header item">
                <img class="ui middle aligned image" src="/img/logo.png" alt="<?=_('Konato logo')?>">
                <div class="tablet only">Konato</div>
            </a>
            <a href="#" class="item"><i class="icon browser"></i> <?=_('Dashboard')?></a>
            <a href="#" class="item"><i class="icon map"></i> <?=_('Places')?></a>
            <a href="#" class="item"><i class="icon comments outline"></i> <?=_('Speakers')?></a>

            <div class="ui category search item">
                <div class="ui transparent icon input">
                    <input class="prompt" type="text" placeholder="<?=_('Theme or keyword')?>" />
                    <i class="search link icon"></i>
                </div>
            </div>

            <div class="right menu">
                <a href="#" class="orange item"><i class="icon add user"></i> <?=_('Signup')?></a>
                <a href="#" class="item"><i class="icon at"></i><?=_('Login')?></a>
            </div>
        {{--</div>--}}
    </nav>

    <div class="ui grid container">
        @yield('content')
    </div>
</div>
</body>
</html>
