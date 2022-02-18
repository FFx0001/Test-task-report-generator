<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoldCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sold_cars', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('model',64)->nullable(false);
            $table->string('vin',17)->nullable(false);
            $table->unsignedFloat('engine_capacity')->nullable(false);
            $table->unsignedFloat('engine_power')->nullable(false);
            $table->string('type_of_kpp',8)->nullable(false);
            $table->unsignedInteger('year_of_release')->nullable(false);
            $table->timestamp('date_of_sale')->nullable(false);
            $table->string('dealer',128)->nullable(false);
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
        Schema::dropIfExists('sold_cars');
    }
}
