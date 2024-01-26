<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Licence extends Model
{
    use HasFactory;
    protected $fillable = [
        'coach_id',
        'licence_name',
        'issuing_authority',
        'issue_date',
        'expire_date',
        'licence_img',
    ];

    // Relationships
    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
