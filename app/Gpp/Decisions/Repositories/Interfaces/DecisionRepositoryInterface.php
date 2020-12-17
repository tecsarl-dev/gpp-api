<?php
namespace App\Gpp\Decisions\Repositories\Interfaces;

use App\Gpp\Decisions\Decision;
use App\Http\Resources\DecisionCollection;
 

interface DecisionRepositoryInterface {
    public function findAll():DecisionCollection;
    public function find(int $id):Decision;
    public function save(Array $data):Decision;
    public function update(Array $data,int $id):bool;
    public function destroy(int $id):bool;

}