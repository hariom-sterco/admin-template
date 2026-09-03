<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Redirection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'old_url',
        'new_url',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
