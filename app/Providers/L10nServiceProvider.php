<?php namespace App\Providers;
use Log;
use Illuminate\Support\ServiceProvider;

class L10nServiceProvider extends ServiceProvider {

    const LOCALES_PATH   = __DIR__.'/../../resources/locales';
    const DEFAULT_LOCALE = 'en_CA';

    /**
     * Manual, alphabetical list of locale names.
     * First entry is the local name, the second one is the translated version.
     * @see http://www.456bereastreet.com/archive/200604/indicating_language_choice_flags_text_both_neither/
     */

    public static function localeNames() {
        static $names;
        if (!$names) {
            $names = [
                'en_CA' => ['English', _('English')],
                'pt_BR' => ['Português', _('Portuguese')],
            ];
        }
        return $names;
    }

    /**
     * Starts up Gettext with all its settings.
     * @see https://lingohub.com/blogs/2013/07/php-internationalization-with-gettext-tutorial/
     */
    public function boot() {
        $codeset = 'UTF-8';
        $domain  = 'main';

        $this->defineLocale($domain);
        putenv('LANG='.LOCALE);
        if (!setlocale(LC_ALL, LOCALE.".$codeset", LOCALE.'.'.strtolower(strtr($codeset, ['-' => ''])))) {
            Log::critical('Locale not available in the system: '.LOCALE.'.'.$codeset);
        }
        bindtextdomain($domain, self::LOCALES_PATH);
        bind_textdomain_codeset($domain, $codeset);
        textdomain($domain);
    }

    protected function defineLocale($domain) {
        if (defined('LOCALE')) {
            return;
        }

        $valid_locale = function ($locale) use ($domain) {
            if (!$locale) {
                return false;
            }
            $locale = strtr($locale, ['-' => '_']); //in case it comes as pt-BR instead of pt_BR

            if ($locale == self::DEFAULT_LOCALE) {
                Log::info('Using default locale: '.self::DEFAULT_LOCALE);
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
//                Log::debug("Locale found: $file_path");
                return true;
            }
        };

        if (isset($_GET['locale']) && $valid_locale($_GET['locale'])) {
            define('LOCALE', $_GET['locale']);
            setcookie('locale', LOCALE, mktime(0,0,0,12,31,date('Y')+3), '/');
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
                define('LOCALE', self::DEFAULT_LOCALE);
            }
        }

        // as we are returning arrays from the lang files, we can use gettext there as well :)
        \App::setLocale('gettext');
    }

    /**
     * @todo cache this!!
     */
    public static function getAvailableLocales() {
        return [self::DEFAULT_LOCALE] + array_diff(scandir(self::LOCALES_PATH), ['.', '..', 'README.md']);
    }

    public function register() {
        //
    }

}
