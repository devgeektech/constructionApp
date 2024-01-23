<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'image',
        'description'
    ];

    public $translatable = ['name','description'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function setImage($imageName)
    {
        $this->attributes['image'] = $imageName;
    }
}
