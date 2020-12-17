<?php
namespace App\Gpp\Deliveries\Repositories\Interfaces;

use App\Gpp\Deliveries\Delivery;
use App\Gpp\LoadingSlips\LoadingSlip;
use App\Http\Resources\DeliveryCollection;

interface DeliveryRepositoryInterface {
    public function findAll():DeliveryCollection;
    public function find(int $delivery_id):Delivery;
    public function save(Array $data):Delivery;
    public function update(Array $data,int $delivery_id):bool;

}