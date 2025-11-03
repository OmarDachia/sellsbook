<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SachetDisp;

class SachetDispController extends Controller
{
    public function index()
    {
        $sachetDispRecords = SachetDisp::orderBy('date', 'desc')->paginate(10);
        return view('sachet-disp.index', compact('sachetDispRecords'));
    }

    public function create()
    {
        return view('sachet-disp.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'batch' => 'required|string|max:191',
            'total_no' => 'required|integer|min:1',
            'sold_out' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        // Calculate available automatically
        $available = $request->total_no - $request->sold_out;

        SachetDisp::create([
            'date' => $request->date,
            'batch' => $request->batch,
            'total_no' => $request->total_no,
            'sold_out' => $request->sold_out,
            'available' => $available,
            'notes' => $request->notes,
        ]);

        return redirect()->route('sachet-disp.index')
            ->with('success', 'Sachet dispenser record created successfully.');
    }

    public function show(SachetDisp $sachetDisp)
    {
        return view('sachet-disp.show', compact('sachetDisp'));
    }

    public function edit(SachetDisp $sachetDisp)
    {
        return view('sachet-disp.edit', compact('sachetDisp'));
    }

    public function update(Request $request, SachetDisp $sachetDisp)
    {
        $request->validate([
            'date' => 'required|date',
            'batch' => 'required|string|max:191',
            'total_no' => 'required|integer|min:1',
            'sold_out' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        // Recalculate available
        $available = $request->total_no - $request->sold_out;

        $sachetDisp->update([
            'date' => $request->date,
            'batch' => $request->batch,
            'total_no' => $request->total_no,
            'sold_out' => $request->sold_out,
            'available' => $available,
            'notes' => $request->notes,
        ]);

        return redirect()->route('sachet-disp.index')
            ->with('success', 'Sachet dispenser record updated successfully.');
    }

    public function destroy(SachetDisp $sachetDisp)
    {
        $sachetDisp->delete();

        return redirect()->route('sachet-disp.index')
            ->with('success', 'Sachet dispenser record deleted successfully.');
    }

    // Method for batch tracking
    public function batchTracking($batch)
    {
        $batchRecords = SachetDisp::where('batch', $batch)
            ->orderBy('date', 'desc')
            ->get();
        
        $totalProduced = $batchRecords->sum('total_no');
        $totalSold = $batchRecords->sum('sold_out');
        $totalAvailable = $batchRecords->sum('available');

        return view('sachet-disp.batch-tracking', compact('batchRecords', 'batch', 'totalProduced', 'totalSold', 'totalAvailable'));
    }
}
