<?php

namespace App\Gpp\Users\Exceptions;

use Exception;

class EmailNotVerifiedException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report()
    {
        // 
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request)
    {
        $response = [
            'message'=> "Veuillez confirmer votre adresse email pour continuer",
            "userEmail"=>$request->email
        ];
        return response()->json($response,401);
    }
}
