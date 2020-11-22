<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class mailController extends Controller
{
    public function send ($name)
    {
        Mail::send('mail', ['name' => $name], function ($message){
            $message->to('dimakudasov1993@gmail.com', 'Тоха')->subject('Test email');
            $message->from('dimakudasov1993@gmail.com', 'Тоха');
        });
    }
}
