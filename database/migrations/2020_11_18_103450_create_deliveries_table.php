<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->date('delivery_date');
            $table->string('customer_type');
            $table->string('designation')->nullable();
            $table->text('destination')->nullable();
            $table->string('city')->nullable();
            $table->string('receptionist')->nullable();
            $table->string('waybill_number')->nullable();
            $table->string('reference');

            $table->boolean('approuved')->default(0);
            
            $table->unsignedBigInteger('station_id')->nullable();
            $table->foreign('station_id')->references('id')->on('stations')->onDelete('cascade');
            $table->unsignedBigInteger('petroleum')->nullable();
            $table->foreign('petroleum')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('loading_slip_id')->nullable();
            $table->foreign('loading_slip_id')->references('id')->on('loading_slips')->onDelete('cascade');
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
        Schema::dropIfExists('deliveries');
    }
}
