<?php

namespace App\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', ['test' => "test data 1234"]);
    }
}