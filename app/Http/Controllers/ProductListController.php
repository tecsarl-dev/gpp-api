<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Gpp\ProductLists\Repositories\Interfaces\ProductListRepositoryInterface;

class ProductListController extends Controller
{
    private $productListRepo;

    /**
     * Constructeur
     */
    public function __construct(ProductListRepositoryInterface $productListRepository)
    {
        
        $this->productListRepo = $productListRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lslips = $this->productListRepo->save($request->all());
        return response()->json(['message' => "Liste Produit enregistré"],201);
    }

    public function index(Request $request)
    { 
        $lists = ($request->loading) ? $this->productListRepo->findByLoadingId($request->loading): $this->productListRepo->findByDeliveryId($request->delivery);
        return response()->json([
            "product_lists" => $lists
        ]);
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
        $delete = $this->productListRepo->destroy($id);

        return response()->json([
            'message' => "Produit supprimé"
        ],200);
    }
}
