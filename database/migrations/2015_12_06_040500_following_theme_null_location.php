<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FollowingThemeNullLocation extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('following_theme', function (Blueprint $table) {
            $table->dropPrimary();
            $table->primary(['theme_id', 'user_id']);
        });
        Schema::table('following_theme', function (Blueprint $table) {
            $table->integer('location_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('following_theme', function (Blueprint $table) {
            $table->integer('location_id')->change();
            $table->primary(['theme_id', 'user_id', 'location_id']);
        });
    }
}
