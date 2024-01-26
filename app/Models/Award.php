<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;
    protected $fillable = [
        'coach_id',
        'award_title',
        'award_img',
    ];

    // Relationships
    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
