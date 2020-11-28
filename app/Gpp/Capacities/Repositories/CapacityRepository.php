<?php
namespace App\Gpp\Capacities\Repositories;
 
use App\Gpp\Capacities\Capacity;
use App\Gpp\Capacities\Exceptions\CapacityNotFoundException;
use App\Gpp\Capacities\Exceptions\CreateCapacityException;
use App\Gpp\Capacities\Exceptions\UpdateCapacityException;
use App\Gpp\Capacities\Repositories\Interfaces\CapacityRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class CapacityRepository implements CapacityRepositoryInterface{
    
    /**
     * Constructor
     */
    function __construct(Capacity $capacity)
    {
        $this->model = $capacity;
    }
    
    /**
     * Find User by ID
     * @return Capacity
     * @throws CapacityNotFoundException
     */
    public function find(int $capacity):Capacity
    {
        try {
            return  $this->model->findOrFail($capacity);
        } catch (ModelNotFoundException $th) {
            throw new CapacityNotFoundException($th);
        }
    }

    public function save(Array $data):Capacity
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $th) {
            throw new CreateCapacityException($th);
        }
    }

    public function update(Array $data,int $delivery):bool    
    {
        try {
            $user = $this->find($delivery);
            return $user->update($data);
        } catch (QueryException $th) {
            throw new UpdateCapacityException($th);
        }
    }
    
}