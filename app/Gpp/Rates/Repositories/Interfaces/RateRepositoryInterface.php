<?php
namespace App\Gpp\Rates\Repositories\Interfaces;

use App\Gpp\Rates\Rate;
use App\Http\Resources\RateCollection;

interface RateRepositoryInterface {
    public function findAll():RateCollection;
    public function find(int $product_id):Rate;
    public function save(Array $data):Rate;
    public function update(Array $data,int $rate_id):bool;
    public function destroy(int $rate_id):bool;
}