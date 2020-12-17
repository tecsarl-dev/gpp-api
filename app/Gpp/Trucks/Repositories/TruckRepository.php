<?php
namespace App\Gpp\Trucks\Repositories;
 
 
use App\Gpp\Products\Exceptions\TruckDeleteException;
use App\Gpp\Trucks\Exceptions\CreateTruckException;
use App\Gpp\Trucks\Exceptions\TruckNotFoundException;
use App\Gpp\Trucks\Exceptions\UpdateTruckException;
use App\Gpp\Trucks\Repositories\Interfaces\TruckRepositoryInterface;
use App\Gpp\Trucks\Truck;
use App\Http\Resources\TruckCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class TruckRepository implements TruckRepositoryInterface{
    
    /**
     * Constructor
     */
    function __construct(Truck $truck)
    {
        $this->model = $truck;
    }


    public function listTrucks():TruckCollection
    {
        try {
            return  new TruckCollection($this->model->with('companies')->get()->sortDesc());
        } catch (ModelNotFoundException $th) {
            throw new TruckNotFoundException($th);
        }
    }

    public function findAll():TruckCollection
    {
        try {
            return  new TruckCollection($this->model->where('transporter', Auth::user()->company_id)->get()->sortDesc());
        } catch (ModelNotFoundException $th) {
            throw new TruckNotFoundException($th);
        }
    }
    
    /**
     * Find User by ID
     * @return Truck
     * @throws TruckNotFoundException
     */
    public function find(int $truck_id):Truck
    {
        try {
            return  $this->model->with(['companies','decisions'])->findOrFail($truck_id);
        } catch (ModelNotFoundException $th) {
            throw new TruckNotFoundException($th);
        }
    }

    public function save(Array $data):Truck
    {
        try {
            // Pour les test 
            return $this->model->create($data);
        } catch (QueryException $th) {
            throw new CreateTruckException($th);
        }
    }

    public function update(Array $data,int $truck_id):bool    
    {
        try {
            $user = $this->find($truck_id);
            return $user->update($data);
        } catch (QueryException $th) {
            throw new UpdateTruckException($th);
        }
    }

    public function approuved(Array $data, int $truck_id):bool 
    {
        try {
            $c = $this->model->findOrFail($truck_id);
            return $c->update($data);
        } catch (QueryException $th) {
            
            throw new UpdateTruckException($th);
        }
    }

    public function destroy(int $truck_id):bool
    {
        try {
            $truck = $this->find($truck_id);
            return $truck->delete();
        } catch (QueryException $th) {
            throw new TruckDeleteException($th);
        }
    }
    
}