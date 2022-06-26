<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    use Searchable;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'grupo_id', 'numero_mecanografico', 'numero_telemovel'
    ];

    public function searchableAs()
    {
        return "user";
    }



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function grupos()
    {
        return $this->hasOne(Grupo::class, "id");
    }

    public static function findAll()
    {
        return DB::table('users')
            ->join('grupos', 'users.grupo_id', "=", "grupos.id")
            ->where("grupos.admin", "<>", 1)
            ->select("users.*")
            ->get();
    }

    public static function countUsers($id)
    {
        $users = DB::table('users')
            ->where('users.grupo_id', '=', $id)
            ->select("users.*")
            ->get();

        return $users->count();
    }


    public static function GestoresDeReservas()
    {
        $grupos = DB::table('grupos')
            ->where('grupos.gerirReservas', '=', true)
            ->get();
        $users = [];
        foreach ($grupos as $value) {
            $users[] = DB::table('users')
                ->where('users.grupo_id', '=', $value->id)
                ->get();
        }


        return $users;
    }

    public function generateToken()
    {
        $this->api_token = Str::random(60);
        $this->save();

        return $this->api_token;
    }

    public function getToken()
    {
        return $this->api_token;
    }
}
