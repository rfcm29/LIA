<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reserve extends Model
{
    

    protected $fillable = [
        'description',
        'user_id',
        'cost_center_id',
        'start_date',
        'end_date',
        'cost',
        'reserve_state_id'
    ];

    /**
     * Get the cost_center that owns the Reserve
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function costCenter(): BelongsTo
    {
        return $this->belongsTo(CostCenter::class);
    }

    /**
     * Get all of the kits for the Reserve
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kits(): BelongsToMany
    {
        return $this->belongsToMany(Kit::class);
    }

    /**
     * Get the user that owns the Reserve
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reserveState that owns the Reserve
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reserveState(): BelongsTo
    {
        return $this->belongsTo(ReserveState::class);
    }
}
