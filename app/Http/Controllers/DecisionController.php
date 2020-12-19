<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gpp\Decisions\Requests\CreateDecisionRequest;
use App\Gpp\Decisions\Requests\UpdateDecisionRequest;
use App\Gpp\Decisions\Repositories\DecisionRepository;

class DecisionController extends Controller
{
    private $decisionRepo;

    /**
     * Constructeur
     */
    public function __construct(DecisionRepository $decisionRepository)
    {
        $this->decisionRepo = $decisionRepository;
    }

    /**
     * Get All Cities
     */
    public function index()
    {
        $decisions = $this->decisionRepo->findAll();
        return response()->json([
            'decisions' => $decisions,
        ]);
    }

    /**
     * Save City
     */
    public function store(CreateDecisionRequest $request)
    {
        $decision = $this->decisionRepo->save($request->all());
        return response()->json([
            'message' => 'Décision Ajoutée',
        ]);
    }

    /**
     * Update City
     */
    public function update(UpdateDecisionRequest $request, $city)
    {
        $decision = $this->decisionRepo->update($request->all(),$city);

        return response()->json(["message" => "Décision modifiée "],200);
    }

    /**
     * Delete City
     */
    public function destroy($city)
    {
        $delete = $this->decisionRepo->destroy($city);

        return response()->json([
            'message' => "Décison supprimée"
        ],200);
    }
}
