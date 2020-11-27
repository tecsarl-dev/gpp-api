<?php
namespace App\Gpp\Stations\Repositories\Interfaces;

use App\Gpp\LoadingSlips\LoadingSlip;
use App\Http\Resources\LoadingSlipCollection;

 

interface LoadingSlipRepositoryInterface {
    public function findAll():LoadingSlipCollection;
    public function find(int $loading_slip_id):LoadingSlip;
    public function save(Array $data);
    public function update(Array $data,int $loading_slip_id):bool;

}