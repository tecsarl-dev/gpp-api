<?php
namespace App\Gpp\Deliveries\Repositories;

use App\Gpp\Deliveries\Delivery;
use App\Gpp\Deliveries\Exceptions\CreateDeliveryException;
use App\Gpp\Deliveries\Exceptions\DeliveryNotFoundException;
use App\Gpp\Deliveries\Exceptions\UpdateDeliveryException;
use App\Gpp\Stations\Repositories\Interfaces\DeliveryRepositoryInterface;
use App\Http\Resources\DeliveryCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class DeliveryRepository implements DeliveryRepositoryInterface{
    
    /**
     * Constructor
     */
    function __construct(Delivery $delivery)
    {
        $this->model = $delivery;
    }

    public function findAll():DeliveryCollection
    {
        try {
            return new DeliveryCollection($this->model->where('petroleum', Auth::user()->company_id)->get()->sortDesc());
        } catch (ModelNotFoundException $th) {
            throw new DeliveryNotFoundException($th);
        }
    }
    
    /**
     * Find User by ID
     * @return Delivery
     * @throws DeliveryNotFoundException
     */
    public function find(int $delivery):Delivery
    {
        try {
            return  $this->model->findOrFail($delivery);
        } catch (ModelNotFoundException $th) {
            throw new DeliveryNotFoundException($th);
        }
    }

    public function save(Array $data):Delivery
    {
        try {
            $data['petroleum'] = Auth::user()->company_id;
            return $this->model->create($data);
        } catch (QueryException $th) {
            throw new CreateDeliveryException($th);
        }
    }

    public function update(Array $data,int $delivery):bool    
    {
        try {
            $user = $this->find($delivery);
            return $user->update($data);
        } catch (QueryException $th) {
            throw new UpdateDeliveryException($th);
        }
    }
    
}