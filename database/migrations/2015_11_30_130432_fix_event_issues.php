<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixEventIssues extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('issues', function($t) {
            $t->dropColumn('begin');
            $t->dropColumn('end');
            $t->dropColumn('suffix');
            $t->dropColumn('event_id');
        });
        Schema::rename('issues', 'event_issues');
        Schema::table('events', function($t) {
            $t->timestamptz('begin')->default('NOW()');
            $t->timestamptz('end')->nullable();
            $t->integer('event_issue_id')->nullable();
            $t->foreign('event_issue_id')->references('id')->on('event_issues');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::rename('event_issues', 'issues');
        Schema::table('issues', function($t) {
            $t->timestamptz('begin');
            $t->timestamptz('end');
            $t->boolean('suffix')->default(false);
            $t->integer('event_id');
            $t->foreign('event_id')->references('id')->on('event');
        });
        Schema::table('events', function($t) {
            $t->dropColumn('begin');
            $t->dropColumn('end');
            $t->dropColumn('event_issue_id');
        });
    }
}
