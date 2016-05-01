<?php

use App\Models\SocialNetwork;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGoogleAccount extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::table('social_networks')->insert([
            [
                'name' => 'Google',
                'url'  => 'https://www.google.com/',
                'icon' => 'fa fa-google'
            ],
            [
                'name' => 'YouTube',
                'url'  => 'https://www.youtube.com/user/',
                'icon' => 'fa fa-youtube-square'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::table('social_networks')->where('name', 'Google')->delete();
        DB::table('social_networks')->where('name', 'YouTube')->delete();
    }
}
