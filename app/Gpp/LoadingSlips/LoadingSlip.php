<?php
namespace App\Gpp\LoadingSlips;

use App\Gpp\Capacities\Capacity;
use App\Gpp\Capacities\Truck;
use App\Gpp\Companies\Company;
use App\Gpp\Deliveries\Delivery;
use App\Gpp\Depots\Depot;
use App\Gpp\ProductLists\ProductList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoadingSlip extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "issue_date",
        "code_loading",
        "fiscale_regime",
        "loading_type",
        "planned_loading_date",
        "driver",
        "code_qr",
        "truck_id",
        "truck_remork_id",
        "depot_id",
        "petroleum",
        "transporter",
        'approuved',
    ];

    public function companies()
    {
        return $this->belongsTo(Company::class, 'petroleum');
    }

    public function trucks()
    {
        return $this->belongsTo(Truck::class);
    }

    public function depots()
    {
        return $this->belongsTo(Depot::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function product_lists()
    {
        return $this->hasMany(ProductList::class);
    }

}