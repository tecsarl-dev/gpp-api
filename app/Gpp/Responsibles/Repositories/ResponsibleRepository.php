<?php
namespace App\Gpp\Responsibles\Repositories;
 
 
use App\Gpp\Responsibles\Exceptions\CreateResponsibleException;
use App\Gpp\Responsibles\Exceptions\ResponsibleNotFoundException;
use App\Gpp\Responsibles\Exceptions\UpdateResponsibleException;
use App\Gpp\Responsibles\Repositories\Interfaces\ResponsibleRepositoryInterface;
use App\Gpp\Responsibles\Responsible;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class ResponsibleRepository implements ResponsibleRepositoryInterface{
    
    /**
     * Constructor
     */
    function __construct(Responsible $responsible)
    {
        $this->model = $responsible;
    }
    
    /**
     * Find User by ID
     * @return Responsible
     * @throws ResponsibleNotFoundException
     */
    public function find(int $responsible_id):Responsible
    {
        try {
            return  $this->model->findOrFail($responsible_id);
        } catch (ModelNotFoundException $th) {
            throw new ResponsibleNotFoundException($th);
        }
    }

    public function save(Array $data):Responsible
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $th) {
            throw new CreateResponsibleException($th);
        }
    }

    public function update(Array $data,int $responsible_id):bool    
    {
        try {
            $user = $this->find($responsible_id);
            return $user->update($data);
        } catch (QueryException $th) {
            throw new UpdateResponsibleException($th);
        }
    }
    
}