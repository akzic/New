<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;

class NewController extends Controller
{
    public function showList(Request $request)
    {
        $keyword = $request->input('keyword');
        $manufacturerId = $request->input('manufacturer');
        $minPrice = $request->input('minPrice');
        $maxPrice = $request->input('maxPrice');
        $minStock = $request->input('minStock');
        $maxStock = $request->input('maxStock');
        $sortColumn = $request->input('sort', 'id');
        $sortOrder = $request->input('order', 'desc');

        $query = Product::with('company');

        // Apply filters
        if ($keyword) {
            $query->where('product_name', 'like', '%' . $keyword . '%');
        }
        if ($manufacturerId) {
            $query->where('company_id', $manufacturerId);
        }
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }
        if ($minStock) {
            $query->where('stock', '>=', $minStock);
        }
        if ($maxStock) {
            $query->where('stock', '<=', $maxStock);
        }

        $query->orderBy($sortColumn, $sortOrder);

        // Get the products
        $products = $query->get();
        $companies = Company::all();

        // Render the product list view
        return view('list', compact('products', 'companies'));
    }

    public function showAdd()
    {
        $companies = Company::all();
        return view('add', compact('companies'));
    }

    public function showDetail($id)
    {
        $product = Product::with('company')->findOrFail($id);
        return view('detail', compact('product'));
    }

    public function showEdit($id)
    {
        $product = Product::find($id);
        $companies = Company::all(); 

        return view('edit', compact('product', 'companies'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'manufacturer' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'comment' => 'nullable',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::find($id);
            $product->product_name = $request->input('name');
            $company = Company::firstOrCreate(['company_name' => $request->input('manufacturer')]);
            $product->company_id = $company->id;
            $product->price = $request->input('price');
            $product->stock = $request->input('stock');
            $product->comment = $request->input('comment');
            $product->save();

            DB::commit();

            return redirect()->route('detail', ['id' => $product->id]);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Error updating product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update the product.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'product-name' => 'required',
            'manufacturer' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'comment' => 'nullable',
        ]);

        try {
            DB::beginTransaction();

            $product = new Product;
            $product->product_name = $request->input('product-name');
            $companyName = $request->input('manufacturer');
            $company = Company::firstOrCreate(['company_name' => $companyName]);
            $product->company_id = $company->id;
            $product->price = $request->input('price');
            $product->stock = $request->input('stock');
            $product->comment = $request->input('comment');

            if ($request->hasFile('product-image')) {
                $image = $request->file('product-image');
                $imagePath = $image->store('public/images');
                $imagePath = str_replace('public/', '', $imagePath);
                $product->img_path = $imagePath;
            }

            $product->save();

            $sale = new Sale;
            $sale->product_id = $product->id;
            $sale->save();

            DB::commit();

            return redirect()->back();
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Error storing product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to store the product.');
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $product = Product::find($id);

            if ($product) {
                $product->delete();
                DB::commit();
                return redirect()->route('list')->with('success', 'Product deleted successfully.');
            }

            DB::rollBack();
            return redirect()->route('list')->with('error', 'Failed to delete the product.');
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Error deleting product: ' . $e->getMessage());
            return redirect()->route('list')->with('error', 'Failed to delete the product.');
        }
    }

}
