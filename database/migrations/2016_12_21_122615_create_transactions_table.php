<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing transactions
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unique_id', 36)->unique();

            $table->bigInteger('order_id')->unsigned();
            $table->string('gateway', 64);
            $table->string('transaction_id', 64);
            $table->string('detail', 1024)->nullable();
            $table->string('token')->nullable();
            $table->timestamps();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->index(['order_id']);
            $table->index(['gateway', 'transaction_id']);
            $table->index(['order_id', 'token']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transactions');
    }
}
