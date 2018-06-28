<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagerChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manager_checks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ref_num');
            $table->integer('user_id')->unsigned();
            $table->integer('manager_id')->unsigned();
            $table->double('mc_cost')->unsigned();
            $table->double('grand_total')->unsigned();
            $table->string('account_number');
            $table->string('company');
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
        Schema::dropIfExists('manager_checks');
    }
}
