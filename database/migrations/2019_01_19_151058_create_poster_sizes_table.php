<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosterSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poster_sizes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->float('width')->unsigned();
            $table->float('height')->unsigned();
            $table->string('unit', 24)->nullable();
            $table->float('cost')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poster_sizes');
    }
}
