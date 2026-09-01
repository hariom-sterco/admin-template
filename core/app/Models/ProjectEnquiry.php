<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProjectEnquiry extends Model
{
    protected $fillable = [
        'full_name',
        'company_name',
        'business_email',
        'contact_number',
        'project_requirement',
        'project_location',
        'message',
        'ip_address',
    ];

    public function scopeFilter(Builder $query, array $filters): void
    {
        if (!empty($filters['search'])) {
            $query->where(function (Builder $query) use ($filters) {
                $search = $filters['search'];

                $query->where('full_name', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('business_email', 'like', "%{$search}%");
            });
        }
    }
}
