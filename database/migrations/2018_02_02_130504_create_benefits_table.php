<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBenefitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benefits', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('description')->nullable();
            $table->text('begindate')->nullable();
            $table->text('enddate')->nullable();
            $table->text('regulation')->nullable();
            $table->string('likescount')->nullable();
            $table->text('purchaseurl')->nullable();
            $table->text('publicdescription')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('benefits');
    }
}
