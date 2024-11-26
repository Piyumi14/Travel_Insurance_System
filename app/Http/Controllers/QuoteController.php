<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;

class QuoteController extends Controller
{
    public function index()
    {
        return view('quote-form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'destination' => 'required|in:Europe,Asia,America',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'number_of_travelers' => 'required|integer|min:1',
            'medical_expenses' => 'nullable|boolean',
            'trip_cancellation' => 'nullable|boolean',
        ]);

        $destinationCosts = ['Europe' => 10, 'Asia' => 20, 'America' => 30];
        $coverageCosts = 0;

        if ($request->medical_expenses) {
            $coverageCosts += 20;
        }
        if ($request->trip_cancellation) {
            $coverageCosts += 30;
        }

        $totalPrice = $request->number_of_travelers * ($destinationCosts[$request->destination] + $coverageCosts);

        // Save to the database
        $quote = Quote::create([
            'destination' => $request->destination,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'medical_expenses' => $request->medical_expenses ?? false,
            'trip_cancellation' => $request->trip_cancellation ?? false,
            'number_of_travelers' => $request->number_of_travelers,
            'total_price' => $totalPrice,
        ]);

        return back()->with('quote', $quote->total_price);
    }

    public function list()
    {
        $quotes = Quote::all();
        return view('quote-list', compact('quotes'));
    }

}
