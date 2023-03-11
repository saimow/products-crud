<?php

namespace App\Http\Controllers\ProductController;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class Show extends Controller
{
    public function index($slug){
        $product = Product::where('slug', $slug)->first();
        
        return view('products.show',['id' => $product->id]);
    }

    public function getData($slug){
        $product = Product::where('slug', $slug)->first();

        $details = $product->toArray();
        $media = $product->images()->get()->toArray();

        $options = $product->options()->get();
        foreach($options as $key => $option){
            $option_values = $option->option_values()->get();
            $option['values'] = $option_values;
        }

        $option_values = $product->option_values()->get()->toArray();
        $skus = $product->skus()->get()->toArray();
        $sku_values = $product->sku_values()->get()->toArray();

        foreach($skus as $key => $sku){
            $sku['options'] = [];
            
            foreach($sku_values as $sku_value){
                if($sku_value['sku_id'] == $sku['id']){
                    $option_name = '';
                    $option_value_name = '';
                    foreach($options as $option){
                        if($option['id'] == $sku_value['option_id']){
                            $option_name = $option['name'];
                            break;
                        }
                    }
                    foreach($option_values as $option_value){
                        if($option_value['id'] == $sku_value['option_value_id']){
                            $option_value_name = $option_value['name'];
                            $skus[$key]['options'][] = ['name' => $option_name, 'value' => $option_value_name];
                            break;
                        }
                    }
                }
            }
        }

        return response()->json(['details'=>$details, 'media'=>$media, 'options'=>$options, 'variants'=>$skus], 200);
    }
}
