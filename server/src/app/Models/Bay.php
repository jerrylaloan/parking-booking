<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bay extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'available',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
