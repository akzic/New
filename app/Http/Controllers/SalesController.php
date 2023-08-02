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

class SalesController extends Controller
{
    

    public function purchase(Request $request)
    {
        $productId = $request->get('product_id');
        $quantity = $request->get('quantity');

        // Start transaction
        DB::beginTransaction();

        try {
            // Get product
            $product = Product::find($productId);

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            // Check product stock
            if ($product->stock < $quantity) {
                return response()->json(['error' => 'Not enough stock for this product'], 400);
            }

            // Decrease product stock
            $product->stock -= $quantity;
            $product->save();

            // Create new sale record
            $sale = new Sale();
            $sale->product_id = $productId;
            $sale->quantity = $quantity;
            $sale->save();

            // Commit transaction
            DB::commit();

            return response()->json(['success' => 'Purchase completed successfully'], 200);
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();

            return response()->json(['error' => 'Purchase failed: ' . $e->getMessage()], 500);
        }
    }

}
