<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounting;

class AccountingController extends Controller
{
     public function index()
    {
        $accountingRecords = Accounting::orderBy('as_of_date', 'desc')->paginate(10);
        return view('accounting.index', compact('accountingRecords'));
    }

    public function create()
    {
        return view('accounting.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'as_of_date' => 'required|date',
            'capital' => 'required|numeric|min:0',
            'goods' => 'required|numeric|min:0',
            'pos' => 'required|numeric|min:0',
            'account' => 'required|numeric|min:0',
            'expense' => 'required|numeric|min:0',
            'salary' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        Accounting::create($request->all());

        return redirect()->route('accounting.index')
            ->with('success', 'Accounting record created successfully.');
    }

    public function show(Accounting $accounting)
    {
        return view('accounting.show', compact('accounting'));
    }

    public function edit(Accounting $accounting)
    {
        return view('accounting.edit', compact('accounting'));
    }

    public function update(Request $request, Accounting $accounting)
    {
        $request->validate([
            'as_of_date' => 'required|date',
            'capital' => 'required|numeric|min:0',
            'goods' => 'required|numeric|min:0',
            'pos' => 'required|numeric|min:0',
            'account' => 'required|numeric|min:0',
            'expense' => 'required|numeric|min:0',
            'salary' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $accounting->update($request->all());

        return redirect()->route('accounting.index')
            ->with('success', 'Accounting record updated successfully.');
    }

    public function destroy(Accounting $accounting)
    {
        $accounting->delete();

        return redirect()->route('accounting.index')
            ->with('success', 'Accounting record deleted successfully.');
    }

    // Method for financial summary
    public function financialSummary()
    {
        $latestRecord = Accounting::latest('as_of_date')->first();
        
        if (!$latestRecord) {
            return redirect()->route('accounting.index')
                ->with('error', 'No accounting records found.');
        }

        $previousRecord = Accounting::where('as_of_date', '<', $latestRecord->as_of_date)
            ->latest('as_of_date')
            ->first();

        return view('accounting.financial-summary', compact('latestRecord', 'previousRecord'));
    }

    // Method for profit/loss calculation
    public function profitLoss(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-d'));

        $records = Accounting::whereBetween('as_of_date', [$startDate, $endDate])
            ->orderBy('as_of_date', 'asc')
            ->get();

        $totalCapital = $records->sum('capital');
        $totalAssets = $records->sum(function($record) {
            return $record->goods + $record->pos + $record->account;
        });
        $totalLiabilities = $records->sum(function($record) {
            return $record->expense + $record->salary;
        });
        $netProfit = $totalAssets - $totalLiabilities;

        return view('accounting.profit-loss', compact('records', 'totalCapital', 'totalAssets', 'totalLiabilities', 'netProfit', 'startDate', 'endDate'));
    }
}
