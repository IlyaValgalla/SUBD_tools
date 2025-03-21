<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $guarded = ['id'];

    public function equipment(): HasMany //название класса модели
    {
        return $this->hasMany(Equipment::class);
    }
}
