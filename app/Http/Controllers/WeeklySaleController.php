<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeeklySale;
use App\Models\Product;

class WeeklySaleController extends Controller
{
    public function index()
    {
        $weeklySales = WeeklySale::orderBy('date', 'desc')->paginate(10);
        return view('weekly-sales.index', compact('weeklySales'));
    }

    public function create()
    {
        $products = Product::all();
        return view('weekly-sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'item_sold' => 'required|string|max:191',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string|max:60',
            'selling_price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Calculate profit automatically
        $profit = $request->selling_price - $request->cost_price;
        $profitByQuantity = $profit * $request->quantity;

        WeeklySale::create([
            'date' => $request->date,
            'item_sold' => $request->item_sold,
            'quantity' => $request->quantity,
            'size' => $request->size,
            'selling_price' => $request->selling_price,
            'cost_price' => $request->cost_price,
            'profit' => $profit,
            'profit_by_quantity' => $profitByQuantity,
            'notes' => $request->notes,
        ]);

        return redirect()->route('weekly-sales.index')
            ->with('success', 'Weekly sale record created successfully.');
    }

    public function show(WeeklySale $weeklySale)
    {
        return view('weekly-sales.show', compact('weeklySale'));
    }

    public function edit(WeeklySale $weeklySale)
    {
        $products = Product::all();
        return view('weekly-sales.edit', compact('weeklySale', 'products'));
    }

    public function update(Request $request, WeeklySale $weeklySale)
    {
        $request->validate([
            'date' => 'required|date',
            'item_sold' => 'required|string|max:191',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string|max:60',
            'selling_price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Recalculate profit
        $profit = $request->selling_price - $request->cost_price;
        $profitByQuantity = $profit * $request->quantity;

        $weeklySale->update([
            'date' => $request->date,
            'item_sold' => $request->item_sold,
            'quantity' => $request->quantity,
            'size' => $request->size,
            'selling_price' => $request->selling_price,
            'cost_price' => $request->cost_price,
            'profit' => $profit,
            'profit_by_quantity' => $profitByQuantity,
            'notes' => $request->notes,
        ]);

        return redirect()->route('weekly-sales.index')
            ->with('success', 'Weekly sale record updated successfully.');
    }

    public function destroy(WeeklySale $weeklySale)
    {
        $weeklySale->delete();

        return redirect()->route('weekly-sales.index')
            ->with('success', 'Weekly sale record deleted successfully.');
    }

    // Additional method for sales report
    public function report(Request $request)
    {
        $query = WeeklySale::query();

        if ($request->has('start_date') && $request->start_date) {
            $query->where('date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->where('date', '<=', $request->end_date);
        }

        $sales = $query->orderBy('date', 'desc')->get();
        $totalProfit = $sales->sum('profit_by_quantity');
        $totalSales = $sales->sum('selling_price');

        return view('weekly-sales.report', compact('sales', 'totalProfit', 'totalSales'));
    }
}
