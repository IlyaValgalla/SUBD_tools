<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Rental extends Model
{
    use HasFactory;
    protected $table = "rentals";
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function equipment(): BelongsTo ////название класса модели
    {
        return $this->belongsTo(Equipment::class, 'tool_id');
    }

}
