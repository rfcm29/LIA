<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class grupo extends Model
{
    use Searchable;
    public function searchableAs()
    {
        return "grupos";
    }
    protected $guarded = [
        'id'
    ];
    public $timestamps = false;
    protected $fillable = [
        "name",
        "gerirReservas",
        "gerirItemsKits",
        "gerirGrupos",
        "gerirCategorias",
        "gerirCentros",
        "gerirUsers",
        'admin',
        "reservar"

    ];
    public function users()
    {
        return $this->hasMany(User::class, "id_user");
    }
}
