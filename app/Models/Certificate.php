<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'certificate_img',
        'club_id',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
