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
            $table->string('code_loading')->unique();
            $table->string('loading_type');
            $table->string('planned_loading_date');
            $table->string('driver');
            $table->string('code_qr')->nullable();
            $table->unsignedBigInteger('transporter')->nullable();
            $table->foreign('transporter')->references('id')->on('companies')->onDelete('set null');
            $table->unsignedBigInteger('truck_remork_id')->nullable();
            $table->unsignedBigInteger('truck_id')->nullable();
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('cascade');
            $table->unsignedBigInteger('depot_id')->nullable();
            $table->foreign('depot_id')->references('id')->on('depots')->onDelete('cascade');
            $table->unsignedBigInteger('petroleum')->nullable();
            $table->foreign('petroleum')->references('id')->on('companies')->onDelete('cascade');
            $table->boolean('approuved')->default(0);
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
        Schema::dropIfExists('loading_slips');
    }
}
