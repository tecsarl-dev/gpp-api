<?php
namespace App\Gpp\Cities\Repositories;

use App\Gpp\Cities\City;
use App\Gpp\Cities\Exceptions\CityDeleteException;
use App\Gpp\Cities\Exceptions\CityNotFoundException;
use App\Gpp\Cities\Exceptions\CreateCityException;
use App\Gpp\Cities\Exceptions\UpdateCityException;
use App\Gpp\Cities\Repositories\Interfaces\CityRepositoryInterface;
use App\Http\Resources\CityCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class CityRepository implements  CityRepositoryInterface
{
    /**
     * Constructor
     */
    function __construct(City $city)
    {
        $this->model = $city;
    }

    public function findAll():CityCollection
    {
        try {
            return  new CityCollection($this->model->all()->sortDesc());
        } catch (ModelNotFoundException $th) {
            throw new CityNotFoundException($th);
        }
    }

    /**
     * Find City by ID
     * @return City
     * @throws CityNotFoundException
     */
    public function find(int $city_id):City
    {
        try {
            return  $this->model->findOrFail($city_id);
        } catch (ModelNotFoundException $th) {
            throw new CityNotFoundException($th);
        }
    }

    /**
     * Find Slider By Name
     * @param string
     * @return City
     * @throws UserNotFoundException
     */
    public function findByName(string $name):City 
    {
        try {
            return  $this->model->where('city',$name)->first();
        } catch (ModelNotFoundException $th) {
            throw new CityNotFoundException($th);
        }
    }

    public function save(Array $data):City
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $th) {
            throw new CreateCityException($th);
        }
    }

    public function update(Array $data,int $city_id):bool    
    {
        try {
            $user = $this->find($city_id);
            return $user->update($data);
        } catch (QueryException $th) {
            throw new UpdateCityException($th);
        }
    }

    public function destroy(int $city_id):bool
    {
        try {
            $city = $this->find($city_id);
            return $city->delete();
        } catch (QueryException $th) {
            throw new CityDeleteException($th);
        }
    }
}