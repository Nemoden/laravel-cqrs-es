<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class InitEventStore extends Migration
{
    /**
     * @var string
     */
    private $table;

    public function __construct()
    {
        $this->table = Config::get('broadway.event-store.dbal.table', 'event_store');
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');

            $table->string('uuid', 36);
            $table->integer('playhead')->unsigned();
            $table->text('metadata');
            $table->text('payload');
            $table->string('recorded_on', 32);
            $table->text('type');

            $table->unique(['uuid', 'playhead']);
        });
    }

    public function down()
    {
        Schema::drop($this->table);
    }
}