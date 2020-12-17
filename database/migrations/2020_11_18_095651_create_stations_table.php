<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->string('designation')->nullable();
            $table->string('country');
            $table->string('city');
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('code_station')->unique();
            // $table->unsignedBigInteger('capacity_id')->nullable();
            // $table->foreign('capacity_id')->references('id')->on('capacities')->onDelete('cascade');
            // $table->unsignedBigInteger('responsible_id')->nullable();
            // $table->foreign('responsible_id')->references('id')->on('responsibles')->onDelete('cascade');
            $table->string('authorization_file');
            $table->unsignedBigInteger('petroleum')->nullable();
            $table->foreign('petroleum')->references('id')->on('companies')->onDelete('cascade');
            $table->boolean('approuved')->default(0);
            $table->boolean('is_submit')->default(0);
            $table->string('approuved_by')->nullable();
            $table->date('approuved_date')->nullable();
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
        Schema::dropIfExists('stations');
    }
}
