<?php
use App\Models\Event;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventAvatar extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('events', function(Blueprint $table) {
            $table->string('avatar')->nullable();
            $table->string('picture')->nullable();
        });
        foreach (Event::all() as $event) {
            $event->avatar  = Event::generateGravatar($event->title, 128);
            $event->picture = Event::generateGravatar($event->title, 512);
            $event->save();
        }
        Schema::table('events', function(Blueprint $table) {
            $table->string('avatar')->nullable(false)->change();
            $table->string('picture')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('events', function(Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('picture');
        });
    }
}
