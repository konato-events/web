<? $title = _('About us') ?>

@extends('layout-header')
@section('title', $title)
@section('header-title', $title)

@section('css')
    <style type="text/css">
        #page-header {
            margin-bottom: 30px;
        }
        #page-header h2 {
            margin-top: 0;
        }

        dl {
            margin-bottom: 20px;
        }
        dt {
            margin-top: 20px;
            line-height: 16px;
        }
        dt img {
            height: 16px;
            margin-right: 2px;
            vertical-align: bottom;
        }
        dd, p:first-letter {
            margin-left: 20px;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <h2><?=_('Who\'s behind this?')?></h2>
            <p><?=_r('Besides being a open-source project, there\'s a solo developer behind the project. After eight years of experience with web development and always experimenting new technologies, %sI (Igor)%s decided to start this platform after hitting the head on the wall while trying to plan my participation on some tech conferences. Later, talking with some friends and colleagues about their student lives, I\'ve also noticed how troublesome is the advertisement and discovery of small events, talks or congresses, and finally took the lead to create a revolution on event information online.',
                    '<a href="http://igorsantos.com.br" target="_blank">','</a>')?></p>

            <p><?=_r('This project was partially inspired by %sLanyrd%s, that unfortunately seems to have come to a %spermanent halt on development%s after being bought by EventBrite.',
                    '<a href="http://lanyrd.com" target="_blank">','</a>',
                    '<a href="https://twitter.com/simonw/status/675411467865219072" target="_blank">','</a>')?></p>

        <h2><?=_('Technologies')?> <small> - <?=_('our stack')?></small></h2>
        <dl>
            <dt><img src="/img/icons/tools/php.png"/> PHP 7</dt>
            <dd><?=_('Simply put, a clean and reliable language, without uninteligible magic going on but still very easy and powerful. Indeed it has its quirks, but nothing an IDE would not solve - while adding other great benefits, we would not be using a behemoth only do know the argument order of <code>substr()</code>, right? The advantages are much bigger than its issues, and the new additions are making it more and more powerful.')?></dd>

            <dt><a href="https://laravel.com" target="_blank"><img src="/img/icons/tools/laravel.png"/> Laravel 5</a></dt>
            <dd><?=_r('The "new kid on the block" in terms of PHP frameworks. Powerful, fast-paced and very extensible, it was used in the project as a test but in the end, it\'s here to stay. Besides having a %sBDFL%s %sblocking some great features and enhancements%s, it\'s agility and overall great community are awesome for a long-term project.<br/>We also use a small library on top of it\'s ORM, called %sArdent%s, that brings together models and validations for a more integrated system.',
                '<a href="https://en.wikipedia.org/wiki/Benevolent_dictator_for_life" target="_blank">','</a>',
                '<a href="https://github.com/laravel/framework/issues/10659" target="_blank">','</a>',
                '<a href="https://github.com/laravel-ardent/ardent" target="_blank">','</a>'
            )?></dd>

            <dt><img src="/img/icons/tools/postgre.png"/> PostgreSQL</dt>
            <dd><?=_('Great database that offers a real SQL experience, with powerful datatypes and out of the box support for geo-related queries. And for free. What else would we ask for?')?></dd>

            <dt>
                <a href="https://www.digitalocean.com/?refcode=a875fa6ef2b6" target="_blank">
                    <img src="/img/icons/tools/digital-ocean.png" />Digital Ocean
                </a>
            </dt>
            <dd><?=_('The favorite VPS of us all. Cheap but also very reliable place to put our test servers, running everyting on SSDs that guarantee the smallest build process possible, to run our tests and ship new versions of the system in no time.')?></dd>

            <dt><a href="https://www.heroku.com" target="_blank"><img src="/img/icons/tools/heroku.png"/> Heroku</a></dt>
            <dd><?=_('That\'s a great platform we are building our system onto. Infrastructure with no hassle at all, with top notch technologies available at a click.')?></dd>
        </dl>

        <h3><?=_('Supporting tools')?></h3>
        <dl>
            <dt><a href="https://www.bitbucket.org" target="_blank"><img src="/img/icons/tools/bitbucket.png"/> Bitbucket</a></dt>
            <dd>
                <?=_r('Bitbucket was chosen over GitHub mainly because of its %spowerful issue tracker%s. As our code is open source, we needed a trusted place to put it, and together with a great way to organize tasks and milestones, that\'s for sure a great idea.',
                    '<a href="https://bitbucket.org/konato/web/issues?status=new&status=open" target="_blank">', '</a>'
                )?>
            </dd>

            <dt>
                <a href="https://www.browserstack.com" target="_blank">
                    <img src="/img/icons/tools/browserstack.png"/> BrowserStack
                </a>
            </dt>
            <dd><?=_r('We use BrowserStack to attest our compatibility with some <i>uncommon</i> browsers, such as Internet Explorer. In the future we plan to use their awesome plataform to run %sautomated compatibility tests%s as well. Thanks for the support!',
                '<a href="https://www.browserstack.com/automate" target="_blank">', '</a>'
            )?></dd>

            <dt>
                <a href="https://www.rescuetime.com/ref/1098140" target="_blank">
                    <img src="/img/icons/tools/rescuetime.png"/> RescueTime
                </a>
            </dt>
            <dd><?=_('Best software ever to manage your time and keep track of your daily performance. This has been a great ally for me for many years, and helps us to get focused and understand our work patterns. Certainly a need for anyone that needs a computer for daily work!')?></dd>
        </dl>

    </div>
</div>
@endsection
