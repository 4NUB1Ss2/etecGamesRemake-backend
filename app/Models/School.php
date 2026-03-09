<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    /** @use HasFactory<\Database\Factories\SchoolFactory> */
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'address',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function game()
    {
        return $this->hasMany(Game::class);
    }
}
