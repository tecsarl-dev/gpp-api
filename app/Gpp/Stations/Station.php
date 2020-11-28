<?php
namespace App\Gpp\Stations;

use App\Gpp\Capacities\Capacity;
use App\Gpp\Responsibles\Responsible;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country', 
        'city',
        'longitude',
        'latitude',
        'code_station',
        'designation',
        
        'authorization_file',
        'petroleum',
        'approuved',
        'approuved_by',
        'approuved_date',
    ];

    public function capacities()
    {
        return $this->hasOne(Capacity::class);
    }

    public function responsibles()
    {
        return $this->hasOne(Responsible::class);
    }

    public function companies()
    {
        return $this->belongsTo(Company::class);
    }
}