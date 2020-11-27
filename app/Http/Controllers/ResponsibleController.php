<?php

namespace App\Http\Controllers;
use App\Gpp\Stations\Repositories\Interfaces\DeliveryRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResponsibleController extends Controller
{
    private $responsibleRepo;

    /**
     * Constructeur
     */
    public function __construct(DeliveryRepositoryInterface $responsibleRepository)
    {
        $this->responsibleRepo = $responsibleRepository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $stations = $this->stationRepo->listStation($request->user()->id);
        // return response()->json(['stations' => $stations],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lslips = $this->responsibleRepo->save($request->all());
        return response()->json(['message' => "Responsable enregistré"],201);
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
        $lslip = $this->deliveryRepo->update($request->all(),$request->id);

        return response()->json([
            'message'=>"Responsable mise à jour"
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
