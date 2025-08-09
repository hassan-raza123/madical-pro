<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('quotation_id')->unsigned()->nullable();
            $table->string('payment_method')->nullable();
            $table->date('from_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('to_date')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->default('Active');
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
        Schema::dropIfExists('rent_transactions');
    }
};
