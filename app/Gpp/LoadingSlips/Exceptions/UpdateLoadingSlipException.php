<?php

namespace App\Gpp\Users\Exceptions;

use Exception;

class UpdateLoadingSlipException extends Exception
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
        return response()->json(['message'=> "Impossible de mettre à jour le bon de chargement"],422);
    }
}
