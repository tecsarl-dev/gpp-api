<?php
namespace App\Gpp\Products\Repositories;

use App\Gpp\Capacities\Exceptions\UpdateProductException;
use App\Gpp\Products\Exceptions\CreateProductException;
use App\Gpp\Products\Exceptions\ProductDeleteException;
use App\Gpp\Products\Exceptions\ProductNotFoundException;
use App\Gpp\Products\Product;
use App\Gpp\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Http\Resources\ProductCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class ProductRepository implements ProductRepositoryInterface{
    
    /**
     * Constructor
     */
    function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function listProducts():ProductCollection
    {
        try {
            return  new ProductCollection($this->model->where('active',1)->get());
        } catch (ModelNotFoundException $th) {
            throw new ProductNotFoundException($th);
        }
    }

    public function findAll():ProductCollection
    {
        try {
            return  new ProductCollection($this->model->all()->sortDesc());
        } catch (ModelNotFoundException $th) {
            throw new ProductNotFoundException($th);
        }
    }
    
    /**
     * Find User by ID
     * @return Product
     * @throws ProductNotFoundException
     */
    public function find(int $product_id):Product
    {
        try {
            return  $this->model->findOrFail($product_id);
        } catch (ModelNotFoundException $th) {
            throw new ProductNotFoundException($th);
        }
    }

    public function save(Array $data):Product
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $th) {
            throw new CreateProductException($th);
        }
    }

    public function update(Array $data,int $product):bool    
    {
        try {
            $user = $this->find($product);
            return $user->update($data);
        } catch (QueryException $th) {
            throw new UpdateProductException($th);
        }
    }

    public function destroy(int $product):bool
    {
        try {
            $payslip = $this->find($product);
            return $payslip->delete();
        } catch (QueryException $th) {
            throw new ProductDeleteException($th);
        }
    }
    
}