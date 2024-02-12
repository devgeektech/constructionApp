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
            'min_price' => $this->min_price,
            'max_price' => $this->price,
            'image' => getProductImages($this->id),
            'user_id' => $this->user_id,
            'user_name' => getRole($this->user_id)->name,
            'category_id' => $this->category_id,
            'category_name' => getCategoryName($this->category_id)->name,
            'store_id' => $this->store_id,
            'store_name' => getStoreName($this->store_id)->name,
            'store_address' => getStoreAddress($this->store_id)->address,
            'availability' => $this->availability,
            'stock' => $this->stock,
            'is_contribution' => $this->is_contribution,
            'total_ratings' => $product_rating,
            'avg_ratings' => $averageRating,
            'wishlist' => is_wishlist(auth('sanctum')->user()->id,$this->id),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at

        ];
    }
}
