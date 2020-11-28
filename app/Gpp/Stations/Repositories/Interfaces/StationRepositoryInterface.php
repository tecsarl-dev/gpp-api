<?php
namespace App\Gpp\Stations\Repositories\Interfaces;

use App\Gpp\Stations\Station;
use App\Gpp\Users\User;
use App\Http\Resources\StationCollection;


interface StationRepositoryInterface {
    public function findAll():StationCollection;
    public function find(int $station_id):Station;
    public function save(Array $data);
    public function update(Array $data,int $station_id):bool;

}