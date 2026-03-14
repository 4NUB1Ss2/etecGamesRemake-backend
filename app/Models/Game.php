<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Game extends Model
{
    /** @use HasFactory<\Database\Factories\GameFactory> */
    use HasFactory;


    protected $fillable = [
        'name',
        'description',
        'link',
        'image',
        'user_id',
        'school_id',
    ];

    protected $hidden = [
        'id'
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
