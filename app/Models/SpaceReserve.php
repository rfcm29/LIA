<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SpaceReserve extends Model
{
    protected $fillable = [
        'description',
        'start_date',
        'end_date',
        'cost',
        'occupant_id'
    ];

    /**
     * The liaSpace that belong to the SpaceReserve
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function liaSpace(): BelongsToMany
    {
        return $this->belongsToMany(LiaSpace::class);
    }

    /**
     * The users that belong to the SpaceReserve
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
