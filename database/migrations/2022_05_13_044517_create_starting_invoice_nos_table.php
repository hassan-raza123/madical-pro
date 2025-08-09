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
        Schema::create('starting_invoice_nos', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('invoice_no');
            $table->integer('quot_no');
            $table->integer('lpo_no');
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
        Schema::dropIfExists('starting_invoice_nos');
    }
};
