<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{

    protected $fillable = [
        'user_id',
		'name',
		'owner',
		'address',
        'latitude',
        'longitude',
        'logo',
        'banner',
        'phone',
        'social_links'
	];
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    
    public function banner()
    {
        return $this->hasMany(Banner::class);
    }
    
}
