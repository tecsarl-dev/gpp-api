<?php
namespace App\Gpp\Depots\Repositories\Interfaces;

use App\Gpp\Depots\Depot;
use App\Http\Resources\DepotCollection;

interface DepotRepositoryInterface {
    public function listDepots():DepotCollection;
    public function findAll():DepotCollection;
    public function find(int $depot_id):Depot;
    public function save(Array $data):Depot;
    public function update(Array $data,int $depot_id):bool;
    public function destroy(int $depot_id):bool;
}