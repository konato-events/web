<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventExtraFields extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('events', function(Blueprint $t) {
            $t->text('description')->after('title')->nullable();
            $t->text('tickets_url')->after('website')->nullable();
            $t->text('facebook')->after('tickets_url')->nullable();
            $t->text('facebook_event')->after('facebook')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('events', function(Blueprint $t) {
            $t->dropColumn('description');
            $t->dropColumn('tickets_url');
            $t->dropColumn('facebook');
            $t->dropColumn('facebook_event');
        });
    }
}
