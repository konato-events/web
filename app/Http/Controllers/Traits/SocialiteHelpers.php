<?php namespace App\Http\Controllers\Traits;
use App\Models\User;
use GuzzleHttp\Client as Http;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Contracts\User as UserContract;

trait SocialiteHelpers {

    protected function driver(string $provider, bool $popup = false):Provider {
        $driver = \Socialite::driver($provider);

        switch ($provider) {
            case 'facebook': /** @var \Laravel\Socialite\Two\FacebookProvider $driver */
                $driver
                    ->scopes([
                        'public_profile',
                        'email',
                        'user_about_me',
                        'user_birthday',
//                        'user_events',
                        'user_website',
                        'user_work_history',
//                        'rsvp_event',
//                        'user_location',
//                        'user_education_history'
                    ])->fields([
                        'first_name',
                        'last_name',
                        'gender',
                        'email',
                        'birthday',
                        'website',
//                        'location',
//                        'locale',
//                        'timezone',
                        'bio',
//                        'education',
                        'work'
                    ]);
                if ($popup) {
                    $driver->asPopup();
                }
            break;

            case 'github':  /** @var \Laravel\Socialite\Two\GithubProvider $driver */
                $driver->scopes(['user','user:email']);
            break;

            case 'twitter': /** @var \Laravel\Socialite\One\TwitterProvider $driver */
            case 'bitbucket': /** @var \Laravel\Socialite\One\BitbucketProvider $driver */
                // there's nothing to be done with OAuth 1.0 clients
            break;
        }

        return $driver;
    }

    //TODO: add a user notification explaining their Bitbucket avatar might be too small to be useable, directing them to update their picture
    protected function fillUser(User $user, array $user_data, UserContract $data, string $provider) {
        $mappings = [
            'name'          => 'name',
            'email'         => 'email',
            'avatar'        => 'avatar',
            'picture'       => 'avatar_original',
            'bio'           => ['bio', 'description'], //Github's bio apparently is a null, non-editable field
            'birthday'      => 'birthday',
            'gender'        => 'gender',
            'rel:location'  => 'location.name',
            'rel:timezone'  => 'timezone',
            'rel:locale'    => 'locale',
            'rel:website'   => 'website',
            "rel:$provider" => 'link',
            'tagline'       => ['work','company'],
        ];
        $relations_data = ['links' => []];

        $getValue = function($key) use ($user_data, $data) {
            if (strpos($key, '.') === false) {
                return $user_data[$key]?? $data->$key?? null;
            } else {
                $value   = $user_data;
                $sub_key = strtok($key, '.');
                do {
                    $value = $value[$sub_key];
                } while ($sub_key = strtok('.'));
                return $value;
            }
        };
        foreach ($mappings as $field => $key) {
            if (strpos($field, 'rel:') === false && !$user->$field) { //not a relation and is still unset
                if (is_array($key)) {
                    foreach($key as $key_option) {
                        if ($value = $getValue($key_option)) {
                            break;
                        }
                    }
                } else {
                    $value = $getValue($key);
                }

                if (!isset($value)) {
                    continue; //no data, so we can skip this field
                }

                switch ($field) {
                    case 'birthday':
                        $value = \DateTime::createFromFormat('m/d/Y', $value)->format('Y-m-d');
                    break;

                    case 'tagline':
                        switch ($provider) {
                            case 'github':
                                $value = 'Developer'.($value? ' @ '.$value : '');
                            break;

                            case 'facebook':
                                $last_job = current($value);
                                $value    = $last_job['position']['name'].' @ '.$last_job['employer']['name'];
                            break;
                        }
                    break;

                    case 'gender':  $value = strtoupper($value[0]); break;
                }
                $user->$field = $value;
            } else {
                $relation = substr($field, 4);

                switch ($relation) {
                    case 'website':
                        switch ($provider) {
                            case 'twitter': $url = static::unshortenUrl($user_data['url']); break;
                            case 'github':  $url = $user_data['blog'];         break; //seriously github? blog? hahah
                            default:        $url = $user_data['website']?? ''; break;
                        }
                        if ($url) {
                            if (!preg_match('|^https?://|', $url)) {
                                $url = 'http://'.$url;
                            }
                            $url = substr($url, 4); //personal website prefix length
                            $relations_data['links']['personal website'] = $url;
                        }
                    break;

                    case $provider: //provider's profile
                        switch ($provider) {
                            case 'twitter':
                            case 'github':
                            case 'bitbucket': $username = $data->getNickname(); break;
                            default:          $username = $data->getId();
                        }
                        session()->set('signup.main_provider_link', compact('provider', 'username'));
                    break;

                    case 'location':
                        //facebook: location.name
                        //twitter, github, bitbucket (empty?): location
                        //TODO: add a location relationship here; don't forget to test with a testuser with no location!
                    break;

                    case 'locale':
                        //facebook: locale
                        //twitter: lang (en)
                        //github, bitbucket: none?
                        //TODO: add a language relationship here; don't forget to test with a testuser with no locale!
                    break;

                    case 'timezone':
                        //facebook: timezone //TODO DAFUK timezone comes as -2 USELESS HALP
                        //twitter: utc_offset (-10800) / timezone (Brasilia)
                        //github, bitbucket: none?
                        //TODO: add a timezone relationship here; don't forget to test with a testuser with no timezone!
                    break;
                }
            }
        }

//        !ddd($user->getAttributes(), $data, $relations_data);
        session()->set('signup.relations', $relations_data);
    }

    /**
     * Captures relationship data saved in session (from {@link fillUser}) and stores in the database.
     * @param User $user
     * @param bool $main_link If it should save the main link or the other relations.
     *                        This separation is useful to improve transaction integrity.
     */
    protected function saveLinks(User $user, bool $main_link = false) {
        if ($main_link) {
            $link = session('signup.main_provider_link');
            $user->addLink($link['username'], $link['provider']);
        } else {
            foreach (session('signup.relations') as $relation => $data) {
                switch ($relation) {
                    case 'links': array_walk($data, [$user, 'addLink']); break;
                    default: \Log::emergency("Not yet implemented Sign Up relation called $relation: ".printr($data));
                }
            }
        }
    }

    /**
     * Follows redirects until the next URL ($last = false) or the last one ($last = true) and returns it.
     * @see http://docs.guzzlephp.org/en/latest/request-options.html#allow-redirects
     * @param string $url
     * @param bool   $last
     * @return string
     */
    protected static function unshortenUrl(string $url, bool $last = false) {
        $redir = (new Http())->head($url, ['allow_redirects' => ['track_redirects' => true]]);
        if ($redir->hasHeader('x-guzzle-redirect-history')) {
            $catch = $last? 'last' : 'current';
            return $catch($redir->getHeader('x-guzzle-redirect-history'));
        }
        return $url;
    }
}
