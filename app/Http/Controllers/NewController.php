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
        return $this->getFilteredProducts($request, 'list');
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
        $product = Product::findOrFail($id);
        $companies = Company::all();
        return view('edit', compact('product', 'companies'));
    }

    public function update(Request $request, $id)
    {
        $this->validateProduct($request);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($id);
            $this->saveProduct($product, $request);

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
        $this->validateProduct($request);

        try {
            DB::beginTransaction();

            $product = new Product;
            $this->saveProduct($product, $request);

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

    private function validateProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'manufacturer' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'comment' => 'nullable',
        ]);
    }

    private function saveProduct($product, Request $request)
    {
        $product->product_name = $request->input('name');
        $company = Company::firstOrCreate(['company_name' => $request->input('manufacturer')]);
        $product->company_id = $company->id;
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->comment = $request->input('comment');
        $product->save();
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $product = Product::findOrFail($id);
            $product->delete();

            DB::commit();

            return response()->json(['success' => true]);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Error deleting product: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete the product due to a database error.'], 500);
        }
    }

    public function search(Request $request)
    {
        return $this->getFilteredProducts($request, 'table');
    }

    private function getFilteredProducts(Request $request, $view)
    {
        $products = $this->buildQuery($request)->get();
        $companies = Company::all();

        return view($view, compact('products', 'companies'));
    }

    private function buildQuery(Request $request)
    {
    $query = Product::with('company');

    $keyword = $request->input('keyword');
    $manufacturerId = $request->input('manufacturer');
    $minPrice = $request->input('minPrice');
    $maxPrice = $request->input('maxPrice');
    $minStock = $request->input('minStock');
    $maxStock = $request->input('maxStock');
    $sortColumn = $request->input('sort', 'id');
    $sortOrder = $request->input('order', 'asc');

    // キーワードに基づく商品名のフィルタリング
    if ($keyword) {
        $query->where('product_name', 'like', '%' . $keyword . '%');
    }

    // 製造業者IDに基づくフィルタリング
    if ($manufacturerId) {
        $query->where('company_id', $manufacturerId);
    }

    // 最小価格と最大価格に基づくフィルタリング
    if ($minPrice) {
        $query->where('price', '>=', $minPrice);
    }
    if ($maxPrice) {
        $query->where('price', '<=', $maxPrice);
    }

    // 在庫数の最小値と最大値に基づくフィルタリング
    if ($minStock) {
        $query->where('stock', '>=', $minStock);
    }
    if ($maxStock) {
        $query->where('stock', '<=', $maxStock);
    }

    // ソート順序の適用
    $query->orderBy($sortColumn, $sortOrder);

    return $query;
    }

    public function fetchFilteredProducts(Request $request)
{
    // 商品のフィルタリング条件に基づいてデータベースから商品を取得する
    $products = $this->buildQuery($request)->get();

    // JSONとしてレスポンスを返す
    return response()->json(['products' => $products]);
}

}
