<?php
namespace App\Gpp\Trucks\Repositories\Interfaces;

use App\Gpp\Trucks\Truck;
use App\Http\Resources\TruckCollection;

interface TruckRepositoryInterface {
    public function listTrucks():TruckCollection;
    public function findAll():TruckCollection;
    public function find(int $truck_id):Truck;
    public function save(Array $data):Truck;
    public function update(Array $data,int $truck_id):bool;
    public function destroy(int $truck_id):bool;
    public function approuved(Array $data, int $truck_id):bool;

}