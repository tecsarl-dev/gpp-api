<?php
namespace App\Gpp\Users;
use App\Gpp\Decisions\Decision;
use Laravel\Passport\HasApiTokens;
use App\Http\Resources\UserCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'type',
        'first_name',
        'last_name',
        'birthday',
        'part_number',
        'part_exp',
        'id_photo',
        'company_id',
        'digit_code',
        'digit_code_expired_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //  /**
    //  * Create a new Eloquent Collection instance.
    //  *
    //  * @param  array  $models
    //  * @return \Illuminate\Database\Eloquent\Collection
    //  */
    // public function newCollection(array $models = [])
    // {
    //     return new UserCollection($models);
    // }



    public function decisions()
    {
        return $this->hasMany(Decision::class);
    }
}
