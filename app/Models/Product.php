<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
class Product extends Model
{
    use HasTranslations;
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'user_id',
        'category_id',
        'store_id',
        'availability',
        'stock',
        'status',
        'available_by'
    ];
    public $translatable = ['name','description','availability'];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductRatings::class);
    }
}
