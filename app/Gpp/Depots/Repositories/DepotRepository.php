<?php
namespace App\Gpp\Depots\Repositories;
 
 
use App\Gpp\Depots\Depot;
use App\Gpp\Depots\Exceptions\CreateDepotException;
use App\Gpp\Depots\Exceptions\DepotDeleteException;
use App\Gpp\Depots\Exceptions\DepotNotFoundException;
use App\Gpp\Depots\Exceptions\UpdateDepotException;
use App\Gpp\Depots\Repositories\Interfaces\DepotRepositoryInterface;
use App\Http\Resources\DepotCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class DepotRepository implements DepotRepositoryInterface{
    
    /**
     * Constructor
     */
    function __construct(Depot $depot)
    {
        $this->model = $depot;
    }

    public function listDepots():DepotCollection
    {
        try {
            return  new DepotCollection($this->model->where('active',1)->get());
        } catch (ModelNotFoundException $th) {
            throw new DepotNotFoundException($th);
        }
    }

    public function findAll():DepotCollection
    {
        try {
            return  new DepotCollection($this->model->all()->sortDesc());
        } catch (ModelNotFoundException $th) {
            throw new DepotNotFoundException($th);
        }
    }
    
    /**
     * Find User by ID
     * @return Depot
     * @throws DepotNotFoundException
     */
    public function find(int $depot_id):Depot
    {
        try {
            return  $this->model->findOrFail($depot_id);
        } catch (ModelNotFoundException $th) {
            throw new DepotNotFoundException($th);
        }
    }

    public function save(Array $data):Depot
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $th) {
            throw new CreateDepotException($th);
        }
    }

    public function update(Array $data,int $depot_id):bool    
    {
        try {
            $user = $this->find($depot_id);
            return $user->update($data);
        } catch (QueryException $th) {
            throw new UpdateDepotException($th);
        }
    }

    public function destroy(int $depot_id):bool
    {
        try {
            $depot = $this->find($depot_id);
            return $depot->delete();
        } catch (QueryException $th) {
            throw new DepotDeleteException($th);
        }
    }
    
}