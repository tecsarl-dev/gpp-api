<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadingSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loading_slips', function (Blueprint $table) {
            $table->id();
            $table->date('issue_date');
            $table->string('fiscale_regime');
            $table->string('loading_type');
            $table->string('planned_loading_date');
            $table->string('driver');
            $table->string('code_qr')->nullable();
            $table->unsignedBigInteger('truck_remork_id')->nullable();
            $table->unsignedBigInteger('truck_id')->nullable();
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('cascade');
            $table->unsignedBigInteger('depot_id')->nullable();
            $table->foreign('depot_id')->references('id')->on('depots')->onDelete('cascade');
            $table->unsignedBigInteger('petroleum')->nullable();
            $table->foreign('petroleum')->references('id')->on('companies')->onDelete('cascade');
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
        Schema::dropIfExists('loading_slips');
    }
}
