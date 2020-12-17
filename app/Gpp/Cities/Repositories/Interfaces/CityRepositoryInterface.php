<?php
namespace App\Gpp\Cities\Repositories\Interfaces;

use App\Gpp\Cities\City;
use App\Http\Resources\CityCollection;
 

interface CityRepositoryInterface {
    public function findAll():CityCollection;
    public function find(int $cityId):City;
    public function findByName(string $name):City ;
    public function save(Array $data):City;
    public function update(Array $data,int $cityId):bool;
    public function destroy(int $city_id):bool;

}