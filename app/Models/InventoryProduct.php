<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class InventoryProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'category',
        'quantity',
        'reorder_level',
        'unit_price',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'reorder_level' => 'integer',
            'unit_price' => 'decimal:2',
        ];
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function scopeLowStock(Builder $query): Builder
    {
        return $query->whereColumn(
            'quantity',
            '<=',
            'reorder_level'
        );
    }
}
