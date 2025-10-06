<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function categories() { return $this->belongsToMany(Category::class); }
    public function images() { return $this->hasMany(ProductImage::class)->orderBy('display_order'); }
    public function stock() { return $this->hasOne(Stock::class); }
    public function wishlistItems() { return $this->hasMany(Wishlist::class); }
    

}