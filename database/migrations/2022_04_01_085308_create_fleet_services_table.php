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
        Schema::create('fleet_services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('equipment_id')->unsigned();
            $table->string('services');
            $table->bigInteger('meter_reading');
            $table->bigInteger('next_service_meter_reading');
            $table->string('meter_reading_unit');
            $table->string('description')->nullable();
            $table->date('date')->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('fleet_services');
    }
};
