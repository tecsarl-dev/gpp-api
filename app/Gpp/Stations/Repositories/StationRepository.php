<?php
namespace App\Gpp\Stations\Repositories;

use App\Gpp\Stations\Station;
use App\Gpp\Capacities\Capacity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Gpp\Responsibles\Responsible;
use Illuminate\Database\QueryException;
use App\Http\Resources\StationCollection;
use App\Gpp\Users\Exceptions\UpdateStationException;
use App\Gpp\Stations\Exceptions\CreateStationException;
use App\Gpp\Stations\Exceptions\StationDeleteException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Gpp\Stations\Exceptions\StationNotFoundException;
use App\Gpp\Stations\Repositories\Interfaces\StationRepositoryInterface;
use App\Gpp\Stations\Requests\UpdateStationRequest;

class StationRepository implements StationRepositoryInterface{
    
    /**
     * Constructor
     */
    function __construct(Station $station)
    {
        $this->model = $station;
    }

    public function listStations():StationCollection
    {
        try {
            return  new StationCollection($this->model->with('companies')->get()->sortDesc());
        } catch (ModelNotFoundException $th) {
            throw new StationNotFoundException($th);
        }
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
            return  $this->model->with(["capacities","responsibles","decisions"])->findOrFail($station_id);
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
        DB::beginTransaction();
        try {

            if (array_key_exists('authorization_file',$data)) {
                $data['authorization_file'] =  $data['authorization_file_name'];
            }

            $station = $this->find($station_id);
            $station->update($data);

            $responsible = Responsible::find($data['responsible_id']);
            $responsible->name = $data['responsible_name'];
            $responsible->tel = $data['responsible_tel'];
            $responsible->indicatif = $data['responsible_indicatif'];
            $responsible->email = $data['responsible_email'];
            
            $responsible->save();


            $capacity = Capacity::find($data['capacity_id']);
            $capacity->gaz = $data['capacity_gaz'];
            $capacity->fuel = $data['capacity_fuel'];
            $capacity->gpl = $data['capacity_gpl'];
            $capacity->save();

            DB::commit();
            return ($station) ? 1 :0;
        } catch (QueryException $th) {
            DB::rollBack();
            throw new UpdateStationException($th);
        }
    }

    public function approuved(Array $data, int $station_id):bool 
    {
        try {
            $c = $this->model->findOrFail($station_id);
            return $c->update($data);
        } catch (QueryException $th) {
            
            throw new UpdateStationException($th);
        }
    }

    public function destroy(int $station_id):bool
    {
        try {
            $station = $this->find($station_id);
            return $station->delete();
        } catch (QueryException $th) {
            throw new StationDeleteException($th);
        }
    }
    
}