<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->search);
        $category = trim((string) $request->category);

        $inventories = Inventory::when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('product_name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->when($category !== '', function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->paginate(10)
            ->withQueryString();

        // Distinct list of categories currently in the table, for the filter dropdown
        $categories = Inventory::whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('inventory.index', compact('inventories', 'categories'));
    }

    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:150',
            'sku' => 'nullable|string|max:100',
            'category' => 'required|string|max:100',
            'quantity' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:30',
            'reorder_level' => 'nullable|integer|min:0',
            'expiry_date' => 'nullable|date',
            'price' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048', // 2MB max
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $inventory = Inventory::create([
            'product_name' => $validated['product_name'],
            'sku' => $validated['sku'] ?? null,
            'category' => $validated['category'],
            'quantity' => $validated['quantity'],
            'unit' => $validated['unit'] ?? 'pcs',
            'reorder_level' => $validated['reorder_level'] ?? 5, // default threshold
            'expiry_date' => $validated['expiry_date'] ?? null,
            'price' => $validated['price'],
            'supplier' => $validated['supplier'] ?? null,
            'image' => $imagePath,
        ]);

        // Log the starting stock so the history has a complete record from day one
        InventoryLog::create([
            'inventory_id' => $inventory->id,
            'change' => $inventory->quantity,
            'previous_quantity' => 0,
            'new_quantity' => $inventory->quantity,
            'reason' => 'Initial Stock',
            'user_name' => session('user_name'),
        ]);

        return redirect()->route('inventory.index')
                         ->with('success', 'Product added successfully.');
    }

    public function edit(Inventory $inventory)
    {
        return view('inventory.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:150',
            'sku' => 'nullable|string|max:100',
            'category' => 'required|string|max:100',
            'quantity' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:30',
            'reorder_level' => 'nullable|integer|min:0',
            'expiry_date' => 'nullable|date',
            'price' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048',
        ]);

        $previousQuantity = $inventory->quantity;

        if ($request->hasFile('image')) {
            // Remove the old image file so storage doesn't fill up with orphans
            if ($inventory->image) {
                Storage::disk('public')->delete($inventory->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $inventory->update($validated);

        // If the quantity was changed directly through this form (not the
        // quick +/- adjuster), log it too so the history stays accurate.
        if ((int) $validated['quantity'] !== (int) $previousQuantity) {
            InventoryLog::create([
                'inventory_id' => $inventory->id,
                'change' => $validated['quantity'] - $previousQuantity,
                'previous_quantity' => $previousQuantity,
                'new_quantity' => $validated['quantity'],
                'reason' => 'Manual Edit',
                'user_name' => session('user_name'),
            ]);
        }

        return redirect()
            ->route('inventory.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Inventory $inventory)
    {
        // NOTE: image is intentionally NOT deleted here -- delete() is now
        // a soft delete (archive), so the product may still be restored.
        // The image file is only removed on permanent deletion from Archive.
        $inventory->delete();

        return redirect()
            ->route('inventory.index')
            ->with('success', 'Product moved to Archive.');
    }

    /**
     * Quick stock in/out adjustment -- used by the +/- modal on the index page.
     */
    public function adjustStock(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'direction' => 'required|in:in,out',
            'amount' => 'required|integer|min:1',
            'reason' => 'required|string|max:100',
        ]);

        $previousQuantity = $inventory->quantity;
        $change = $validated['direction'] === 'in' ? $validated['amount'] : -$validated['amount'];
        $newQuantity = max(0, $previousQuantity + $change);

        $inventory->update(['quantity' => $newQuantity]);

        InventoryLog::create([
            'inventory_id' => $inventory->id,
            'change' => $newQuantity - $previousQuantity,
            'previous_quantity' => $previousQuantity,
            'new_quantity' => $newQuantity,
            'reason' => $validated['reason'],
            'user_name' => session('user_name'),
        ]);

        return back()->with('success', "Stock updated for {$inventory->product_name}.");
    }

    /**
     * Stock In/Out history -- optionally filtered to one product.
     */
    public function stockHistory(Request $request)
    {
        $inventoryId = $request->query('inventory_id');

        $logs = InventoryLog::with('inventory')
            ->when($inventoryId, fn ($q) => $q->where('inventory_id', $inventoryId))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $product = $inventoryId ? Inventory::find($inventoryId) : null;

        return view('inventory.history', compact('logs', 'product'));
    }

    /**
     * Export the full inventory list as a CSV file.
     */
    public function exportCsv(): StreamedResponse
    {
        $filename = 'inventory-export-' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['SKU', 'Product Name', 'Category', 'Quantity', 'Unit', 'Reorder Level', 'Expiry Date', 'Price', 'Supplier']);

            Inventory::orderBy('product_name')->chunk(200, function ($chunk) use ($handle) {
                foreach ($chunk as $item) {
                    fputcsv($handle, [
                        $item->sku,
                        $item->product_name,
                        $item->category,
                        $item->quantity,
                        $item->unit,
                        $item->reorder_level,
                        $item->expiry_date?->format('Y-m-d'),
                        $item->price,
                        $item->supplier,
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}