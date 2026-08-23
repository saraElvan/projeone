<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'notes',
        'status',
        'priority',
        'due_date',
        'user_id',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    // Durum Filtreleme Filtresi (Scope)
    public function scopeStatus($query, ?string $status)
    {
        if ($status && in_array($status, ['pending', 'done'], true)) {
            $query->where('status', $status);
        }

        return $query;
    }

    // Arama Filtresi (Scope)
    public function scopeSearch($query, ?string $term)
    {
        if ($term) {
            $term = trim($term);

            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%")
                  ->orWhere('notes', 'like', "%{$term}%");
            });
        }

        return $query;
    }
}