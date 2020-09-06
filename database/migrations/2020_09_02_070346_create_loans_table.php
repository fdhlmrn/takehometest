<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('status_id')->default('1');
            $table->unsignedBigInteger('frequency_id');
            $table->string('loan_name');
            $table->integer('loan_term');
            $table->decimal('loan_amount', 9,2);
            $table->decimal('loan_balance', 9,2);
            $table->string('loan_currency');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('loan_status');
            $table->foreign('frequency_id')->references('id')->on('payment_frequency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
