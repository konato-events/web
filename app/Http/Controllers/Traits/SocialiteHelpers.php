<?php namespace App\Http\Controllers\Traits;
use App\Models\User;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Contracts\User as UserContract;

trait SocialiteHelpers {

	protected function driver(string $provider, bool $popup = false):Provider {
		$driver = \Socialite::driver($provider);

		switch ($provider) {
			case 'facebook':
				/** @var \Laravel\Socialite\Two\FacebookProvider $driver */
				$driver
					->scopes(['public_profile', 'email', 'user_about_me', 'user_birthday', 'user_events', 'user_website', 'user_work_history', 'rsvp_event', 'user_location', 'user_education_history'])
					->fields(['first_name', 'last_name', 'gender', 'email', 'birthday', 'link', 'website', 'location', 'locale', 'timezone', 'bio', 'education', 'work']);
				break;
		}

		return $driver;
	}

	protected function fillUser(User $user, array $user_data, UserContract $data, string $provider) {
		$relations = [
			'birthday'         => 'birthday',
			'gender'           => 'gender',
			'rel:location'     => 'location.name',
			'rel:timezone'     => 'timezone',
			'rel:locale'       => 'locale',
			'rel:social_links' => 'website',
			"rel:$provider" => 'link',
			'tagline'          => 'work',
			'avatar'           => '',
			'picture'          => '',
		];

		foreach ($relations as $field => $key) {
			if (strpos($field, 'rel:') === false) {
				if ($key) {
					if (strpos($key, '.') === false) {
						$value = $user_data[$key];
					} else {
						$value   = $user_data;
						$sub_key = strtok($key, '.');
						do {
							$value = $value[$sub_key];
						} while ($sub_key = strtok('.'));
					}
				} else {
					$value = null;
				}

				switch ($field) {
					case 'birthday':
						$value = \DateTime::createFromFormat('m/d/Y', $value)->format('Y-m-d');
						break;

					case 'tagline':
						$last_job = current($value);
						$value    = "{$last_job['position']['name']} @ {$last_job['employer']['name']}";
						break;

					case 'gender':  $value = strtoupper($value[0]); break;

					case 'avatar':  $value = $data->getAvatar(); break;

					case 'picture': $value = $data->avatar_original; break;
				}
				$user->$field = $value;
			} else {
				$relation = substr($field, 4);
				//TODO: implement relationships here
				switch ($relation) {
					case 'social_links':
						//TODO: add a "social network" link here as "website"
						break;

					case $provider: //Facebook's profile
						//TODO: add a "social network" link here as $provider
						break;

					case 'location': //Facebook's profile
						//TODO: add a location relationship here
						break;

					case 'locale': //Facebook's profile
						//TODO: add a language relationship here
						break;

					case 'timezone': //Facebook's profile
						//TODO DAFUK timezone comes as -2 USELESS HALP
						//TODO: add a timezone relationship here
						break;
				}
			}
		}
	}
}