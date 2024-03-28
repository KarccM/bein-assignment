<?php

namespace App\Rules;

use App\Models\Category;
use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidSibling implements ValidationRule
{
    public string $type;
    
    public function __construct(string $type){
        $this->type = $type;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!$this->type) $fail("enter the type");

        if($this->type === "category") {
            $product = Product::where('category_id', $value)->first();
            if($product) $fail('u cant add this sub-category because this category has already products');
            return;
        }
        
        if($this->type === "product") {
            $category = Category::where('parent_id', $value)->first();
            if($category) $fail('u cant add this product because this category has already sub-categories');
            return;
        }

        $fail("invaild type");
    }
}
