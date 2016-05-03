<?php namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use \Illuminate\View\Factory as View;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot() {
        require_once base_path('/resources/views/helpers.php');

        /** @var View $view */
        $app  = app();
        $view = view();
        $view->share('env', $app->environment());
        $view->share('prod', $app->environment('prod'));
        $this->loadMocks($view);
    }

    private function loadMocks(View $view) {
        $events = [
            1 => ['/img/event-sample1.jpg', 'iMasters Developer Week RJ' , 'Rio de Janeiro, Brazil'],
            2 => ['/img/event-sample2.jpg', 'PHP\'n Rio 2011', 'Rio de Janeiro, Brazil'],
            3 => ['/img/event-sample3.jpg', 'PHPConf 2015', 'Osasco, Brazil'],
            4 => ['/img/event-sample4.jpg', 'TDCOnline 2015 POA', 'Porto Alegre, Brazil'],
            5 => ['/img/event-sample5.jpg', 'O\'Reilly\'s Fluent', 'San Francisco, USA'],
            6 => ['/img/event-sample6.gif', 'UERJ Sem Muros', 'Rio de Janeiro, Brazil'],
            7 => ['/img/event-sample7.jpg', '53º Congresso HUPE', 'Rio de Janeiro, Brazil'],
            8 => ['/img/event-sample8.png', 'XXVI Congresso Brasileiro de Virologia', 'Florianópolis, Brazil']
        ];
        foreach($events as $i => &$event) {
            $event[] = time();
            $event[] = ($i % 2)? time() + 60*60*24*3 : null;
            $event[] = 'Fusce pellentesque velvitae tincidunt egestas. Pellentesque habitant morbi. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis.
            Bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris.';
            $event[] = (bool)rand(0,1);
            $event[] = 'http://www.google.com.br';
            $event[] = 'konato';
            $event[] = 'konato2015';
        }

        $types = [
            _('Congresses'),
            _('Meetings'),
            _('Talks & discussions'),
            _('University meetings'),
            _('Cultural'),
        ];
        $selected_types = array_rand($types, 2);

        $themes = explode(' ', 'PHP Databases MySQL Webdesign APIs');
        $selected_themes = array_rand($themes, 2);

        $speakers = [
            ['/img/speaker-sample1.jpg', 'Fabio Akita', 'São Paulo, Brazil', ['Ruby', 'Agile', 'Speaking']],
            ['/img/speaker-sample2.jpg', 'Raphael de Almeida', 'Rio de Janeiro, Brazil', ['PHP', 'Microsserviços', 'Ruby']],
            ['/img/speaker-sample3.jpg', 'Valéria Parajara', 'Rio de Janeiro, Brazil', ['Ruby', 'Gastronomia']],
            ['/img/speaker-sample4.jpg', 'Pedro Couteiro', 'Tsukuba, Japan', ['CG', 'Java', 'Japanese']],
            ['/img/speaker-sample5.jpg', 'Luan Rodrigues', 'Rio de Janeiro, Brazil', ['Computação médica', 'Cirurgia plástica']],
            ['/img/speaker-sample6.jpg', 'Igor Santos', 'Halifax, Canada', ['Web Services', 'PHP']],
        ];
        foreach($speakers as $i => &$speaker) {
            $speaker[] = rand(5, 15);
            $speaker[] = rand(15, 50);
            $speaker[] = 'Fusce pellentesque velvitae tincidunt egestas. Pellentesque habitant morbi.';
            $speaker[] = ['M', 'M', 'F', 'M', 'M', 'M'][$i];
        }

        $materials = [
            ['http://www.google.com', 'How to be Agile in Project Management', 'doc', $speakers[1]],
            ['http://pt.slideshare.net/igorsantos07/rest-fuuuu-54458320', 'The RESTful Police', 'slide', $speakers[5]],
            ['http://www.google.com', 'Immobilized lipase reutilization on biodiesel syntesis from soy oil', 'doc', $speakers[3]],
            ['http://www.google.com', 'How to launch a culinary business having an IT background', 'video', $speakers[2]],
        ];

        shuffle($events);
        shuffle($speakers);
        $view->share('events', $events);
//        $view->share('types', $types);
        $view->share('selected_types', $selected_types);
        $view->share('themes', $themes);
        $view->share('selected_themes', $selected_themes);
        $view->share('speakers', $speakers);
        $view->share('materials', $materials);
    }

    /**
     * Register any application services.
     * @return void
     */
    public function register() {
        //
    }

}
