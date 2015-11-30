<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventMaterialRelation extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('materials', function(Blueprint $t) {
            $t->integer('event_id');
            $t->foreign('event_id')->references('id')->on('events');
        });
        Schema::drop('event_material');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('materials', function(Blueprint $t) {
            $t->dropColumn('event_id');
        });
        Schema::create('event_material', function(Blueprint $t) {
            $t->integer('event_id');
            $t->integer('material_id');
            $t->foreign('event_id')->references('id')->on('events');
            $t->foreign('material_id')->references('id')->on('materials');
        });
    }
}
