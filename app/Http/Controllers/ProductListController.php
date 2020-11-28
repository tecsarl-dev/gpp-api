<?php

namespace App\Http\Controllers;

use App\Gpp\ProductLists\Repositories\Interfaces\ProductListRepositoryInterface;
use App\Gpp\Products\Requests\CreateProductListRequest;
use Illuminate\Http\Request;

class ProductListController extends Controller
{
    private $rateRepo;

    /**
     * Constructeur
     */
    public function __construct(ProductListRepositoryInterface $productListRepository)
    {
        $this->productListRepo = $productListRepository;
    }

    public function listProductLists()
    {
        $productLists = $this->productListRepo->listProductLists();
        return response()->json(['productLists' => $productLists],200);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productLists = $this->productListRepo->findAll();
        return response()->json(['productLists' => $productLists],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductListRequest $request)
    {
        $lslips = $this->productListRepo->save($request->all());
        return response()->json(['message' => "Liste Produit enregistré"],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lslip = $this->productListRepo->update($request->all(),$request->id);

        return response()->json([
            'message'=>"Liste Produit mise à jour"
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->productRepo->destroy($id);

        return response()->json([
            'message' => "Produit supprimé"
        ],200);
    }
}
