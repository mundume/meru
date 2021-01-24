<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('role_id')->default('0');
            $table->string('fname');
            $table->string('lname');
            $table->string('mobile');
            $table->string('c_name');
            $table->string('c_mobile')->nullable();            
            $table->string('c_county')->nullable();
            $table->integer('id_no');
            $table->timestamp('suspend')->nullable();
            $table->string('handle');
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
