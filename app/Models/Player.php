<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'sport_id',
        'jersey_number',
        'position_id',
        'height',
        'weight'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }
    public function skills()
    {
        return $this->hasMany(Skill::class);
    }
    public function injuries()
    {
        return $this->hasMany(Injury::class);
    }
    
}
