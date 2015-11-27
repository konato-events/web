<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventTableImprovements extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('events', function($t) {
            $t->dropColumn('slug');
            $t->renameColumn('published', 'hidden');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('events', function($t) {
            $t->text('slug')->after('title');
            $t->unique('slug');
            $t->renameColumn('hidden', 'published');
        });
    }
}
