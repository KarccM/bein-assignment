<?php

namespace App\Traits;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasDiscount
{
    public function discount(): MorphOne
    {
        return $this->morphOne(Discount::class, 'discountable');
    }
}