<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;
    protected $fillable = [
        'coach_id',
        'role',
        'club_name',
        'start_date',
        'end_date',
        'description',
        'experience_letter_img'
    ];

    // Relationships
    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
