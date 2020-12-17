<?php

namespace App\Http\Controllers;
use App\Gpp\Rates\Repositories\Interfaces\RateRepositoryInterface;
use App\Gpp\Rates\Requests\CreateRateRequest;
use App\Gpp\Rates\Requests\UpdateRateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RateController extends Controller
{
    private $rateRepo;

    /**
     * Constructeur
     */
    public function __construct(RateRepositoryInterface $rateRepository)
    {
        $this->rateRepo = $rateRepository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rates = $this->rateRepo->findAll();
        return response()->json(['rates' => $rates],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRateRequest $request)
    {
        $lslips = $this->rateRepo->save($request->all());
        return response()->json(['message' => "Tarif enregistré"],201);
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
    public function update(UpdateRateRequest $request, $id)
    {
        $lslip = $this->rateRepo->update($request->all(),$request->id);

        return response()->json([
            'message'=>"Tarif mise à jour"
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
        $delete = $this->rateRepo->destroy($id);

        return response()->json([
            'message' => "Tarif supprimé"
        ],200);
    }
}
