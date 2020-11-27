<?php
namespace App\Gpp\Stations\Repositories;

use App\Gpp\Capacities\Capacity;
use App\Gpp\Responsibles\Responsible;
use App\Gpp\Stations\Exceptions\CreateStationException;
use App\Gpp\Stations\Exceptions\StationNotFoundException;
use App\Gpp\Stations\Repositories\Interfaces\StationRepositoryInterface;
use App\Gpp\Stations\Station;
use App\Gpp\Users\Exceptions\UpdateStationException;
use App\Http\Resources\StationCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StationRepository implements StationRepositoryInterface{
    
    /**
     * Constructor
     */
    function __construct(Station $station)
    {
        $this->model = $station;
    }

    public function findAll():StationCollection
    {
        try {
            return new StationCollection($this->model->with(['responsibles','capacities'])->where('petroleum', Auth::user()->company_id)->get()->sortDesc());
        } catch (ModelNotFoundException $th) {
            throw new StationNotFoundException($th);
        }
    }
    
    /**
     * Find User by ID
     * @return User
     * @throws StationNotFoundException
     */
    public function find(int $station_id):Station
    {
        try {
            return  $this->model->findOrFail($station_id);
        } catch (ModelNotFoundException $th) {
            throw new StationNotFoundException($th);
        }
    }

    public function save(Array $data)
    {
        DB::beginTransaction();
        try {

            $data['petroleum'] =  Auth::user()->company_id;
            $data['authorization_file'] =  $data['authorization_file_name'];
            $data['approuved']  = 1; 
            
            $station = Station::create($data);

            $responsible = Responsible::create([
                "name" => $data['responsible_name'],
                "tel" => $data['responsible_tel'],
                "indicatif" => $data['responsible_indicatif'],
                "email" => $data['responsible_email'],
                "station_id" => $station->id
            ]);

            $capacity = Capacity::create([
                "gaz"=>  $data['capacity_gaz'],
                "fuel" => $data['capacity_fuel'],
                "gpl" => $data['capacity_gpl'],
                "station_id" =>  $station->id
            ]);

            DB::commit();
            return $station;

        } catch (QueryException $th) {
            DB::rollBack();
            throw new CreateStationException($th);
        }
    }

    public function update(Array $data,int $station_id):bool    
    {
        try {
            $user = $this->find($station_id);
            return $user->update($data);
        } catch (QueryException $th) {
            throw new UpdateStationException($th);
        }
    }
    
}