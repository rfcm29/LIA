<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpaceItem extends Model
{
    protected $fillable =  [
        'lia_space_id',
        'description'
    ];

    /**
     * Get the liaSpace that owns the SpaceItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function liaSpace(): BelongsTo
    {
        return $this->belongsTo(LiaSpace::class);
    }
}
