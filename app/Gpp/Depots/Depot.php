<?php
namespace App\Gpp\Depots;

use App\Gpp\Companies\Company;
use App\Gpp\LoadingSlips\LoadingSlip;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "designation",
        "code_depot",
        "country",
        "city",
        "address",
        "unity",
        "phone",
        "email",
        "capacity",
        "active",
        "gpp"
    ];

    public function companies()
    {
        return $this->belongsTo(Company::class,'gpp');
    }

    public function loadingSlips()
    {
        return $this->hasMany(LoadingSlip::class);
    }
}
