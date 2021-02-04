<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('sender_name');
            $table->string('sender_mobile');
            $table->text('parcel_description');
            $table->string('receiver_name');
            $table->string('receiver_mobile');
            $table->string('id_no');
            $table->string('provider');
            $table->integer('destination');
            $table->integer('destination_office');
            $table->string('size');
            $table->double('service_provider_amount');
            $table->string('parcel_no');
            $table->string('url');
            $table->string('payment_method')->default('cash');
            $table->boolean('is_paid')->default(false);
            $table->boolean('progress')->default(false);
            $table->boolean('picked')->default(false);
            $table->integer('fleet_id')->nullable();
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
        Schema::dropIfExists('parcels');
    }
}
