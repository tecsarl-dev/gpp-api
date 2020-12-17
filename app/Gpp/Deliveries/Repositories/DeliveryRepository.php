<?php
namespace App\Gpp\Deliveries\Repositories;

use App\Gpp\Deliveries\Delivery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Gpp\LoadingSlips\LoadingSlip;
use App\Gpp\ProductLists\ProductList;
use Illuminate\Database\QueryException;
use App\Http\Resources\DeliveryCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Gpp\Deliveries\Exceptions\CreateDeliveryException;
use App\Gpp\Deliveries\Exceptions\UpdateDeliveryException;
use App\Gpp\Deliveries\Exceptions\DeliveryNotFoundException;
use App\Gpp\Deliveries\Exceptions\InsufficientStockException;
use App\Gpp\Deliveries\Repositories\Interfaces\DeliveryRepositoryInterface;

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
            return  $this->model->with('product_lists')->findOrFail($delivery);
        } catch (ModelNotFoundException $th) {
            throw new DeliveryNotFoundException($th);
        }
    }

    public function save(Array $data):Delivery
    {
        DB::beginTransaction();
        try {
            $data['petroleum'] = Auth::user()->company_id;

            // Verification du stock

            $loadingSlip = LoadingSlip::findOrFail($data['loading_slip_id']);

            

            foreach($loadingSlip->product_lists as $productBC) {
                foreach($data['products'] as $product) {
                    if ($product['product_id'] == $productBC['id']) {
                        if ($productBC['quantity'] <= 0) {
                            throw new InsufficientStockException('Le stock est insuffisant');
                        }

                        if ($productBC['quantity'] < $product['quantity']) {
                            throw new InsufficientStockException('Le stock est insuffisant');
                        }
                    }
                }
            }

            $delivery =  Delivery::create($data);

            if(count($data['products']) > 0) {
                foreach($data['products'] as $product) {
                    ProductList::create(
                        [
                            "product_id" => $product['product_id'],
                            "product" => $product['product'],
                            "unity" => $product['unity'],
                            "quantity" => $product['quantity'],
                            "delivery_id" => $delivery->id,
                        ]
                        );
                }
            }
            DB::commit();
            return $delivery;
        } catch (QueryException $th) {
            DB::rollBack();
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