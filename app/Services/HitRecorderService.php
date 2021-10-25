<?php

namespace App\Services;

use App\Models\Hit;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;


class HitRecorderService
{
    public static function record(){
       DB::beginTransaction();
       try{
           $hit = Hit::whereId(1)->lockForUpdate()->first();
           $hit->hits = ++$hit->hits;
           $hit->save();
           DB::commit();
           return true;
       }catch (QueryException $e){
           DB::rollBack();
           return false;
       }
    }


}
