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
    <link rel="stylesheet" type="text/css" href="/css/semantic/dist/semantic.min.css">

    <script src="/css/semantic/dist/semantic.min.js"></script>
</head>
<body id="home"><!-- TODO: change the body ID -->
<div class="container">
    @section('sidebar')
        This is the master sidebar.
    @show

    <div class="content">
        @yield('content')
    </div>
</div>
</body>
</html>
