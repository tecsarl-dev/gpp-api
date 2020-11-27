<?php
namespace App\Gpp\Companies\Repositories\Interfaces;

use App\Gpp\Companies\Company;
use App\Http\Resources\CompanyCollection;
 

interface CompanyRepositoryInterface {
    public function listTransporters():CompanyCollection;
    public function find(int $company_id):Company;
    public function save(Array $data):Company;
    public function update(Array $data,int $company_id):bool;

}