<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

class User extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'username',
        'email',
        'image',
        'password',
        'name',
        'role',
        'school_id',
        'banned',
    ];
    protected $hidden = [
        'id',
        'password',
        'created_at',
        'updated_at',


    ];

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Storage::disk('supabase')->url($value) : null,
        );

    }


    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function game()
    {
        return $this->hasMany(Game::class, 'user_id');
    }
}
