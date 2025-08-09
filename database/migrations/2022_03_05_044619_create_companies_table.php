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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 20);
            $table->string('vatin', 255);
            $table->string('address');
            $table->string('phone', 50);
            $table->string('fax', 50);
            $table->string('mobile', 50);
            $table->string('email');
            $table->string('website');
            $table->string('bank');
            $table->string('bank_account_no');
            $table->string('bank_branch');
            $table->string('bank_swift_code');
            $table->string('logo')->nullable();
            $table->string('signature_img');
            $table->string('invoice_bg');
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
        Schema::dropIfExists('companies');
    }
};
