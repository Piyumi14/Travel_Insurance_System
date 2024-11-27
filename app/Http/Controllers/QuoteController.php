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
            'destination' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'number_of_travelers' => 'required|integer|min:1',
        ]);

        // Example logic for quote calculation
        $destinationCosts = [
            'Europe' => 10,
            'Asia' => 20,
            'America' => 30,
        ];

        $coverageCosts = ($request->has('medical_expenses') ? 20 : 0) + ($request->has('trip_cancellation') ? 30 : 0);
        $totalPrice = $request->number_of_travelers * ($destinationCosts[$request->destination] + $coverageCosts);

        // Return the view with the calculated quote
        return view('quote-form', [
            'quote' => $totalPrice,
        ]);
    }

    public function list()
    {
        $quotes = Quote::all();
        return view('quote-list', compact('quotes'));
    }

}
