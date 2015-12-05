<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImproveEventRelations extends Migration {

    protected $timestampedTables = [
        'event_speaker',
        'event_theme',
        'event_staff',
        'event_wifis',
        'event_issues',
        'event_language',
        'following_event',
        'following_theme',
        'following_user',
        'claim_requests',
        'sessions',
        'speaker_session',
        'materials',
        'themes'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        foreach($this->timestampedTables as $name) {
            try {
                Schema::table($name, function (Blueprint $table) { $table->timestamps(); });
            }
            catch (\Illuminate\Database\QueryException $e) {
                Schema::table($name, function (Blueprint $table) { $table->nullableTimestamps(); });
            }
        }

        Schema::table('event_staff', function(Blueprint $t) { $t->unique(['event_id', 'user_id']); });
        Schema::table('event_theme', function(Blueprint $t) { $t->unique(['event_id', 'theme_id']); });
        Schema::table('event_speaker', function(Blueprint $t) { $t->unique(['event_id', 'user_id']); });
        Schema::table('event_language', function(Blueprint $t) { $t->unique(['event_id', 'language_id']); });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        foreach($this->timestampedTables as $name) {
            Schema::table($name, function (Blueprint $table) { $table->dropTimestamps(); });
        }

        Schema::table('event_staff', function(Blueprint $t) { $t->dropUnique(['event_id', 'user_id']); });
        Schema::table('event_theme', function(Blueprint $t) { $t->dropUnique(['event_id', 'theme_id']); });
        Schema::table('event_speaker', function(Blueprint $t) { $t->dropUnique(['event_id', 'user_id']); });
        Schema::table('event_language', function(Blueprint $t) { $t->dropUnique(['event_id', 'language_id']); });
    }
}
