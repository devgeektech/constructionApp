<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ProductRatings;
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product_rating = ProductRatings::where('product_id',$this->id)->count();
        $averageRating = ProductRatings::where('product_id', $this->id)
        ->avg('reviews');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => getProductImages($this->id),
            'user_id' => getRole($this->user_id)->name,
            'category_id' => getCategoryName($this->category_id)->name,
            'store_id' => getStoreName($this->store_id)->name,
            'availability' => $this->availability,
            'stock' => $this->stock,
            'is_contribution' => $this->is_contribution,
            'total_ratings' => $product_rating,
            'avg_ratings' => $averageRating,
        ];
    }
}
