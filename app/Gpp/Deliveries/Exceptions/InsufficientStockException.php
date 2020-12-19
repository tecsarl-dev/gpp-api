<?php
namespace App\Gpp\Deliveries\Exceptions;

use Exception;

class InsufficientStockException extends Exception
{
    public $message;
    public function __construct($message)
    {
        $this->message = $message;
    }
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

        $response = ['message'=> $this->message];
        return response()->json($response,422);
    }
}
