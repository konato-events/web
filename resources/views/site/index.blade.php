@extends('layout-master')
@section('title', 'Event Discovery')

@section('content')
    <div class="row">
        <div class="fifteen wide centered column">
            <div class="ui raised very padded segment">
                <div class="ui grid">
                    <div class="eight wide text column">
                        <h1 class="ui header"><?=_('Discover new events')?></h1>
                        <p>Share Knowledge. Discover. Meet new people.</p>
                        <i>add here a search box, calling the user to make a search for new events or topics</i>
                    </div>
                    <div class="eight wide column">
                        <img src="/img/event-sample1.jpg" alt="" class="ui middle aligned large image" />
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection