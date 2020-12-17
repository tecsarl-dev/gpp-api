<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\DontEditOnceApprouvedException;
use App\Gpp\Deliveries\Exceptions\InsufficientStockException;
use App\Gpp\Deliveries\Requests\CreateDeliveryRequest;
use App\Gpp\Deliveries\Repositories\Interfaces\DeliveryRepositoryInterface;
use App\Gpp\ProductLists\Repositories\Interfaces\ProductListRepositoryInterface;

class DeliveryController extends Controller
{
    private $deliveryRepo;
    private $productListRepo;

    /**
     * Constructeur
     */
    public function __construct(DeliveryRepositoryInterface $deliveryRepository, ProductListRepositoryInterface $productListRepository)
    {
        $this->deliveryRepo = $deliveryRepository;
        $this->productListRepo = $productListRepository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = $this->deliveryRepo->findAll();
        return response()->json(['deliveries' => $deliveries],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDeliveryRequest $request)
    {
        $productListLoading =  $this->productListRepo->findByLoadingId($request->loading_slip_id);

        $isAllOk = false;
        foreach ($productListLoading as $pll) {
            foreach ($request->products as $pld) {
                if ($pll->product_id == $pld['product_id'] && $pld['product_id'] > ($pll->quantity - $pll->quantity_used)) {
                    $isAllOk = true;
                }
            }
        }

        if ($isAllOk) {
            throw new InsufficientStockException("Une quantité renseignée est insuffisante.");
        }


        $lslips = $this->deliveryRepo->save($request->all());

        if ($request->approuved == 1) {
            foreach ($productListLoading as $p1) {
                foreach ($request->products as $p2) {
                    if ($p1->product_id == $p2['product_id']) {
                        $this->productListRepo->update([
                            "quantity_used"=> $p1->quantity_used + $p2['quantity']
                        ],$p1->id);
                    }
                }
            }
        }

        return response()->json(['message' => "Livraison enregistrée"],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $delivery = $this->deliveryRepo->find($id);

        if($delivery->approuved === 1) {
            throw new DontEditOnceApprouvedException();
        }
        return response()->json(['delivery' => $delivery],201);
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
        
   
        $productListLoading =  $this->productListRepo->findByLoadingId($request->loading_slip_id);
        $productListDeliveries =  $this->productListRepo->findByDeliveryId($request->id);

        $isAllOk = false;
        foreach ($productListLoading as $pll) {
            foreach ($productListDeliveries as $pld) {
                if ($pll->product_id == $pld->product_id && $pld->quantity > ($pll->quantity - $pll->quantity_used)) {
                    $isAllOk = true;
                }
            }
        }

        if ($isAllOk) {
            throw new InsufficientStockException("Une quantité renseignée est insuffisante.");
        }

        $lslip = $this->deliveryRepo->update($request->all(),$request->id);

        if ($request->approuved == 1) {
            foreach ($productListLoading as $p1) {
                foreach ($productListDeliveries as $p2) {
                    if ($p1->product_id == $p2->product_id) {
                        $this->productListRepo->update([
                            "quantity_used"=> $p1->quantity_used + $p2->quantity
                        ],$p1->id);
                    }
                }
            }
        }
        
        
        return response()->json([
            'message'=>"Livraison mise à jour"
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
    }
}
