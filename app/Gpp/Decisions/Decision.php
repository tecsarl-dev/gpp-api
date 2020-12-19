<?php

namespace App\Gpp\Decisions;

use App\Gpp\Companies\Company;
use App\Gpp\Stations\Station;
use App\Gpp\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Decision extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "decision",
        "motif",
        "company_id",
        "truck_id",
        "station_id",
        "user_id",
    ];
    
    public function companies()
    {
        return $this->belongsTo(Company::class);
    }

    public function stations()
    {
        return $this->belongsTo(Station::class);
    }

    public function trucks()
    {
        return $this->belongsTo(Truck::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
