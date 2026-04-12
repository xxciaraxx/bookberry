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
        'is_active',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'rating'    => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function getImageUrlAttribute(): string
    {
        if ($this->image_path && \Storage::disk('public')->exists($this->image_path)) {
            return asset('storage/' . $this->image_path);
        }

        // Return a placeholder based on category
        return 'https://placehold.co/300x420/5A2A6E/CBA0D9?text=' . urlencode($this->title);
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

    public function scopeWattpad($query)
    {
        return $query->where('category', 'wattpad');
    }

    public function scopeManga($query)
    {
        return $query->where('category', 'manga');
    }
}
