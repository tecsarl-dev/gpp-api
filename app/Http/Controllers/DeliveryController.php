<?php

namespace App\Http\Controllers;

use App\Exceptions\DontEditOnceApprouvedException;
use App\Gpp\Deliveries\Requests\CreateDeliveryRequest;
use App\Gpp\Stations\Repositories\Interfaces\DeliveryRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    private $deliveryRepo;

    /**
     * Constructeur
     */
    public function __construct(DeliveryRepositoryInterface $deliveryRepository)
    {
        $this->deliveryRepo = $deliveryRepository;
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
        $lslips = $this->deliveryRepo->save($request->all());
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
        $lslip = $this->deliveryRepo->update($request->all(),$request->id);

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
