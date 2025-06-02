<?php

namespace App\Http\Controllers;

class errorController extends Controller
{
    public function index()
    {
        echo "<h1>La página que buscas no existe</h1>";
    }
}
