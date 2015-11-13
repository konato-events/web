<?php namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string        username
 * @property SocialNetwork network
 * @property User          user
 * @method BelongsTo network
 * @method BelongsTo user
 */
class SocialLink extends Base {

    public $timestamps = false;

    public static $relationsData = [
        'network' => [self::BELONGS_TO, SocialNetwork::class, 'foreignKey' => 'social_network_id', 'relation' => 'social_networks'],
        'user' => [self::BELONGS_TO, User::class, 'foreignKey' => 'user_id', 'relation' => 'users'],
    ];

    public function getUrlAttribute() {
        return $this->network->url.$this->username;
    }

}
