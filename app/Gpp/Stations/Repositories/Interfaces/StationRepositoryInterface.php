<?php
namespace App\Gpp\Stations\Repositories\Interfaces;

use App\Gpp\Stations\Station;
use App\Gpp\Users\User;
use App\Http\Resources\StationCollection;


interface StationRepositoryInterface {
    public function listStations():StationCollection;
    public function findAll():StationCollection;
    public function find(int $station_id):Station;
    public function save(Array $data);
    public function update(Array $data,int $station_id):bool;
    public function destroy(int $station_id):bool;
    public function approuved(Array $data, int $station_id):bool ;


}