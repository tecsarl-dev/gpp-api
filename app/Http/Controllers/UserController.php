<?php
namespace App\Http\Controllers;

use App\Gpp\Companies\Exceptions\CompanyNotApprouvedException;
use App\Gpp\Users\Exceptions\CredentialsException;
use App\Gpp\Users\Exceptions\EmailNotVerifiedException;
use App\Gpp\Users\Exceptions\UsersDigitCodeExpiredException;
use App\Gpp\Users\Exceptions\UsersDigitCodeInvalidException;
use App\Gpp\Users\Exceptions\UsersSendCodeVerificationErrorException;
use App\Gpp\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Gpp\Users\Requests\LoginRequest;
use App\Gpp\Users\Requests\RegisterRequest;
use App\Gpp\Users\Requests\SendNewDigitCodeRequest;
use App\Gpp\Users\Requests\VerifyEmailRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\UserResource;
use App\Mail\SendCodeVerification;
use App\Traits\UtilsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    private $userRepo;

    use UtilsTrait;

    /**
     * Constructeur
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    /**
     * Login a user
     */
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->all())) {
            $userId = Auth::id();
            $user = $this->userRepo->findUser($userId);
            
            if($user->type != $request->type) {
              throw new CredentialsException();
            }

            if (!$user->hasVerifiedEmail()) {
              $digit_code = $this->generateNumbers(6);
              $this->userRepo->updateUser([
                'digit_code' => $digit_code ,
                'digit_code_expired_at' => Carbon::now()->addSeconds(Config::get('auth.verification.expire', 600))
              ], $userId);
      
              try {
                Mail::to($user->email)->send(new SendCodeVerification([
                  'code'=>$digit_code,
                  'email'=>$user->email,
                ]));
              } catch (\Throwable $th) {
                throw new UsersSendCodeVerificationErrorException($th);
              }
      
              throw new EmailNotVerifiedException();
            }

            
            $token = $user->createToken('appToken')->accessToken;
            
            return response()->json($token,200);
        
        } else {
            throw new CredentialsException();
        }
    }

    public function me(Request $request)
    {
      $user = new UserResource($request->user());
      $company = new CompanyCollection(DB::table('companies')->where('id', $user->company_id)->get());

     
      return response()->json([
        'user'=>$user,
        'company'=>$company[0],
      ]);
    }

    /**
     * Logout Session
     */
    public function logout(Request $res)
    {
        if (Auth::user()) {
            $user = Auth::user()->token();
            $user->revoke();

            return response()->json([
                'message' => 'Déconnection réussi'
            ],200);
        } else {
            return response()->json([
                'message' => 'Déconnection impossible'
            ],400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $request['digit_code'] = $this->generateNumbers(6);
        $request['digit_code_expired_at'] = Carbon::now()->addSeconds(Config::get('auth.verification.expire', 600));

        $user = $this->userRepo->register($request->all());
        
        try {
            Mail::to($user['email'])->send(new SendCodeVerification([
                'code'=>$user['digit_code'],
                'email'=>$user['email'],
            ]));  
        } catch (\Throwable $th) {
            throw new UsersSendCodeVerificationErrorException($th);
        }
        
        return response()->json([
            'message' => 'Utilisateur enregistré avec succès',
            'userEmail'=>$user['email']
            ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        $user = $this->userRepo->saveUser($request->all());

        return response()->json([
            'message' => 'Utilisateur enregistré avec succès',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $userUpdate = $this->userRepo->updateUser($request->all(),$id);

        return response()->json(["message" => "Profile mise à jour avec succès"],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

     /**
   * Verify Email with Digit Code
   */
  public function verifyEmail(VerifyEmailRequest $request)
  {
    $user = $this->userRepo->findUserByEmail($request->email);

    if ($user->digit_code !== $request->digit_code) {
      throw new UsersDigitCodeInvalidException();
    } 
    
    $digit_code_expired =  Carbon::now()->isAfter($user->digit_code_expired_at);

    if($digit_code_expired){
      throw new UsersDigitCodeExpiredException();
    }

    $user->markEmailAsVerified();

    $this->userRepo->updateUser([
      'digit_code' => null,
      'digit_code_expired_at' => null
    ],$user->id);

    return response()->json(['message'=>"Votre compte est vérifié avec succès "],200);

  }

  public function getNewCode(SendNewDigitCodeRequest $request)
  {
    $user = $this->userRepo->findUserByEmail($request->email);
    $newCode = $this->generateNumbers(6);
    $expired =  Carbon::now()->addSeconds(Config::get('auth.verification.expire', 600));
    $userUpdate = $this->userRepo->updateUser([
      'digit_code' => $newCode,
      'digit_code_expired_at' => $expired
    ],$user->id);
    $data = [
      'code'=>$newCode,
      'lastname'=>$user->lastname,
      'firstname'=>$user->firstname,
      'email'=>$user->email,
    ];

    try {
      Mail::to($user->email)->send(new SendCodeVerification($data));

      return response()->json(['message'=>"Code de vérification envoyé."],200);
    } catch (\Throwable $th) {
      throw new UsersSendCodeVerificationErrorException($th);
    }
  }
}
