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

   
    /**
     * Store a newly created quote
     * @param  \Illuminate\Http\Request  
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'destination' => 'required|in:Europe,Asia,America',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date', // Ensures end_date is after start_date
            'number_of_travelers' => 'required|integer|min:1',
        ]);
    
        // Quote calculation
        $destinationCosts = [
            'Europe' => 10,
            'Asia' => 20,
            'America' => 30,
        ];
    
        $coverageCosts = ($request->medical_expenses ? 20 : 0) + ($request->trip_cancellation ? 30 : 0);
        $totalPrice = $request->number_of_travelers * ($destinationCosts[$request->destination] + $coverageCosts);
    
        // Save the quote to the session
        session(['quote' => $totalPrice]);
    
        // Save to database
        Quote::create([
            'destination' => $request->destination,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'medical_expenses' => $request->medical_expenses ? 1 : 0,
            'trip_cancellation' => $request->trip_cancellation ? 1 : 0,
            'number_of_travelers' => $request->number_of_travelers,
            'total_price' => $totalPrice,
        ]);
    
        // Return the view with the calculated quote
        return view('quote-form', ['quote' => $totalPrice]);
    }
    
    public function list()
    {
        $quotes = Quote::all();
        return view('quote-list', compact('quotes'));
    }

}
