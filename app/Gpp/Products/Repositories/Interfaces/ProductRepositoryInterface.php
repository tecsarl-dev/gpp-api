<?php
namespace App\Gpp\Products\Repositories\Interfaces;

use App\Gpp\Products\Product;
use App\Http\Resources\ProductCollection;

 

interface ProductRepositoryInterface {
    public function listProducts():ProductCollection;
    public function findAll():ProductCollection;
    public function find(int $product_id):Product;
    public function save(Array $data):Product;
    public function update(Array $data,int $product_id):bool;
    public function destroy(int $product):bool;
}