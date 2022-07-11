<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $fillable = [
        'description',
        'ipvc_ref',
        'model',
        'serial_number',
        'kit_id'
    ];

    /**
     * Get the kit that owns the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kit(): BelongsTo
    {
        return $this->belongsTo(Kit::class);
    }
}
