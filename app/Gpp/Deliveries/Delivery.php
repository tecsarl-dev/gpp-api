<?php
namespace App\Gpp\Deliveries;

use App\Gpp\LoadingSlips\LoadingSlip;
use App\Gpp\ProductLists\ProductList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Delivery extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "delivery_date",
        "customer_type",
        "destination",
        "city",
        "receptionist",
        "waybill_number",
        "reference",
        "approuved",
        "petroleum",
        "station_id",
        "loading_slip_id",
    ];

    public function companies()
    {
        return $this->belongsTo(Company::class);
    }

    public function load_slips()
    {
        return $this->belongsTo(LoadingSlip::class);
    }

    public function product_lists()
    {
        return $this->hasMany(ProductList::class);
    }
}
