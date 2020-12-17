<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Gpp\LoadingSlips\Requests\CreateLoadingSlipRequest;
use App\Gpp\LoadingSlips\Repositories\Interfaces\LoadingSlipRepositoryInterface;
use App\Gpp\LoadingSlips\Requests\UpdateLoadingSlipRequest;

class LoadingSlipController extends Controller
{
    private $loadingslipRepo;

    /**
     * Constructeur
     */
    public function __construct(LoadingSlipRepositoryInterface $loadingslipRepository)
    {
        $this->loadingslipRepo = $loadingslipRepository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loadingSlips = $this->loadingslipRepo->findAll();
        return response()->json(['loadingSlips' => $loadingSlips],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLoadingSlipRequest $request)
    {
        $lslips = $this->loadingslipRepo->save($request->all());
        return response()->json(['message' => "Bon de chargement enregistré"],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loadingSlips = $this->loadingslipRepo->find($id);

        return response()->json(['loadingSlips' => $loadingSlips],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( UpdateLoadingSlipRequest $request, $id)
    {
        $lslip = $this->loadingslipRepo->update($request->all(),$id);

        return response()->json([
            'message'=>"Bon de chargement mise à jour"
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
        $delete = $this->loadingslipRepo->destroy($id);
        return response()->json([
            'message' => "Bon de chargement supprimé"
        ],200);
    }
}
