<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('system_name',64)->nullable(false);
            $table->string('extension',6)->nullable(false);
            $table->string('display_name')->nullable(false);
            $table->string('sub_folder',16)->nullable(false);
           // $table->string('password_hash_sha512b'); //?  to protect files from unauthorized access (not implemented)
           //  $table->string('hmac'); //? to protect files from spoofing (not implemented)
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
        Schema::dropIfExists('files');
    }
}
