<?php
namespace App\Gpp\Products;

use App\Gpp\Companies\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "code_product",
        "active",
        "spefication",
        "unity",
        "gpp"
    ];

    public function companies()
    {
        return $this->belongsTo(Company::class);
    }

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }
}
