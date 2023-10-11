<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'founded_year',
        'description',
        'user_id',
    ];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function interests(): HasMany
    {
        return $this->HasMany(GroupInterest::class, 'group_id', 'id');
    }

    public function members(): HasMany
    {
        return $this->HasMany(GroupMember::class, 'group_id', 'id')->where('role_id', 3);
    }

    // Local Scopes
    public function scopeFilterName(Builder $query, ?string $name): void
    {
        if (strlen($name) > 0) {
            $query->where('name', 'like', '%'.$name.'%');
        }

    }
}
