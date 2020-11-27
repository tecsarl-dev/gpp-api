<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depots', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
            $table->string('code_depot')->unique();
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('capacity');
            $table->string('unity');
            $table->boolean('active')->default(1);
            $table->unsignedBigInteger('gpp')->nullable();
            $table->foreign('gpp')->references('id')->on('companies')->onDelete('cascade'); 
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
        Schema::dropIfExists('depots');
    }
}
