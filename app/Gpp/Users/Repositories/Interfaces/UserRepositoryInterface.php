<?php
namespace App\Gpp\Users\Repositories\Interfaces;

use App\Gpp\Users\User;


interface UserRepositoryInterface {
    
    public function findUser(int $userId):User;
    public function findUserByEmail(string $userEmail):User ;
    public function saveUser(Array $data):User;
    public function register(Array $data);
    public function updateUser(Array $data,int $user_id):bool;

}