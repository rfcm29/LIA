<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class time extends Model
{
    protected $guarded = [];

    protected $primaryKey = "id";

    public $incrementing = false; 

    public $timestamps = false;


    public static function fetchByItem($id){
        $result =DB::table('times')
        ->where('times.idItem','=',$id)
        ->get();

        return $result;
    }

    public static function fetchByKit($id){
        $result =DB::table('times')
        ->where('times.idKit','=',$id)
        ->get();

        return $result;
    }


}
