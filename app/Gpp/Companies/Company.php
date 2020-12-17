<?php

namespace App\Gpp\Companies;

use App\Gpp\Capacities\Depot;
use App\Gpp\Decisions\Decision;
use App\Gpp\LoadingSlips\LoadingSlip;
use App\Gpp\Products\Product;
use App\Gpp\Rates\Rate;
use App\Gpp\Stations\Station;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'country',
        'address',
        'zip_code',
        'phone1',
        'phone2',
        'phone_wa',
        'email_company',
        'website',
        'ifu',
        'rccm',
        'social_reason',
        'social_capital',
        'status',
        'comment',
        'approval_number',
        'approval_file_pdf',
        'bank',
        'bank_code',
        'bank_reference',
        'account_number',
        'counter_code',
        'rib',
        'swift',
        'iban',
        'bank_address',
        'fiscal_regime',
        'active',
        'approuved',
        'approuved_by',
        'approuved_date',
        'contribut_gpp',
        'contribut_gpp_exp',
        'is_submit',
    ];


    public function depots()
    {
        return $this->hasMany(Depot::class);
    }
    
    public function decisions()
    {
        return $this->hasMany(Decision::class);
    }

    public function stations()
    {
        return $this->hasMany(Station::class, "petroleum");
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function load_slips()
    {
        return $this->hasMany(LoadingSlip::class);
    }

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }


    
}