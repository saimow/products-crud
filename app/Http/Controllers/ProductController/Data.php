<?php

namespace App\Http\Controllers\ProductController;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class Data extends Controller
{
    public function getData(){
        $products = Product::query();

        return DataTables::of($products)
            ->editColumn('name', function(Product $product) {
                return substr($product->name, 0, 50) . '...';
            })
            ->editColumn('created_at', function(Product $product) {
                return $product->created_at->format('d-m-Y H:i:s');
            })
            ->editColumn('thumbnail', function ($row) {
                if($row->thumbnail){
                    return "<img src='/storage/products/media/$row->thumbnail' class='datatable-thumbnail border border-secondary'>";
                }else{
                    return "<img src='/imgs/no_image.png' class='datatable-thumbnail border border-secondary'>";
                }
            })
            ->editColumn('price', function(Product $product) {
                return '$'. number_format($product->price, 2);
            })
            ->addColumn('actions', function ($row) {
                $html = "<div class='d-inline-flex'>";
                $html .= "<a href=".route('products.show', $row->slug)." class='btn btn-outline-secondary btn-sm me-1'><i class='bi bi-eye-fill'></i></i></a>";
                $html .= "<a href=".route('products.update', $row->id)." class='btn btn-outline-success btn-sm me-1'><i class='bi bi-pencil-fill'></i></a>";
                $html .= "<button data-id='".$row->id."' type='button' class='btn btn-outline-danger btn-sm delete-confirmation' data-bs-toggle='modal' data-bs-target='#delete-confirmation'><i class='bi bi-trash-fill'></i></button>";
                $html .= "</div>";
                return $html;
            })
            ->rawColumns(['thumbnail', 'actions'])
            ->toJson();
    }

    public function getProduct(Product $product){
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

        return ['details'=>$details, 'media'=>$media, 'options'=>$options, 'variants'=>$skus];
    }
}
