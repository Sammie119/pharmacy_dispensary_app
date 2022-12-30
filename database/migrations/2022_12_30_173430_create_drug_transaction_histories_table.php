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
        Schema::create('drug_transaction_histories', function (Blueprint $table) {
            $table->id();
            $table->string('drug_name');
            $table->integer('quantity');
            $table->decimal('price', 8,2);
            $table->bigInteger('reciept_no');
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
        Schema::dropIfExists('drug_transaction_histories');
    }
};
