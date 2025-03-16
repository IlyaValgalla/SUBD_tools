<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;


class Rental extends Model
{
    use HasFactory;
    protected $table = "rentals";

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'tool_id', 'user_id', 'start_date', 'end_date', 'planned_cost', 'actual_amount', 'quantity'
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class, 'tool_id');
    }

}





