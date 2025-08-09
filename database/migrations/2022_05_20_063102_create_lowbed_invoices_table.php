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
        Schema::create('lowbed_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->bigInteger('lowbed_transaction_id')->unsigned();
            $table->string('description');
            $table->float('amount', 8, 2);
            $table->date('date');
            $table->string('vat');
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
        Schema::dropIfExists('lowbed_invoices');
    }
};
