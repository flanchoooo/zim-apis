<?php

namespace App\Http\Controllers;

use App\Models\Hit;
use App\Services\HitRecorderService;
use MongoDB\BSON\Regex;

class ValidationsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function idCheck($id){
        $pattern = "~[0-9]{8,9}[a-z,A-Z][0-9]{2}~";
    }


    public function zimbabweNationalIdValidation($id){
        $recorder =  HitRecorderService::record();
        if(1 != $recorder)
            return response([
                'code'              => '01',
                'description'       => 'Service unavailable, please try again later',
            ],500);


        $pattern = "~[0-9]{8,9}[a-z,A-Z][0-9]{2}~";
        $result = preg_match($pattern, $id);
        if(strlen($id) > 12 )
            return response([
                'code'              => '01',
                'description'       => 'Invalid Zimbabwe National ID number. [Recommended Format: 00000000X00]',
            ],400);

        if(substr($id, 0, 2) > 86)
            return response([
                'code'              => '02',
                'description'       => 'Invalid Zimbabwe National ID number. [Recommended Format: 00000000X00]',
            ],400);

        if(substr($id, -2) > 86)
            return response([
                'code'              => '03',
                'description'       => 'Invalid Zimbabwe National ID number. [Recommended Format: 00000000X00]',
            ],400);


        if(1 != $result)
             return response([
            'code'              => '04',
            'description'       => 'Invalid Zimbabwe National ID number. [Recommended Format: 00000000X00]',
        ],400);

            else
                return response([
                    'code'              => '00',
                    'description'       => 'Valid Zimbabwe National ID number',
                ]);
    }
}
