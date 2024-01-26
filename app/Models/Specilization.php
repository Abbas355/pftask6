<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specilization extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'sport_id',
        'name',
        'description',
    ];


    // Relationships
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
}
