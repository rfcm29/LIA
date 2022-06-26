<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Atributo extends Model
{
    
    protected $guarded = [
        'id'
    ];
    



    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function kit()
    {
        return $this->belongTo(Kit::Class);
    }

}
