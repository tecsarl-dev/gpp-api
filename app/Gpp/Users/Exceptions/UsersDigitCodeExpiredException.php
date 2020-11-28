<?php

namespace App\Gpp\Users\Exceptions;

use Exception;

class UsersDigitCodeExpiredException extends Exception
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
        return response()->json(['message'=> "Ce code a expiré. Cliquez sur RENVOYER LE CODE pour en obtenir un nouveau."],422);
    }
}
