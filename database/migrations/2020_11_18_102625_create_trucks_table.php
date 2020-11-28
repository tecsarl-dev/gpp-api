<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrucksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->string('property');
            $table->string('truck_number');
            $table->string('type');
            $table->string('car_registration');
            $table->string('capacity')->nullable();
            $table->string('unity')->nullable();
            $table->string('gauging_certificate_number');
            $table->string('gauging_certificate_file');
            $table->string('assurance_file');
            $table->string('assurance_validity');
            $table->string('taxation')->nullable();
            $table->string('taxation_date_validity');
            $table->boolean('active')->default(1);
            $table->unsignedBigInteger('transporter')->nullable();
            $table->foreign('transporter')->references('id')->on('companies')->onDelete('cascade');
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
        Schema::dropIfExists('trucks');
    }
}
