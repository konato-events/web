<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserDataInsensitive extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::connection()->getPdo()->exec('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_email_key');
        DB::connection()->getPdo()->exec('DROP INDEX IF EXISTS users_email_key');
        DB::connection()->getPdo()->exec('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_username_key');
        DB::connection()->getPdo()->exec('DROP INDEX IF EXISTS users_username_key');
        DB::connection()->getPdo()->exec('CREATE UNIQUE INDEX users_email_key ON users (lower(email))');
        DB::connection()->getPdo()->exec('CREATE UNIQUE INDEX users_username_key ON users (lower(username))');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::connection()->getPdo()->exec('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_email_key');
        DB::connection()->getPdo()->exec('DROP INDEX IF EXISTS users_email_key');
        DB::connection()->getPdo()->exec('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_username_key');
        DB::connection()->getPdo()->exec('DROP INDEX IF EXISTS users_username_key');
        DB::connection()->getPdo()->exec('CREATE UNIQUE INDEX users_email_key ON users (email)');
        DB::connection()->getPdo()->exec('CREATE UNIQUE INDEX users_username_key ON users (username)');
    }
}
