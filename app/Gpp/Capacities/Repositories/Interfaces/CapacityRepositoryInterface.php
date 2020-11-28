<?php
namespace App\Gpp\Capacities\Repositories\Interfaces;

use App\Gpp\Capacities\Capacity;
 

interface CapacityRepositoryInterface {
    
    public function find(int $capacity_id):Capacity;
    public function save(Array $data):Capacity;
    public function update(Array $data,int $capacity_id):bool;

}