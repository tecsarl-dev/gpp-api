<?php
namespace App\Gpp\Companies\Repositories;
use App\Gpp\Companies\Company;
use Illuminate\Database\QueryException;
use App\Http\Resources\CompanyCollection;
use App\Gpp\Companies\Exceptions\CreateCompanyException;
use App\Gpp\Companies\Exceptions\UpdateCompanyException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Gpp\Companies\Exceptions\CompanyNotFoundException;
use App\Gpp\Companies\Repositories\Interfaces\CompanyRepositoryInterface; 

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

    public function findAll():CompanyCollection
    {
        try {
            return new CompanyCollection ($this->model->all()->sortDesc());
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
            return  $this->model->with('decisions')->findOrFail($company_id);
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
            $c = $this->model->findOrFail($company_id);
            return $c->update($data);
        } catch (QueryException $th) {
            throw new UpdateCompanyException($th);
        }
    }

    public function approuved(Array $data, int $company_id):bool 
    {
        try {
            $c = $this->model->findOrFail($company_id);
            return $c->update($data);
        } catch (QueryException $th) {
            
            throw new UpdateCompanyException($th);
        }
    }
    
}