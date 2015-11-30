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
            $t->text('location');
            $t->integer('location_id')->nullable()->change();
            $t->timestamps();
            $t->renameColumn('published', 'hidden');
        });

        $talk = \App\Models\EventType::where('name', 'talk')->first();
        $talk->name = 'single talk';
        $talk->save();
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
            $t->dropColumn('location');
            $t->integer('location_id')->change();
            $t->dropTimestamps();
            $t->renameColumn('hidden', 'published');
        });

        $talk = \App\Models\EventType::where('name', 'single talk')->first();
        $talk->name = 'talk';
        $talk->save();
    }
}
