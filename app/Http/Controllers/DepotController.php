<?php

namespace App\Http\Controllers;
use App\Gpp\Depots\Repositories\Interfaces\DepotRepositoryInterface;
use App\Gpp\Depots\Requests\CreateDepotRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepotController extends Controller
{
    private $depotRepo;

    /**
     * Constructeur
     */
    public function __construct(DepotRepositoryInterface $depotRepository)
    {
        $this->depotRepo = $depotRepository;
    }
    

    public function listDepots()
    {
        $depots = $this->depotRepo->listDepots();
        return response()->json(['depots' => $depots],200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $depots = $this->depotRepo->findAll();
        return response()->json(['depots' => $depots],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDepotRequest $request)
    {
        $lslips = $this->depotRepo->save($request->all());
        return response()->json(['message' => "Depot enregistrée"],201);
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
        $lslip = $this->depotRepo->update($request->all(),$request->id);

        return response()->json([
            'message'=>"Depot mise à jour"
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
        $delete = $this->depotRepo->destroy($id);

        return response()->json([
            'message' => "Dépot supprimé"
        ],200);
    }
}
