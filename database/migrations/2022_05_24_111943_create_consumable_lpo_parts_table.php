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
        Schema::create('consumable_lpo_parts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lpo_id')->unsigned();
            $table->bigInteger('equipment_id')->unsigned();
            $table->string('part_name');
            $table->string('description');
            $table->integer('quantity');
            $table->float('unit_price', 8,2);
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
        Schema::dropIfExists('consumable_lpo_parts');
    }
};
