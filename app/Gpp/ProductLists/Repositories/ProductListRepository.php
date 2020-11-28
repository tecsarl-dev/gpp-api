<?php
namespace App\Gpp\ProductLists\Repositories;
use App\Gpp\ProductLists\Exceptions\CreateProductListException;
use App\Gpp\ProductLists\Exceptions\ProductListNotFoundException;
use App\Gpp\ProductLists\Exceptions\UpdateProductListException;
use App\Gpp\ProductLists\ProductList;
use App\Gpp\ProductLists\Repositories\Interfaces\ProductListRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class ProductListRepository implements ProductListRepositoryInterface{
    
    /**
     * Constructor
     */
    function __construct(ProductList $product_list)
    {
        $this->model = $product_list;
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
    
}