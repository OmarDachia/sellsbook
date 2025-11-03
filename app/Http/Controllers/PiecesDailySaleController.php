<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PiecesDailySale;

class PiecesDailySaleController extends Controller
{
   public function index()
    {
        $piecesDailySales = PiecesDailySale::orderBy('date', 'desc')->paginate(10);
        return view('pieces-daily-sales.index', compact('piecesDailySales'));
    }

    public function create()
    {
        return view('pieces-daily-sales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'cash_amount' => 'required|numeric|min:0',
            'transfer_amount' => 'required|numeric|min:0',
            'shop_daily_sales' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Calculate total sales automatically
        $totalSales = $request->cash_amount + $request->transfer_amount;

        PiecesDailySale::create([
            'date' => $request->date,
            'cash_amount' => $request->cash_amount,
            'transfer_amount' => $request->transfer_amount,
            'total_sales' => $totalSales,
            'shop_daily_sales' => $request->shop_daily_sales,
            'notes' => $request->notes,
        ]);

        return redirect()->route('pieces-daily-sales.index')
            ->with('success', 'Pieces daily sale record created successfully.');
    }

    public function show(PiecesDailySale $piecesDailySale)
    {
        return view('pieces-daily-sales.show', compact('piecesDailySale'));
    }

    public function edit(PiecesDailySale $piecesDailySale)
    {
        return view('pieces-daily-sales.edit', compact('piecesDailySale'));
    }

    public function update(Request $request, PiecesDailySale $piecesDailySale)
    {
        $request->validate([
            'date' => 'required|date',
            'cash_amount' => 'required|numeric|min:0',
            'transfer_amount' => 'required|numeric|min:0',
            'shop_daily_sales' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Recalculate total sales
        $totalSales = $request->cash_amount + $request->transfer_amount;

        $piecesDailySale->update([
            'date' => $request->date,
            'cash_amount' => $request->cash_amount,
            'transfer_amount' => $request->transfer_amount,
            'total_sales' => $totalSales,
            'shop_daily_sales' => $request->shop_daily_sales,
            'notes' => $request->notes,
        ]);

        return redirect()->route('pieces-daily-sales.index')
            ->with('success', 'Pieces daily sale record updated successfully.');
    }

    public function destroy(PiecesDailySale $piecesDailySale)
    {
        $piecesDailySale->delete();

        return redirect()->route('pieces-daily-sales.index')
            ->with('success', 'Pieces daily sale record deleted successfully.');
    }

    // Method for monthly summary
    public function monthlySummary(Request $request)
    {
        $month = $request->get('month', date('Y-m'));
        
        $monthlyRecords = PiecesDailySale::whereYear('date', substr($month, 0, 4))
            ->whereMonth('date', substr($month, 5, 2))
            ->orderBy('date', 'asc')
            ->get();
        
        $totalCash = $monthlyRecords->sum('cash_amount');
        $totalTransfer = $monthlyRecords->sum('transfer_amount');
        $totalSales = $monthlyRecords->sum('total_sales');
        $totalShopSales = $monthlyRecords->sum('shop_daily_sales');

        return view('pieces-daily-sales.monthly-summary', 
            compact('monthlyRecords', 'totalCash', 'totalTransfer', 'totalSales', 'totalShopSales', 'month'));
    }
}
