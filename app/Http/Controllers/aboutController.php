<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class aboutController extends Controller
{
    /**
     * Return the about view.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('.about.index');
    }
}
