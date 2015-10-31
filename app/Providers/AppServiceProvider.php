<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use \Illuminate\View\Factory as View;

class AppServiceProvider extends ServiceProvider {

    const LOCALES_PATH = '../resources/locales';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        require_once APP_ROOT.'/resources/views/helpers.php';
        $this->bootGettext();

        /** @var View $view */
        $view = view();
        $view->share('env', \App::environment());
        $view->share('prod', \App::environment('prod'));
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
        $view->share('types', $types);
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

    /**
     * Starts up Gettext with all its settings.
     * @param string $domain
     * @param string $codeset
     * @see https://lingohub.com/blogs/2013/07/php-internationalization-with-gettext-tutorial/
     */
    protected function bootGettext($domain = 'main', $codeset = 'UTF-8') {
        $this->defineLocale($domain);
        putenv('LANG='.LOCALE);
        if (!setlocale(LC_ALL, LOCALE.".$codeset", LOCALE.strtolower(strtr($codeset, ['-' => ''])))) {
            Log::critical('Locale not available in the system: '.LOCALE.'.'.$codeset);
        }
        bindtextdomain($domain, self::LOCALES_PATH);
        bind_textdomain_codeset($domain, $codeset);
        textdomain($domain);
    }

    protected function defineLocale($domain) {
        if (defined('LOCALE')) return true;
        define('DEFAULT_LOCALE', 'en_CA');

        $valid_locale = function ($locale) use ($domain) {
            if (!$locale) return false;
            if ($locale == DEFAULT_LOCALE) {
                Log::info("Using default locale: ".DEFAULT_LOCALE);
                return true;
            }

            $file_path = self::LOCALES_PATH."/$locale/LC_MESSAGES/$domain.mo";
            if (!file_exists($file_path)) {
                Log::warning("Locale does not exist: $file_path");
                return false;
            } elseif (!is_readable($file_path)) {
                Log::warning("Locale is not readable: $file_path");
                return false;
            } else {
                Log::debug("Locale found: $file_path");
                return true;
            }
        };

        if (isset($_GET['locale']) && $valid_locale($_GET['locale'])) {
            define('LOCALE', $_GET['locale']);
            setcookie('locale', LOCALE);
        } elseif (isset($_COOKIE['locale']) && $valid_locale($_COOKIE['locale'])) {
            define('LOCALE', $_COOKIE['locale']);
        } else {
            if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && $_SERVER['HTTP_ACCEPT_LANGUAGE']) {
                $languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
                array_walk($languages, function (&$lang) { $lang = strtr(strtok($lang, ';'), ['-' => '_']); });
                foreach ($languages as $language) {
                    if ($valid_locale($language)) {
                        define('LOCALE', $language);
                        break;
                    }
                }
            }

            if (!defined('LOCALE')) { //could not find any useful language. fallback!
                define('LOCALE', 'en_CA');
            }
        }
    }
}
