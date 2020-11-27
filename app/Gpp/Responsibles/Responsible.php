<?php
namespace App\Gpp\Responsibles;

use App\Gpp\Stations\Station;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsible extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "tel",
        "email",
        "indicatif",
        "active",
        "station_id",
    ];

    public function stations()
    {
        return $this->belongsTo(Station::class);
    }
}
