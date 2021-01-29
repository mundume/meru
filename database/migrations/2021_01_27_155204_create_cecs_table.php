<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cecs', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('fleet_id');
            $table->string('readable_fleet_id')->nullable();
            $table->integer('no_of_commuters')->nullable();
            $table->double('cash')->nullable();
            $table->double('mpesa')->nullable();
            $table->double('total_amount')->nullable();
            $table->boolean('is_receipt')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cecs');
    }
}
