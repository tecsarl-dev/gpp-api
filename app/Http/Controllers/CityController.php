<?php

namespace App\Http\Controllers;

use App\Gpp\Cities\Repositories\CityRepository;
use App\Gpp\Cities\Requests\CreateCityRequest;
use App\Gpp\Cities\Requests\UpdateCityRequest;
use Illuminate\Http\Request;

class CityController extends Controller
{
    private $cityRepo;

    /**
     * Constructeur
     */
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepo = $cityRepository;
    }

    /**
     * Get All Cities
     */
    public function index()
    {
        $cities = $this->cityRepo->findAll();
        return response()->json([
            'cities' => $cities,
        ]);
    }

    /**
     * Save City
     */
    public function store(CreateCityRequest $request)
    {
        $city = $this->cityRepo->save($request->all());
        return response()->json([
            'message' => 'Ville Ajoutée',
        ]);
    }

    /**
     * Update City
     */
    public function update(UpdateCityRequest $request, $city)
    {
        $cityUpdate = $this->cityRepo->update($request->all(),$city);

        return response()->json(["message" => "Ville modifiée "],200);
    }

    /**
     * Delete City
     */
    public function destroy($city)
    {
        $delete = $this->cityRepo->destroy($city);

        return response()->json([
            'message' => "Ville supprimée"
        ],200);
    }
}
