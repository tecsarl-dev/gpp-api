<?php
namespace App\Gpp\Trucks;

use App\Gpp\LoadingSlips\LoadingSlip;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "property",
        "truck_number",
        "type",
        "car_registration",
        "capacity",
        "unity",
        "gauging_certificate_number",
        "gauging_certificate_file",
        "assurance_file",
        "assurance_validity",
        "taxation",
        "taxation_date_validity",
        "active",
        "transporter",
        "approuved",
        "approuved_by",
        "approuved_date"
    ];

    public function loading_slips()
    {
        return $this->hasMany(LoadingSlip::class);
    }

    public function companies()
    {
        return $this->belongsTo(Company::class,'transporter');
    }
}
