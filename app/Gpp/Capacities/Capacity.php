<?php
namespace App\Gpp\Capacities;

use App\Gpp\Companies\Company;
use App\Gpp\LoadingSlips\LoadingSlip;
use App\Gpp\Stations\Station;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capacity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "gaz",
        "fuel",
        "gpl",
        "station_id",
         
    ];

    public function stations()
    {
        return $this->belongsTo(Station::class);
    }
}
