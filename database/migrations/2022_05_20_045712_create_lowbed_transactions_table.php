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
        Schema::create('lowbed_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lowbed_id')->unsigned();
            $table->bigInteger('company_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned();
            $table->string('from_location');
            $table->string('to_location');
            $table->date('date');
            $table->string('description', 500);
            $table->string('status')->default('Pending');
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
        Schema::dropIfExists('lowbed_transactions');
    }
};
