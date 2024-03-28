<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Discount extends Model
{
    protected $fillable =['amount'];

    public function discountable(): MorphTo
    {
        return $this->morphTo();
    }
}
