<?php
namespace App\Gpp\ProductLists\Repositories\Interfaces;

use App\Gpp\ProductLists\ProductList;
use App\Http\Resources\ProductListCollection;

interface ProductListRepositoryInterface {

    public function findByLoadingId(int $loading_id):ProductListCollection;
    public function findByDeliveryId(int $delivery_id):ProductListCollection;
    public function find(int $product_list):ProductList;
    public function save(Array $data):ProductList;
    public function update(Array $data,int $product_list):bool;
    public function destroy(int $product_list):bool;

}