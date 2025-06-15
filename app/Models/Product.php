<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'sizes',
        'colors',
        'image',
        'additional_images',
        'is_featured',
        'is_active',
        'category_id'
    ];

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
        'additional_images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the cart items for this product.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the carts that contain this product.
     */
    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_items')
            ->withPivot(['quantity', 'price', 'size', 'color'])
            ->withTimestamps();
    }

    /**
     * Get the favorites for this product.
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get the users who have favorited this product.
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withTimestamps();
    }

    // Accessor for image URL
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/no-image.png');
    }

    // Accessor for additional images URLs
    public function getAdditionalImagesUrlsAttribute()
    {
        if ($this->additional_images) {
            return collect($this->additional_images)->map(function ($image) {
                return asset('storage/' . $image);
            });
        }
        return collect();
    }

    /**
     * Check if the product is favorited by a user.
     *
     * @param \App\Models\User|null $user
     * @return bool
     */
    public function isFavoritedBy($user)
    {
        if (!$user) {
            return false;
        }
        return $user->hasFavorited($this);
    }
}
