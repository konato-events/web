@extends('layout-master')
@section('title', 'Event Discovery')

@section('css')
    <style type="text/css">
        #hero h1 {
            font-size: 2.7rem;
        }
        #hero p {
            font-size: 1.7rem;
        }
        .card .description {
            font-size: 1.1rem;
        }
        @media only screen and (max-width: 992px) { /* @tabletBreakpoint */
            .computer.only.row {
                display: none !important;
            }
            #hero p {
                margin-bottom: 0;
            }
        }
    </style>
@endsection

@section('js')
    <script type="text/javascript">
        $('#hero img').popup();
    </script>
@endsection

@section('content')
    <div class="ui grid container">
        <div class="row">
            <div class="fifteen wide centered column">
                <div class="ui raised padded piled segment">
                    <div class="ui grid" id="hero">
                        <div class="eight wide text column">
                            <h1 class="ui header"><?=_('Find exciting events')?></h1>
                            <p><?=_('Discover even more.<br>Share your knowledge.<br>Get to know great people!')?></p>
                            <div class="computer only row">
                                <?php $form = '
                                <form action="">
                                    <div class="ui huge fluid action input">
                                        <input type="text" placeholder="'._('Theme or keyword').'" />
                                        <button class="ui big orange right labeled icon button">
                                            <i class="search icon"></i> Find events!
                                        </button>
                                    </div>
                                </form>'; ?>
                                <?=$form?>
                            </div>
                        </div>
                        <div class="eight wide column">
                            <img src="/img/event-sample1.jpg" class="ui middle aligned large image"
                                 title="iMasters Developer Week - Rio de Janeiro, <?=_('September')?> 2015"
                                 data-position="bottom center" />
                        </div>
                        <div class="mobile tablet only sixteen wide column">
                            <?=$form?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ui three column stackable row">
            <div class="column">
                <div class="ui fluid orange card">
                    <div class="center aligned content">
                        <h2 class="ui icon header">
                            <i class="map icon"></i>
                            <?=_('Explore new meetings')?>
                        </h2>
                        <p class="description"><?=_('Ever though <em>"hey, I never heard of that event! How could I miss it?"</em><br>Enter <strong>Konato</strong>: that won\'t happen again.')?></p>
                    </div>
                </div>
            </div>

            <div class="column">
                <div class="ui fluid orange card">
                    <div class="center aligned content">
                        <h2 class="ui icon header">
                            <i class="announcement icon"></i>
                            <?=_('Spread what you know')?>
                        </h2>
                        <p class="description"><?=_('Reach new audiences and get close to your public - or <em>that</em> speaker from the last congress you\'ve been.')?></p>
                    </div>
                </div>
            </div>

            <div class="column">
                <div class="ui fluid orange card">
                    <div class="center aligned content">
                        <h2 class="ui icon header">
                            <i class="users icon"></i>
                            <?=_('Meet new people')?>
                        </h2>
                        <p class="description"><?=_('Make new contacts, expand your network and meet like-minded students or professionals - not only those who live nearby.')?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection