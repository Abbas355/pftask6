<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
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
        'specilization_id',
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
    public function specilization()
    {
        return $this->belongsTo(Specilization::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }
    public function licences()
    {
        return $this->hasMany(Licence::class);
    }
    public function awards()
    {
        return $this->hasMany(Award::class);
    }


}
