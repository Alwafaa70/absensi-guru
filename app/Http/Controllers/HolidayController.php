<?php
// app/Http/Controllers/HolidayController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;

class HolidayController extends Controller
{
    public function index()
    {
        $holidays = Holiday::orderBy('date', 'desc')->get();
        return view('holidays.index', compact('holidays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|unique:holidays,date',
            'description' => 'nullable|string|max:255',
        ]);

        Holiday::create([
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Hari libur berhasil ditambahkan.');
    }

    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
        return redirect()->back()->with('success', 'Hari libur berhasil dihapus.');
    }
}
