<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'club_name',
        'address',
        'established_date',
        'website',
        'contact_email',
        'phone_number',
        'sport_id',
        'description',
        'no_of_players',
        'no_of_coaches',
        'club_img', // Add this line
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
    public function licences()
    {
        return $this->hasMany(Licence::class);
    }
    public function awards()
    {
        return $this->hasMany(Award::class);
    }
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
