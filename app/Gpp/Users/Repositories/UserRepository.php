<?php
namespace App\Gpp\Users\Repositories;

use App\Gpp\Users\Exceptions\CreateUsersException;
use App\Gpp\Users\Exceptions\UpdateUsersException;
use App\Gpp\Users\Exceptions\UserNotFoundException;
use App\Gpp\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Gpp\Users\User;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface{
    
    /**
     * Constructor
     */
    function __construct(User $user)
    {
        $this->model = $user;
    }
    
    /**
     * Find User by ID
     * @return User
     * @throws UserNotFoundException
     */
    public function findUser(int $userId):User
    {
        try {
            return  $this->model->findOrFail($userId);
        } catch (ModelNotFoundException $th) {
            throw new UserNotFoundException($th);
        }
    }

    /**
     * Find User By Email
     * @param string
     * @return User
     * @throws UserNotFoundException
     */
    public function findUserByEmail(string $userEmail):User 
    {
        try {
            return  $this->model->where('email',$userEmail)->first();
        } catch (ModelNotFoundException $th) {
            throw new UserNotFoundException($th);
        }
    }

    public function saveUser(Array $data):User
    {
        try {
            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }

            return $this->model->create($data);
        } catch (QueryException $th) {
            throw new CreateUsersException($th);
        }
    }

    public function register(Array $data)
    {
        DB::beginTransaction();
        try {
            $company_id = DB::table('companies')->insertGetId([
                'type' => $data['type'],
            ]);
            $user_id = DB::table('users')->insertGetId(
                [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                    'type' => $data['type'],
                    'digit_code' => $data['digit_code'],
                    'digit_code_expired_at' => $data['digit_code_expired_at'],
                    'password' => bcrypt($data['password']),
                    'company_id' => $company_id,
                ]
            );
            DB::commit();

            return [
                'id' => $user_id,
                'email' => $data['email'],
                'digit_code' => $data['digit_code'],
                'digit_code_expired_at' => $data['digit_code_expired_at'],
                'password' => $data['password'],
            ];
        }
        catch(QueryException $th) {
            DB::rollBack();
            throw new CreateUsersException($th);
        }
    }

    public function updateUser(Array $data,int $user_id):bool    
    {
        try {

            $user = $this->findUser($user_id);
            if (isset($data['password'])) {
                $data['password'] = ($data['password']) ? bcrypt($data['password']): $user->password ;
            }
            return $user->update($data);
        } catch (QueryException $th) {
            throw new UpdateUsersException($th);
        }
    }
    
}
