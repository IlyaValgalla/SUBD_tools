<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class User extends Authenticatable
{

   /* use HasFactory;
    protected $table = "users";
    public function rental(): HasMany
    {
        return $this->hasMany(Rental::class);
    }*/

    use HasFactory;
    protected $table = "users";

    public function equipments(): BelongsToMany
    {
        //return $this->belongsToMany(equipment::class,'rentals','user_id', 'tool_id');
        return $this->belongsToMany(equipment::class,'rentals','user_id', 'tool_id')
        ->withPivot(['actual_amount']);

    }


/** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
       'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
           'password' => 'hashed',
        ];
    }
}

