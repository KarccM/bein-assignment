<?php

namespace App\Models;

use App\Http\Resources\DiscountResource;
use App\Traits\HasDiscount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use XiDanko\QueryFilter\HasFilter;

class Category extends Model
{
    use HasFilter, HasDiscount;
    
    protected static function booted(): void
    {
        static::deleted(function (Category $category) {
            $products = Product::where('category_id', $category->id)->get();
            $products->each->delete();
            
            $categories = Category::where('parent_id', $category->id)->get();
            $categories->each->delete();
        });
    }

    protected $fillable = ['name', 'parent_id'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getDiscount()
    {
        $discount = $this->discount()->first();

        if($discount)
            return new DiscountResource($discount);

        if(!$this->parent_id)
            return;
        
        return $this->getInheritedDisount($this->parent_id);
    }

    private function getInheritedDisount($categoryId)
    {
        $category = Category::find($categoryId);

        if(!$category)
            return;
        
        $discount = $category->discount()->first();
        if($discount)
            return new DiscountResource($discount);

        $discount = $this->getInheritedDisount($category->parent_id);
        if($discount)
            return new DiscountResource($discount);
    }

    public static function buildTree($categories)
    {
        $tree = collect([]);
        $categories->each(function($category) use($tree) {
            if(!$category->parent_id) {
                $category["children"] = collect([]);
                $tree->push($category);
            }

            else {
                foreach($tree as $node) {
                    if($node->id === $category->parent_id) {
                        if($node["children"]) $node->children->push($category);
                        
                        else {
                            $node["children"] = collect([]);
                            $node->children->push($category);
                        }
                        break;
                    }
                    if($node->children) self::findParent($category, $node->children);
                }
            }
        });

        return $tree;
    }

    private static function findParent($category, $tree)
    {
        return $tree?->each(function ($node) use($category) {
            
            if($node->id === $category->parent_id) {
                if($node["children"])
                    $node->children->push($category);
                
                else {
                    $node["children"] = collect([]);
                    $node->children->push($category);
                }
            }
            self::findParent($category, $node->children);
        });
    }
}