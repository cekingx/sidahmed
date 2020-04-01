<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_profiles', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('primary_cost', 8, 2)->unsigned()->default(0.0);
            $table->decimal('secondary_cost', 8, 2)->unsigned()->default(0.0);
            $table->unsignedInteger('transaction_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_profiles');
    }
}
