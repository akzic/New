<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Product extends Model
{
    

    public function getList() {

        $products = DB::table('products')->get();

        return $products;
    }

    public function company() {

        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }

    public function sales() {

        return $this->hasMany('App\Models\Sale', 'product_id', 'id');
    }

    protected $fillable = [
        'product_name',
        'company_id',
        'price',
        'stock',
        'comment',
        'img_path',
    ];

    public function store(Request $request) {

        $product = new Product;

        $product->product_name = $request->input('product-name');
        $product->company_id = $request->input('manufacturer');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->comment = $request->input('comment');


        $product->save();

        return redirect()->back();
        
    }
}
