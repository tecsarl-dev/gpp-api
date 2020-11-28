<?php
namespace App\Gpp\Trucks\Repositories;
 
 
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
            return  new TruckCollection($this->model->where('active',1)->get());
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
            return  $this->model->findOrFail($truck_id);
        } catch (ModelNotFoundException $th) {
            throw new TruckNotFoundException($th);
        }
    }

    public function save(Array $data):Truck
    {
        try {
            // Pour les test 
            $data['approuved']  = 1; 
            // 
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
    
}