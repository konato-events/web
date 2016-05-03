<?php namespace App\Http\Controllers\Traits;
use App\Models\User;
use GuzzleHttp\Client as Http;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Contracts\User as UserContract;

/**
 * This trait adds some useful methods to parse data coming from Socialite.
 *
 * How-to - Add a new API
 * 1. get ID/Key and Secret for their services (Google it?)
 * 2. add them to .env and .env.example, as SERVICEXX_ID and SERVICEXX_SECRET
 * 3. add them to Heroku by using `heroku config:add SERVICEXX_ID=xxx SERVICEXX_SECRET=xxx`
 * 4. add that service to the providers array on config/services.php
 * 5. configure any additional scope/arguments by adding a new case to {@link driver()}
 * 6. add the provider link somewhere in the app (probably /auth/provider/SERVICE, in views.auth._providers_list)
 * 7. uncomment the debug by the end of {@link fillUser()} and play around with the results and code until you see fit
 *
 * @package App\Http\Controllers\Traits
 */
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

            case 'github': /** @var \Laravel\Socialite\Two\GithubProvider $driver */
                $driver->scopes(['user','user:email']);
            break;

            case 'linkedin': /** @var \Laravel\Socialite\Two\LinkedInProvider $driver */
                $driver->scopes(['r_basicprofile','r_emailaddress']); //those are actually consumer's hard settings
            break;

            case 'google': /** @var \Laravel\Socialite\Two\GoogleProvider $driver */
                // nothing to do here
            break;

            case 'live': /** @var \SocialiteProviders\Live\Provider $driver */
                $driver->scopes([
                    'wl.basic',
                    'wl.emails',
                    'wl.birthday',
                    'wl.calendars_update',
                    'wl.events_create',
                    'wl.work_profile'
                ]);
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
            'avatar'        => ['avatar', 'id'], //Microsoft avatar depends on the ID only
            'picture'       => 'avatar_original',
            'bio'           => ['bio', 'description'], //Github's bio apparently is a null, non-editable field
            'birthday'      => ['birthday', 'birth_year'], //Microsoft birthday depends on the year field
            'gender'        => 'gender',
            'rel:location'  => 'location.name',
            'rel:timezone'  => 'timezone',
            'rel:locale'    => 'locale',
            'rel:website'   => 'website',
            "rel:$provider" => 'link',
            'tagline'       => ['work','company','headline','occupation'],
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
                    case 'name':
                        if ($provider == 'google') {
                            $value = trim($value['givenName'].' '.$value['familyName']);
                            if (!$value) { //yeah, hosted accounts may not even have a NAME (!!!)
                                $email = $data->getEmail();
                                $value = substr($email, 0, strpos($email, '@'));      //takes the email username...
                                $value = strtr($value, ['.'=>' ','_'=>' ','-'=>' ']); //..replaces common placeholders..
                                $value = ucwords($value);                             //...and call it a "name"
                            }
                        }
                    break;

                    case 'birthday':
                        switch ($provider) {
                            case 'live':
                                //TODO: user might have month + day without year. We should split the birthday field to accomodate this
                                if ($user_data['birth_month'] && $user_data['birth_day'] && $user_data['birth_year']) {
                                    $value = date('Y-m-d', mktime(0,0,0,$user_data['birth_month'], $user_data['birth_day'], $user_data['birth_year']));
                                }
                            break;

                            default:
                                $value = \DateTime::createFromFormat('m/d/Y', $value)->format('Y-m-d');
                        }
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

                            case 'live':
                                $value = isset($value[0]['employer']['name'])? ($value[0]['position']['name'] ?? 'works').' @ '.$value[0]['employer']['name'] : '';
                            break;
                        }
                    break;

                    case 'avatar':
                        switch ($provider) {
                            case 'live':
                                $value = "https://apis.live.net/v5.0/{$data->getId()}/picture";
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
                            case 'bitbucket':
                                $username = $data->getNickname();
                            break;

                            case 'linkedin':
                                $profile  = $user_data['publicProfileUrl'];
                                $username = substr($profile, strpos($profile, '/in/')+4);
                            break;

                            case 'google':
                                $username = $data->getId();

                                if ($user_data['isPlusUser']) {
                                    $relations_data['links']['google+'] = $data->getId();
                                }

                                if (isset($user_data['urls']) && is_array($user_data['urls'])) {
                                    //TODO: should we use our entries from SocialNetwork instead? how? maybe spliting the URL field into verification_url (regex) and profile_url?
                                    $valid_networks = ['facebook', 'linkedin', 'twitter', 'youtube'];

                                    foreach ($user_data['urls'] as $entry) {
                                        $label  = strtolower($entry['label']);
                                        $handle = substr($entry['value'], (strrpos($entry['value'], '/')?: -1) + 1);
                                        if (in_array($label, $valid_networks)) {
                                            $relations_data['links'][$label] = $handle;
                                        } else {
                                            foreach ($valid_networks as $network)
                                            if (strpos($entry['value'], $network.'.com')) {
                                                $relations_data['links'][$network] = $handle;
                                            }
                                        }
                                    }
                                }
                            break;

                            default: $username = $data->getId();
                        }
                        session()->set('signup.main_provider_link', compact('provider', 'username'));
                    break;

                    case 'location':
                        //facebook: location.name
                        //twitter, github, bitbucket (empty?): location
                        //linkedin: location.name (Rio de Janeiro Area, Brazil) + location.country.code (br)
                        //google: placesLived[].primary=true ~ value
                        //live: requires complete address permission :/
                        //TODO: add a location relationship here; don't forget to test with a testuser with no location!
                    break;

                    case 'locale':
                        //facebook, live: locale
                        //twitter: lang (en)
                        //google: language
                        //github, bitbucket: none?
                        //TODO: add a language relationship here; don't forget to test with a testuser with no locale!
                    break;

                    case 'timezone':
                        //facebook: timezone //TODO DAFUK timezone comes as -2 USELESS HALP
                        //twitter: utc_offset (-10800) / timezone (Brasilia)
                        //github, bitbucket, google, live: none?
                        //TODO: add a timezone relationship here; don't forget to test with a testuser with no timezone!
                    break;
                }
            }
        }

//        !ddd($user->getAttributes(), $username, $data, $relations_data);
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
