<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropThemeSlug extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->integer('parent_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('themes', function (Blueprint $table) {
            $table->text('slug')->nullable();
            $table->integer('parent_id')->change();
        });
    }
}
