<?php
namespace App\Http\Controllers;

class SiteController extends Controller {

    public function getIndex() {
        $events = [
            1 => ['/img/event-sample1.jpg', 'iMasters Developer Week RJ' , 'Rio de Janeiro, Brazil'],
            2 => ['/img/event-sample2.jpg', 'PHP\'n Rio 2011', 'Rio de Janeiro, Brazil'],
            3 => ['/img/event-sample3.jpg', 'PHPConf 2015', 'Osasco, Brazil'],
            4 => ['/img/event-sample4.jpg', 'TDCOnline 2015 POA', 'Porto Alegre, Brazil'],
            5 => ['/img/event-sample5.jpg', 'O\'Reilly\'s Fluent', 'San Francisco, USA'],
            6 => ['/img/event-sample6.gif', 'UERJ Sem Muros', 'Rio de Janeiro, Brazil'],
            7 => ['/img/event-sample7.jpg', '53º Congresso HUPE', 'Rio de Janeiro, Brazil'],
            8 => ['/img/event-sample8.png', 'XXVI Congresso Brasileiro de Virologia', 'Florianópolis,
                            Brazil']
        ];
        shuffle($events);

        return view('site.index', compact('events'));
    }

}