<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMicrosoftAccount extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::table('social_networks')->insert([
            'name' => 'Live',
            'url'  => 'https://profile.live.com/', //TODO: this comes from the API at "link" field. it might change
            'icon' => 'fa fa-windows'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::table('social_networks')->where('name', 'Live')->delete();
    }
}
