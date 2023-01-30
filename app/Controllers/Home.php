<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        dd($_SESSION);
        // return view('welcome_message');
    }
}