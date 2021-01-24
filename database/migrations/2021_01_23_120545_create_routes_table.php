<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('group');
            $table->double('amount');
            $table->string('seaters');
            $table->string('departure');
            $table->string('destination');
            $table->string('depart1')->nullable();
            $table->string('arriv1')->nullable();
            $table->string('depart2')->nullable();
            $table->string('arriv2')->nullable();
            $table->string('depart3')->nullable();
            $table->string('arriv3')->nullable();
            $table->string('depart4')->nullable();
            $table->string('arriv4')->nullable();
            $table->string('mobile')->nullable();
            $table->string('pick_up')->nullable();
            $table->boolean('suspend')->default(false);
            $table->boolean('admin_suspend')->default(true);
            $table->text('location')->nullable();
            $table->string('fleet_unique')->unique();
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
        Schema::dropIfExists('routes');
    }
}
