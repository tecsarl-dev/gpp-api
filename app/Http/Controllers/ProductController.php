<?php

namespace App\Http\Controllers;
use App\Gpp\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Gpp\Products\Requests\CreateProductRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $rateRepo;

    /**
     * Constructeur
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepo = $productRepository;
    }

    public function listProducts()
    {
        $products = $this->productRepo->listProducts();
        return response()->json(['products' => $products],200);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepo->findAll();
        return response()->json(['products' => $products],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $lslips = $this->productRepo->save($request->all());
        return response()->json(['message' => "Produit enregistré"],201);
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
        $lslip = $this->productRepo->update($request->all(),$request->id);

        return response()->json([
            'message'=>"Produit mise à jour"
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
