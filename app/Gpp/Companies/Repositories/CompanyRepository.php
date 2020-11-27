<?php
namespace App\Gpp\Companies\Repositories;
use App\Gpp\Companies\Company;
use App\Gpp\Companies\Exceptions\CompanyNotFoundException;
use App\Gpp\Companies\Exceptions\CreateCompanyException;
use App\Gpp\Companies\Repositories\Interfaces\CompanyRepositoryInterface; 
use App\Gpp\Trucks\Exceptions\UpdateCompanyException;
use App\Http\Resources\CompanyCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class CompanyRepository implements CompanyRepositoryInterface{
    
    /**
     * Constructor
     */
    function __construct(Company $company)
    {
        $this->model = $company;
    }

    public function listTransporters():CompanyCollection
    {
        try {
            return  new CompanyCollection($this->model->whereApprouved(1)->whereType('transporter')->get());
        } catch (ModelNotFoundException $th) {
            throw new CompanyNotFoundException($th);
        }
    }
    
    /**
     * Find User by ID
     * @return Depot
     * @throws DepotNotFoundException
     */
    public function find(int $company_id):Company
    {
        try {
            return  $this->model->findOrFail($company_id);
        } catch (ModelNotFoundException $th) {
            throw new CompanyNotFoundException($th);
        }
    }

    public function save(Array $data):Company
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $th) {
            throw new CreateCompanyException($th);
        }
    }

    public function update(Array $data,int $company_id):bool    
    {
        try {
            $user = $this->find($company_id);
            return $user->update($data);
        } catch (QueryException $th) {
            throw new UpdateCompanyException($th);
        }
    }
    
}