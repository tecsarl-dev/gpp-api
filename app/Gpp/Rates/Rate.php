<?php
namespace App\Gpp\Rates;

use App\Gpp\Companies\Company;
use App\Gpp\Products\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "city_start",
        "city_end",
        "unit_price",
        "unity",
        "active",
        "product_id",
        "gpp"
    ];
    
    public function companies()
    {
        return $this->belongsTo(Company::class,'gpp');
    }

    public function products()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
