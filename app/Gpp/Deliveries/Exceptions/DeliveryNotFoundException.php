<?php

namespace App\Gpp\Deliveries\Exceptions;

use Exception;

class DeliveryNotFoundException extends Exception
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
        $response = ['message'=> "Cette livraison est introuvable"];
        return response()->json($response,422);
    }
}
