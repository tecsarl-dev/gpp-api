<?php
namespace App\Gpp\ProductLists\Repositories;
use App\Gpp\ProductLists\ProductList;
use Illuminate\Database\QueryException;
use App\Http\Resources\ProductListCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Gpp\ProductLists\Exceptions\CreateProductListException;
use App\Gpp\ProductLists\Exceptions\ProductListDeleteException;
use App\Gpp\ProductLists\Exceptions\UpdateProductListException;
use App\Gpp\ProductLists\Exceptions\ProductListNotFoundException;
use App\Gpp\ProductLists\Repositories\Interfaces\ProductListRepositoryInterface;

class ProductListRepository implements ProductListRepositoryInterface{
    
    /**
     * Constructor
     */
    function __construct(ProductList $product_list)
    {
        $this->model = $product_list;
    }

    public function findByLoadingId(int $loading_id):ProductListCollection
    {
        try {
            return  new ProductListCollection($this->model->where('loading_slip_id',$loading_id)->get());
        } catch (ModelNotFoundException $th) {
            throw new ProductListNotFoundException($th);
        }
    }
    public function findByDeliveryId(int $delivery_id):ProductListCollection
    {
        try {
            return  new ProductListCollection($this->model->where('delivery_id',$delivery_id)->get());
        } catch (ModelNotFoundException $th) {
            throw new ProductListNotFoundException($th);
        }
    }
    
    /**
     * Find User by ID
     * @return ProductList
     * @throws ProductListNotFoundException
     */
    public function find(int $product_list):ProductList
    {
        try {
            return  $this->model->findOrFail($product_list);
        } catch (ModelNotFoundException $th) {
            throw new ProductListNotFoundException($th);
        }
    }

    public function save(Array $data):ProductList
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $th) {
            throw new CreateProductListException($th);
        }
    }

    public function update(Array $data,int $product_list):bool    
    {
        try {
            $user = $this->find($product_list);
            return $user->update($data);
        } catch (QueryException $th) {
            throw new UpdateProductListException($th);
        }
    }

    public function destroy(int $product_list):bool
    {
        try {
            $dele = $this->find($product_list);
            return $dele->delete();
        } catch (QueryException $th) {
            throw new ProductListDeleteException($th);
        }
    }
    
}