<?php
namespace App\Gpp\Decisions\Repositories;


use App\Gpp\Decisions\Exceptions\CreateDecisionException;
use App\Gpp\Decisions\Exceptions\DecisionDeleteException;
use App\Gpp\Decisions\Exceptions\DecisionNotFoundException;
use App\Gpp\Decisions\Exceptions\UpdateDecisionException;
use App\Gpp\Decisions\Repositories\Interfaces\DecisionRepositoryInterface;
use App\Gpp\Decisions\Decision;
use App\Http\Resources\DecisionCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class DecisionRepository implements  DecisionRepositoryInterface
{
    /**
     * Constructor
     */
    function __construct(Decision $decision)
    {
        $this->model = $decision;
    }

    public function findAll():DecisionCollection
    {
        try {
            return  new DecisionCollection($this->model->all()->sortDesc());
        } catch (ModelNotFoundException $th) {
            throw new DecisionNotFoundException($th);
        }
    }

    /**
     * Find City by ID
     * @return City
     * @throws CityNotFoundException
     */
    public function find(int $id):Decision
    {
        try {
            return  $this->model->findOrFail($id);
        } catch (ModelNotFoundException $th) {
            throw new DecisionNotFoundException($th);
        }
    }

    
    public function save(Array $data):Decision
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $th) {
            throw new CreateDecisionException($th);
        }
    }

    public function update(Array $data,int $id):bool    
    {
        try {
            $user = $this->find($id);
            return $user->update($data);
        } catch (QueryException $th) {
            throw new UpdateDecisionException($th);
        }
    }

    public function destroy(int $id):bool
    {
        try {
            $city = $this->find($id);
            return $city->delete();
        } catch (QueryException $th) {
            throw new DecisionDeleteException($th);
        }
    }
}