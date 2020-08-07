<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\CredentialsSent;
use Illuminate\Support\Facades\Mail;

class CredentialsController extends Controller
{
    /**
     * Ship the given order.
     *
     * @param  Request  $request
     * @param  int  $orderId
     * @return Response
     */
    public function send()
    {
        // Ship order...

        Mail::to('n.pro-zema@mail.ru')->send(new CredentialsSent);
    }
}
