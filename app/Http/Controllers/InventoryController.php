<?php

namespace App\Http\Controllers;

use App\Models\InventoryProduct;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class InventoryController extends Controller
{
    public function index()
    {
        $products = InventoryProduct::latest()->paginate(10);

        $lowStockProducts = InventoryProduct::lowStock()->get();

        $transactions = InventoryTransaction::with([
            'inventoryProduct',
            'user',
        ])->recent()->take(10)->get();

        return view('inventory.index', compact(
            'products',
            'lowStockProducts',
            'transactions'
        ));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:inventory_products,sku',
            'category' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        InventoryProduct::create($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory product added successfully.');
    }

    public function editProduct(InventoryProduct $product)
    {
        return view('inventory.edit', compact('product'));
    }

    public function updateProduct(Request $request, InventoryProduct $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('inventory_products', 'sku')->ignore($product->id),
            ],
            'category' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory product updated successfully.');
    }

    public function destroyProduct(InventoryProduct $product)
    {
        if ($product->transactions()->exists()) {
            return redirect()->route('inventory.index')
                ->with('error', 'This product has stock transactions and cannot be deleted. Keep its transaction history.');
        }

        $product->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory product deleted successfully.');
    }

    public function storeTransaction(Request $request)
    {
        $validated = $request->validate([
            'inventory_product_id' => 'required|exists:inventory_products,id',
            'type' => 'required|in:stock_in,stock_out',
            'quantity' => 'required|integer|min:1',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        DB::transaction(function () use ($validated) {
            $product = InventoryProduct::whereKey(
                $validated['inventory_product_id']
            )->lockForUpdate()->firstOrFail();

            if (
                $validated['type'] === 'stock_out' &&
                $product->quantity < $validated['quantity']
            ) {
                throw ValidationException::withMessages([
                    'quantity' => 'Not enough stock available.',
                ]);
            }

            InventoryTransaction::create($validated);
        });

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory transaction recorded.');
    }

    public function stats()
    {
        return response()->json([
            'total_products' => InventoryProduct::count(),
            'total_stock' => InventoryProduct::sum('quantity'),
            'low_stock_count' => InventoryProduct::lowStock()->count(),
            'recent_transactions' => InventoryTransaction::count(),
        ]);
    }

    public function lowStock()
    {
        return response()->json(InventoryProduct::lowStock()->get());
    }

    public function recentTransactions()
    {
        return response()->json(
            InventoryTransaction::with('inventoryProduct')
                ->recent()
                ->take(10)
                ->get()
        );
    }
}
