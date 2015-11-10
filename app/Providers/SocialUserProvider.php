<?php
namespace App\Providers;
use App\Models\SocialLink;
use App\Models\SocialNetwork;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class SocialUserProvider extends EloquentUserProvider {

    /**
     * Replicates the original method behaviour, but also adds the ability to find a user by its Social Network Link.
     * @param array $credentials
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function retrieveByCredentials(array $credentials) {
        if (isset($credentials['provider'])) {
            $network = SocialNetwork::find($credentials['provider']);
            if ($network) {
                /** @var SocialLink $profile */
                $profile = $network->links()->where('username', $credentials['username'])->get();
                if ($profile) {
                    return $profile->user;
                }
            }
            return null;
        } else {
            return parent::retrieveByCredentials($credentials);
        }
    }
}
