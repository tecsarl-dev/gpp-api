<?php
namespace App\Gpp\ProductLists\Repositories\Interfaces;

use App\Gpp\ProductLists\ProductList;

interface ProductListRepositoryInterface {
    
    public function find(int $product_list):ProductList;
    public function save(Array $data):ProductList;
    public function update(Array $data,int $product_list):bool;

}