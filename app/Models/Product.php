<?php

namespace App\Models;

use App\Http\Resources\DiscountResource;
use App\Traits\HasDiscount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasDiscount;
    
    protected $fillable = ['name', 'category_id', 'price'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getDiscount()
    {
        $discount = $this->discount()->first();
        if($discount)
            return new DiscountResource($discount);
        
        $category = Category::find($this->category_id);
        return $category->getDiscount();
    }
}