<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ThemeUniqueInsensitive extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::connection()->getPdo()->exec('DROP INDEX themes_name_key;');
        DB::connection()->getPdo()->exec('CREATE UNIQUE INDEX themes_name_key ON themes (lower(name))');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::connection()->getPdo()->exec('DROP INDEX themes_name_key;');
        DB::connection()->getPdo()->exec('CREATE UNIQUE INDEX themes_name_key ON themes (name)');
    }
}
