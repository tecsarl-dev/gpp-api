<?php

namespace App\Gpp\ProductLists;

use App\Gpp\Deliveries\Delivery;
use App\Gpp\LoadingSlips\LoadingSlip;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductList extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "product_id",
        "product",
        "unity",
        "quantity_used",
        "quantity",
        "loading_slip_id",
        "delivery_id",
    ];

    public function loading_slips()
    {
        return $this->belongsTo(LoadingSlip::class);
    }

    public function deliveries()
    {
        return $this->belongsTo(Delivery::class);
    }
}
