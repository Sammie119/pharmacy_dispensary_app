<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigInteger('drug_trans_id');
            $table->string('drug_name');
            $table->integer('quantity');
            $table->decimal('unit_price', 8,2);
            $table->integer('receipt_no');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE drug_transaction_histories
            CHANGE receipt_no receipt_no INT(10) UNSIGNED ZEROFILL NOT NULL
        ');
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
