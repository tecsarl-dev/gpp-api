<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('type');  // petroleum, carrier, admin, super-admin
            $table->string('role')->default('admin');  // petroleum, carrier, admin, super-admin
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birthday')->nullable();
            $table->string('part_number')->nullable();
            $table->date('part_exp')->nullable();
            $table->string('id_photo')->nullable();
            
            $table->string('digit_code')->unique()->nullable();
            $table->timestamp('digit_code_expired_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
