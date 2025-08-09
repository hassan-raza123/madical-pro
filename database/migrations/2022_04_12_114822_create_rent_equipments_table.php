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
        Schema::create('rent_equipments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rent_transaction_id')->unsigned();
            $table->bigInteger('equipment_id')->unsigned();
            $table->string('description')->nullable();
            $table->float('hourly_rent', 8, 2)->nullable();
            $table->float('daily_rent', 8, 2)->nullable();
            $table->float('weekly_rent', 8, 2)->nullable();
            $table->float('monthly_rent', 8, 2)->nullable();
            $table->float('mobilization', 8, 2)->nullable();
            $table->float('demobilization', 8, 2)->nullable();
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
        Schema::dropIfExists('rent_equipments');
    }
};
