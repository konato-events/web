<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionTheme extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('session_theme', function (Blueprint $table) {
            $table->integer('session_id');
            $table->integer('theme_id');
            $table->unique(['session_id','theme_id']);
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('theme_id')->references('id')->on('themes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('session_theme');
    }
}
