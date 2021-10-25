<?php

namespace App\Http\Controllers;

use App\Models\Hit;

class HitsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getHits(){
        return Hit::all();
    }

}
