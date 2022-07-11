<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kit extends Model
{

    protected $fillable = [
        'description',
        'lia_code',
        'ipvc_ref',
        'price',
        'kit_id',
        'kit_category_id',
        'kit_state_id'
    ];

    /**
     * Get all of the items for the Kit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Get all of the kits for the Kit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kits(): HasMany
    {
        return $this->hasMany(Kit::class);
    }

    /**
     * Get the kit that owns the Kit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kit(): BelongsTo
    {
        return $this->belongsTo(Kit::class);
    }

    /**
     * Get the kit_state that owns the Kit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kitState(): BelongsTo
    {
        return $this->belongsTo(KitState::class);
    }

    /**
     * Get the reserve that owns the Kit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reserves(): BelongsToMany
    {
        return $this->belongsToMany(Reserve::class);
    }

    /**
     * Get the kitCategory that owns the Kit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kitCategory(): BelongsTo
    {
        return $this->belongsTo(KitCategory::class);
    }
}
