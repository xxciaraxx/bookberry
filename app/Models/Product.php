<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'price',
        'image_path',
        'rating',
        'stock',
        'is_active',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'rating'    => 'decimal:2',
        'stock'     => 'integer',
        'is_active' => 'boolean',
    ];

    public function getImageUrlAttribute(): string
    {
        if ($this->image_path && \Storage::disk('public')->exists($this->image_path)) {
            return asset('storage/' . $this->image_path);
        }
        return 'https://placehold.co/300x420/5A2A6E/CBA0D9?text=' . urlencode($this->title);
    }

    public function getIsInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    public function getStockStatusAttribute(): string
    {
        return match(true) {
            $this->stock === 0      => 'Out of Stock',
            $this->stock <= 3       => 'Last items in stock',
            $this->stock <= 10      => 'Low stock',
            default                 => 'In Stock',
        };
    }

    public function getStockStatusColorAttribute(): string
    {
        return match(true) {
            $this->stock === 0  => '#EF4444',
            $this->stock <= 3   => '#F97316',
            $this->stock <= 10  => '#EAB308',
            default             => '#16A34A',
        };
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}