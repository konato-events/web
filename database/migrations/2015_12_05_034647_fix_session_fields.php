<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixSessionFields extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('sessions', function (Blueprint $table) {
            $table->renameColumn('time','begin');
            $table->timestampTz('end');
        });
        Schema::rename('speaker_session', 'session_speaker');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('sessions', function (Blueprint $table) {
            $table->renameColumn('begin','time');
            $table->dropColumn('end');
        });
        Schema::rename('session_speaker', 'speaker_session');
    }
}
