<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreEventFields extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('events', function (Blueprint $table) {
            $table->text('tagline')->after('title')->nullable();
            $table->text('address')->after('location')->nullable();
            $table->text('postal_code')->after('address')->nullable();
        });

        Schema::drop('event_addresses');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('tagline');
            $table->dropColumn('address');
            $table->dropColumn('postal_code');
        });

        Schema::create('event_addresses', function(Blueprint $table) {
            $table->increments('event_id');
            $table->text('line1');
            $table->text('line2')->nullable();
            $table->text('postal_code')->nullable();
            $table->primary('event_id');
        });
    }
}
