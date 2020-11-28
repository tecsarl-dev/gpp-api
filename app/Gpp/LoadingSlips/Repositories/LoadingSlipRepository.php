<?php
namespace App\Gpp\LoadingSlips\Repositories;

use App\Gpp\LoadingSlips\LoadingSlip;
use App\Gpp\ProductLists\ProductList;
use App\Gpp\Stations\Exceptions\CreateLoadingSlipException;
use App\Gpp\Stations\Exceptions\LoadingSlipNotFoundException;
use App\Gpp\Stations\Repositories\Interfaces\LoadingSlipRepositoryInterface;
use App\Gpp\Users\Exceptions\UpdateLoadingSlipException;
use App\Http\Resources\LoadingSlipCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoadingSlipRepository implements LoadingSlipRepositoryInterface{
    
    /**
     * Constructor
     */
    function __construct(LoadingSlip $loading_slip)
    {
        $this->model = $loading_slip;
    }
    
    public function findAll():LoadingSlipCollection
    {
        try {
            return new LoadingSlipCollection($this->model->where('petroleum', Auth::user()->company_id)->with("depots")->get()->sortDesc());
        } catch (ModelNotFoundException $th) {
            throw new LoadingSlipNotFoundException($th);
        }
    }

    /**
     * Find User by ID
     * @return LoadingSlip
     * @throws LoadingSlipNotFoundException
     */
    public function find(int $loading_slip):LoadingSlip
    {
        try {
            return  $this->model->findOrFail($loading_slip);
        } catch (ModelNotFoundException $th) {
            throw new LoadingSlipNotFoundException($th);
        }
    }

    public function save(Array $data)
    {
        DB::beginTransaction();
        try {

            $data['petroleum'] = Auth::user()->company_id;
            $data['created_at'] = date('Y-m-d H:i:s');

            $slips = LoadingSlip::create($data);

            if(count($data['products']) > 0) {
                foreach($data['products'] as $product) {
                    ProductList::create(
                        [
                            "product_id" => $product['product_id'],
                            "product" => $product['product'],
                            "unity" => $product['unity'],
                            "quantity" => $product['quantity'],
                            "loading_slip_id" => $slips->id,
                        ]
                        );
                    
                }
            }
            DB::commit();
            return $slips;
        } catch (QueryException $th) {
            DB::rollBack();
            throw new CreateLoadingSlipException($th);
        }
    }

    public function update(Array $data,int $loading_slip):bool    
    {
        try {
            $user = $this->find($loading_slip);
            return $user->update($data);
        } catch (QueryException $th) {
            throw new UpdateLoadingSlipException($th);
        }
    }
    
}