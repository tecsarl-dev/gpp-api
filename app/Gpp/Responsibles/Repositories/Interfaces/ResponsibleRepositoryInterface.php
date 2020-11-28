<?php
namespace App\Gpp\Responsibles\Repositories\Interfaces;

use App\Gpp\Responsibles\Responsible;
 

interface ResponsibleRepositoryInterface {
    
    public function find(int $responsible_id):Responsible;
    public function save(Array $data):Responsible;
    public function update(Array $data,int $responsible_id):bool;

}