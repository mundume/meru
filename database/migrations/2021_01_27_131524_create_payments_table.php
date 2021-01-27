<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('ResultCode')->nullable();
            $table->string('ResultDesc')->nullable();
            $table->string('MerchantRequestID')->nullable();
            $table->string('mpesaReceiptNumber')->nullable();
            $table->double('amount');
            $table->string('phoneNumber')->nullable();
            $table->string('ticket_no');
            $table->string('CheckoutRequestID')->nullable();
            $table->string('TransactionDate')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
