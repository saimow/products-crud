<?php

namespace App\Http\Controllers\ProductController;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Delete extends Controller
{
    public function destroy(Product $product){
        $media = $product->images()->get();
        foreach($media as $image){
            File::delete(storage_path('app/public/products/media/'.$image['name']));
            $product->images()->where('name', $image['name'])->delete();
        }
        
        $product->delete();
        return response()->json(['success' => true], 200);
    }
}
