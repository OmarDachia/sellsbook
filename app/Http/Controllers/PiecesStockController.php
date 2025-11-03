<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PiecesStock;

class PiecesStockController extends Controller
{
    public function index()
    {
        $piecesStocks = PiecesStock::orderBy('item_name')->paginate(10);
        return view('pieces-stocks.index', compact('piecesStocks'));
    }

    public function create()
    {
        return view('pieces-stocks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:191',
            'size' => 'nullable|string|max:60',
            'no_of_ctn' => 'required|integer|min:0',
            'qty_by_ctn' => 'required|integer|min:1',
            'cost_price_by_ctn' => 'required|numeric|min:0',
            'selling_price_per_piece' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Calculations will be handled by the model automatically
        PiecesStock::create($request->all());

        return redirect()->route('pieces-stocks.index')
            ->with('success', 'Pieces stock record created successfully.');
    }

    public function show(PiecesStock $piecesStock)
    {
        return view('pieces-stocks.show', compact('piecesStock'));
    }

    public function edit(PiecesStock $piecesStock)
    {
        return view('pieces-stocks.edit', compact('piecesStock'));
    }

    public function update(Request $request, PiecesStock $piecesStock)
    {
        $request->validate([
            'item_name' => 'required|string|max:191',
            'size' => 'nullable|string|max:60',
            'no_of_ctn' => 'required|integer|min:0',
            'qty_by_ctn' => 'required|integer|min:1',
            'cost_price_by_ctn' => 'required|numeric|min:0',
            'selling_price_per_piece' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $piecesStock->update($request->all());

        return redirect()->route('pieces-stocks.index')
            ->with('success', 'Pieces stock record updated successfully.');
    }

    public function destroy(PiecesStock $piecesStock)
    {
        $piecesStock->delete();

        return redirect()->route('pieces-stocks.index')
            ->with('success', 'Pieces stock record deleted successfully.');
    }

    // Method for low stock alert
    public function lowStock()
    {
        $lowStocks = PiecesStock::where('no_of_ctn', '<', 5)->get();
        return view('pieces-stocks.low-stock', compact('lowStocks'));
    }

    // Method for stock valuation
    public function stockValuation()
    {
        $stocks = PiecesStock::all();
        
        $totalCostValue = 0;
        $totalPotentialValue = 0;
        
        foreach ($stocks as $stock) {
            $totalCostValue += $stock->total_cost_value;
            $totalPotentialValue += $stock->potential_sales_value;
        }
        
        $potentialProfit = $totalPotentialValue - $totalCostValue;

        return view('pieces-stocks.valuation', compact('stocks', 'totalCostValue', 'totalPotentialValue', 'potentialProfit'));
    }
}
