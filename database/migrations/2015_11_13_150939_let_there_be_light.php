<?php
use Illuminate\Database\Migrations\Migration;

class LetThereBeLight extends Migration {

    public function up() {
        $sql = file_get_contents(__DIR__.'/../create.sql');
        DB::connection()->getPdo()->exec($sql);
    }

    public function down() {}

}
