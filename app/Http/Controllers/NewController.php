<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class NewController extends Controller
{
    public function showList() {

        $products = Product::with('company')->get();
        return view('list', ['products' => $products]);
    }

    public function login(Request $request) {

        if (auth()->check()) {
            // ユーザーがログイン状態であればリダイレクトしない
            return redirect()->route('home');
        } else {
            // ユーザーがログインしていない場合はログインフォームにリダイレクトする
            return redirect()->route('login.form');
        }
    }

    public function showAdd() {

        return view('add');
    }

    public function showDetail($id) {

        $product = Product::with('company')->findOrFail($id);
        return view('detail', compact('product'));
    }

    public function showEdit($id) {

        $product = Product::find($id);
        return view('edit', compact('product'));
    }

    public function update(Request $request, $id) {

        $product = Product::find($id);

        $product->product_name = $request->input('name');
        $product->company_id = $request->input('company_id');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->comment = $request->input('comment');

        $product->save();

        return redirect()->route('detail', ['id' => $product->id]);
    }

    public function show($id) {

        $product = Product::with('company')->find($id);
        return view('detail', compact('product'));
    }

    public function store(Request $request) {

        $product = new Product;

        $product->product_name = $request->input('product-name');
        $companyName = $request->input('manufacturer');
        $company = Company::firstOrCreate(['company_name' => $companyName]);
        $product->company_id = $company->id;
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->comment = $request->input('comment');

        $companyName = $request->input('manufacturer');
        $company = Company::firstOrNew(['company_name' => $companyName]);
        $company->representive_name = $request->input('representive_name');
        $company->save();

        if ($request->hasFile('product-image')) {
            $image = $request->file('product-image');
            $imagePath = $image->store('public/images');

            $imagePath = str_replace('public/', '', $imagePath);
            $product->img_path = $imagePath;

            $image->storeAs('public/images', $imagePath);
        }
    

        $product->save();

        $sale = new Sale;
        $sale->product_id = $product->id;
        $sale->save();

        return redirect()->back();
    }
    
    

    public function destroy($id) {

        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return redirect()->route('list')->with('success', 'Product deleted successfully.');
        }

        return redirect()->route('list')->with('error', 'Failed to delete the product.');
    }
    

}

