<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopPos;

class ShopPosController extends Controller
{
   public function index()
    {
        $shopPosRecords = ShopPos::orderBy('date', 'desc')->paginate(10);
        return view('shop-pos.index', compact('shopPosRecords'));
    }

    public function create()
    {
        return view('shop-pos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'item_name' => 'required|string|max:191',
            'cash_amount' => 'required|numeric|min:0',
            'transfer_amount' => 'required|numeric|min:0',
            'pos_old_balance' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Calculate totals automatically
        $totalSales = $request->cash_amount + $request->transfer_amount;
        $posNewBalance = $request->pos_old_balance + $totalSales;

        ShopPos::create([
            'date' => $request->date,
            'item_name' => $request->item_name,
            'cash_amount' => $request->cash_amount,
            'transfer_amount' => $request->transfer_amount,
            'total_sales' => $totalSales,
            'pos_old_balance' => $request->pos_old_balance,
            'pos_new_balance' => $posNewBalance,
            'notes' => $request->notes,
        ]);

        return redirect()->route('shop-pos.index')
            ->with('success', 'Shop POS record created successfully.');
    }

    public function show(ShopPos $shopPos)
    {
        return view('shop-pos.show', compact('shopPos'));
    }

    public function edit(ShopPos $shopPos)
    {
        return view('shop-pos.edit', compact('shopPos'));
    }

    public function update(Request $request, ShopPos $shopPos)
    {
        $request->validate([
            'date' => 'required|date',
            'item_name' => 'required|string|max:191',
            'cash_amount' => 'required|numeric|min:0',
            'transfer_amount' => 'required|numeric|min:0',
            'pos_old_balance' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Recalculate totals
        $totalSales = $request->cash_amount + $request->transfer_amount;
        $posNewBalance = $request->pos_old_balance + $totalSales;

        $shopPos->update([
            'date' => $request->date,
            'item_name' => $request->item_name,
            'cash_amount' => $request->cash_amount,
            'transfer_amount' => $request->transfer_amount,
            'total_sales' => $totalSales,
            'pos_old_balance' => $request->pos_old_balance,
            'pos_new_balance' => $posNewBalance,
            'notes' => $request->notes,
        ]);

        return redirect()->route('shop-pos.index')
            ->with('success', 'Shop POS record updated successfully.');
    }

    public function destroy(ShopPos $shopPos)
    {
        $shopPos->delete();

        return redirect()->route('shop-pos.index')
            ->with('success', 'Shop POS record deleted successfully.');
    }

    // Method for daily summary
    public function dailySummary(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));
        
        $dailyRecords = ShopPos::where('date', $date)->get();
        $totalCash = $dailyRecords->sum('cash_amount');
        $totalTransfer = $dailyRecords->sum('transfer_amount');
        $totalSales = $dailyRecords->sum('total_sales');

        return view('shop-pos.daily-summary', compact('dailyRecords', 'totalCash', 'totalTransfer', 'totalSales', 'date'));
    }
}
