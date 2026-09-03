<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    public function scopeFilter(Builder $query, $filters)
    {
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('old_url', 'like', "%{$filters['search']}%")
                  ->orWhere('new_url', 'like', "%{$filters['search']}%");
            });
        }

        return $query;
    }
}
