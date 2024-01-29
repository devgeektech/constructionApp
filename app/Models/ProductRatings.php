<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRatings extends Model
{
    protected $fillable = [
		'user_id',
		'product_id',
		'reviews',
        'add_info'
	];

	public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
