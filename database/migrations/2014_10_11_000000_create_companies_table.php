<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('country')->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('phone_wa')->nullable();
            $table->string('email_company')->nullable();
            $table->string('website')->nullable();
            $table->string('ifu')->nullable();
            $table->string('rccm')->nullable();
            $table->string('social_reason')->nullable();
            $table->string('status')->nullable();
            $table->string('comment')->nullable();
            $table->string('approval_number')->nullable();
            $table->string('approval_file_pdf')->nullable();
            $table->string('bank')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('bank_reference')->nullable();
            $table->string('account_number')->nullable();
            $table->string('counter_code')->nullable();
            $table->string('rib')->nullable();
            $table->string('swift')->nullable();
            $table->string('iban')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('fiscal_regime')->nullable();
            $table->boolean('active')->default(1);
            $table->string('approuved_by')->nullable();
            $table->boolean('approuved')->default(0);
            $table->date('approuved_date')->nullable();
            $table->boolean('contribut_gpp')->default(0);
            $table->date('contribut_gpp_exp')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
