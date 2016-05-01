<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixLinkedinGoogleUrl extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::table('social_networks')->where('name', 'LinkedIn')->update(['url' => 'https://linkedin.com/in/']);
        DB::table('social_networks')->where('name', 'Google+')->update(['url' => 'https://plus.google.com/u/0/']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::table('social_networks')->where('name', 'LinkedIn')->update(['url' => 'https://*.linkedin.com/in/']);
        DB::table('social_networks')->where('name', 'Google+')->update(['url' => 'https://www.google.com/+']);
    }
}
