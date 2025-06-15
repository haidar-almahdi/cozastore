<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'gender',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Get the user's active cart.
     */
    public function activeCart()
    {
        return $this->hasOne(Cart::class)->where('status', 'active');
    }

    /**
     * Get all carts belonging to the user.
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the user's favorite products.
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get the products that the user has favorited.
     */
    public function favoriteProducts()
    {
        return $this->belongsToMany(Product::class, 'favorites')
            ->withTimestamps();
    }

    /**
     * Check if a product is favorited by the user.
     */
    public function hasFavorited(Product $product)
    {
        return $this->favorites()->where('product_id', $product->id)->exists();
    }
}
