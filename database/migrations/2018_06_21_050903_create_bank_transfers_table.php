<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ref_num');
            $table->integer('user_id')->unsigned();
            $table->integer('manager_id')->unsigned();
            $table->integer('bank_id')->unsigned();
            $table->string('from_company');
            $table->string('to_company');
            $table->string('from_account');
            $table->string('to_account');
            $table->double('amount')->unsigned();
            $table->string('signatories');
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
        Schema::dropIfExists('bank_transfers');
    }
}
