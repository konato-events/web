<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    const LOCALES_PATH = '../resources/locales';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $this->bootGettext();
        $view = view();
        $view->share('env', \App::environment());
        $view->share('prod', \App::environment('prod'));
        // add here global view variables using $view->share('key', 'value');
    }

    /**
     * Register any application services.
     *
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
