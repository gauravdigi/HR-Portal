<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HolidayController extends Controller
{
    public function index()
    {
        
        $holidays = Holiday::orderBy('holiday_date')->get();
        return view('holiday.index', compact('holidays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'holiday_date' => 'required|date',
        ]);

        $day = Carbon::parse($request->holiday_date)->format('l'); // e.g., "Monday"

        if ($request->filled('id')) {
            $holiday = Holiday::findOrFail($request->id);
            $holiday->update([
                'title' => $request->title,
                'holiday_date' => $request->holiday_date,
                'day' => $day,
            ]);
            return redirect()->back()->with(['success' => 'Holiday updated successfully.', 'title' => 'Updated']);
        } else {
            Holiday::create([
                'title' => $request->title,
                'holiday_date' => $request->holiday_date,
                'day' => $day,
            ]);
            return redirect()->back()->with(['success' => 'Holiday added successfully.', 'title' => 'Added']);
        }
    }
    public function edit($id)
    {
        $holiday = Holiday::findOrFail($id);
        $holidays = Holiday::orderBy('holiday_date')->get();
        return view('holiday.index', compact('holiday', 'holidays'));
    }

public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'holiday_date' => 'required|date',
    ]);

    $day = Carbon::parse($request->holiday_date)->format('l');

    $holiday = Holiday::findOrFail($id);
    $holiday->update([
        'title' => $request->title,
        'holiday_date' => $request->holiday_date,
        'day' => $day,
    ]);

    return response()->json([
        'message' => 'Holiday updated successfully.'
    ]);
}


    public function destroy($id)
    {
        $holiday = Holiday::findOrFail($id);
        $holiday->delete();

        return redirect()->route('holiday.index')->with(['success' => 'Holiday deleted successfully.', 'title' => 'Deleted']);
    }
}

