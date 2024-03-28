<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Rules\ValidSibling;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    
    public function store(Request $request)
    {
        $this->authorize('Product.create');
        $input = $request->validate([
            'name'          => 'required',
            'price'         => 'required|numeric',
            'categoryId'    => ['required', new ValidSibling("product")],
        ]);
        Product::create([
            'name'          => $input['name'],
            'price'         => $input['price'],
            'category_id'   => $input['categoryId'],
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('Product.update');
        $input = $request->validate([ 'name' => 'required', 'price' => 'required']);
        $product->update(['name' => $input['name'], 'price' => $input['price']]);
    }

    public function destroy(Product $product)
    {
        $this->authorize('Product.delete');
        $product->delete();
    }
    
    public function createDiscount(Request $request, Product $product)
    {
        $this->authorize('Discount.create');
        $input = $request->validate(['amount' => 'required|numeric']);
        $product->discount()->create(['amount' => $input['amount']]);
    }
}
