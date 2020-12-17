<?php
namespace App\Gpp\Rates\Repositories;

 
use App\Gpp\Rates\Exceptions\CreateRateException;
use App\Gpp\Rates\Exceptions\RateDeleteException;
use App\Gpp\Rates\Exceptions\RateNotFoundException;
use App\Gpp\Rates\Exceptions\UpdateRateException;
use App\Gpp\Rates\Rate;
use App\Gpp\Rates\Repositories\Interfaces\RateRepositoryInterface;
use App\Http\Resources\RateCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class RateRepository implements RateRepositoryInterface{
    
    /**
     * Constructor
     */
    function __construct(Rate $rate_id)
    {
        $this->model = $rate_id;
    }

    /**
     * Find  
     * @return Rate
     * @throws RateNotFoundException
     */
    public function findAll():RateCollection
    {
        try {
            return  new RateCollection($this->model->with('products')->get()->sortDesc());
        } catch (ModelNotFoundException $th) {
            throw new RateNotFoundException($th);
        }
    }
    
    /**
     * Find User by ID
     * @return Rate
     * @throws RateNotFoundException
     */
    public function find(int $rate_id):Rate
    {
        try {
            return  $this->model->findOrFail($rate_id);
        } catch (ModelNotFoundException $th) {
            throw new RateNotFoundException($th);
        }
    }

    public function save(Array $data):Rate
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $th) {
            throw new CreateRateException($th);
        }
    }

    public function update(Array $data,int $rate_id):bool    
    {
        try {
            $user = $this->find($rate_id);
            return $user->update($data);
        } catch (QueryException $th) {
            throw new UpdateRateException($th);
        }
    }

    public function destroy(int $rate_id):bool
    {
        try {
            $rate = $this->find($rate_id);
            return $rate->delete();
        } catch (QueryException $th) {
            throw new RateDeleteException($th);
        }
    }
    
}