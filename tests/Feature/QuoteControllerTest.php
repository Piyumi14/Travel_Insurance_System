<?php

namespace Tests\Feature;

use App\Models\Quote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class QuoteControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_validates_the_form_input()
    {
        // Make a POST request with invalid data
        $response = $this->post('/quote', []);

        // Assert that the response redirects with errors
        $response->assertSessionHasErrors([
            'destination', 
            'start_date', 
            'end_date', 
            'number_of_travelers'
        ]);
    }

    /** @test */
    public function it_calculates_the_correct_quote_price()
    {
        // Mock form data
        $formData = [
            'destination' => 'America',
            'start_date' => '2024-12-01',
            'end_date' => '2024-12-10',
            'medical_expenses' => true,
            'trip_cancellation' => true,
            'number_of_travelers' => 2
        ];

        // Calculate the expected quote price
        $destinationCosts = ['Europe' => 10, 'Asia' => 20, 'America' => 30];
        $coverageCosts = 20 + 30; // Medical Expenses + Trip Cancellation
        $expectedPrice = 2 * ($destinationCosts['America'] + $coverageCosts);

        // Submit the form with the mock data
        $response = $this->post('/quote', $formData);

        // Assert that the price is correct and saved in the session
        $response->assertSessionHas('quote');
        $this->assertEquals($expectedPrice, session('quote'));
    }

    /** @test */
    public function it_saves_the_quote_to_the_database()
    {
        // Mock form data
        $formData = [
            'destination' => 'Europe',
            'start_date' => '2024-12-01',
            'end_date' => '2024-12-10',
            'medical_expenses' => true,
            'trip_cancellation' => false,
            'number_of_travelers' => 3
        ];

        // Calculate the expected quote price
        $destinationCosts = ['Europe' => 10, 'Asia' => 20, 'America' => 30];
        $coverageCosts = 20; // Medical Expenses only
        $expectedPrice = 3 * ($destinationCosts['Europe'] + $coverageCosts);

        // Submit the form with the mock data
        $this->post('/quote', $formData);

        // Assert that the quote is saved in the database
        $this->assertDatabaseHas('quotes', [
            'destination' => 'Europe',
            'start_date' => '2024-12-01',
            'end_date' => '2024-12-10',
            'medical_expenses' => true,
            'trip_cancellation' => false,
            'number_of_travelers' => 3,
            'total_price' => $expectedPrice
        ]);
    }
}
