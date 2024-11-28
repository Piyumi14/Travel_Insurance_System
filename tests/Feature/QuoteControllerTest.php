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
    /** @test */
public function it_calculates_the_correct_quote_price()
{
    $formData = [
        'destination' => 'America',
        'start_date' => '2024-12-01',
        'end_date' => '2024-12-10',
        'medical_expenses' => '1', // Checkbox value
        'trip_cancellation' => '1', // Checkbox value
        'number_of_travelers' => 2,
    ];

    // Expected price calculation
    $destinationCosts = ['Europe' => 10, 'Asia' => 20, 'America' => 30];
    $coverageCosts = 20 + 30;
    $expectedPrice = 2 * ($destinationCosts['America'] + $coverageCosts);

    // Submit the form with the mock data
    $response = $this->post('/quote', $formData);

    // Assert session contains the correct quote
    $response->assertSessionHas('quote', $expectedPrice);
}


    /** @test */
    public function it_saves_the_quote_to_the_database()
    {
        $formData = [
            'destination' => 'Europe',
            'start_date' => '2024-12-01',
            'end_date' => '2024-12-10',
            'medical_expenses' => '1', // Checkbox value
            'trip_cancellation' => null, // Checkbox not selected
            'number_of_travelers' => 3,
        ];

        $destinationCosts = ['Europe' => 10, 'Asia' => 20, 'America' => 30];
        $coverageCosts = 20; // Medical Expenses only
        $expectedPrice = 3 * ($destinationCosts['Europe'] + $coverageCosts);

        $this->post('/quote', $formData);

        $this->assertDatabaseHas('quotes', [
            'destination' => 'Europe',
            'start_date' => '2024-12-01',
            'end_date' => '2024-12-10',
            'medical_expenses' => 1,
            'trip_cancellation' => 0,
            'number_of_travelers' => 3,
            'total_price' => $expectedPrice,
        ]);
    }


    /** @test */
    public function it_rejects_invalid_destination()
    {
        $formData = [
            'destination' => 'InvalidDestination',
            'start_date' => '2024-12-01',
            'end_date' => '2024-12-10',
            'number_of_travelers' => 2
        ];

        $response = $this->post('/quote', $formData);

        // Assert that the destination field has an error
        $response->assertSessionHasErrors(['destination']);
    }

   /** @test */
    public function it_rejects_invalid_date_ranges()
    {
        $formData = [
            'destination' => 'America',
            'start_date' => '2024-12-10', // Start date after end date
            'end_date' => '2024-12-01',   // Invalid date range
            'number_of_travelers' => 2,
        ];

        $response = $this->post('/quote', $formData);

        // Assert that the validation fails for the start_date or end_date field
        $response->assertSessionHasErrors(['end_date']); // end_date must be after start_date
    }


    /** @test */
    public function it_requires_valid_number_of_travelers()
    {
        $formData = [
            'destination' => 'Asia',
            'start_date' => '2024-12-01',
            'end_date' => '2024-12-10',
            'number_of_travelers' => 0 // Invalid
        ];

        $response = $this->post('/quote', $formData);

        // Assert that the number_of_travelers field has an error
        $response->assertSessionHasErrors(['number_of_travelers']);
    }

    /** @test */
    public function it_calculates_price_for_minimum_travelers_with_no_coverage()
    {
        $formData = [
            'destination' => 'Europe',
            'start_date' => '2024-12-01',
            'end_date' => '2024-12-10',
            'medical_expenses' => false,
            'trip_cancellation' => false,
            'number_of_travelers' => 1
        ];

        $destinationCosts = ['Europe' => 10, 'Asia' => 20, 'America' => 30];
        $expectedPrice = 1 * $destinationCosts['Europe'];

        $response = $this->post('/quote', $formData);

        $response->assertSessionHas('quote');
        $this->assertEquals($expectedPrice, session('quote'));
    }

    /** @test */
    public function it_calculates_price_for_max_travelers_with_full_coverage()
    {
        $formData = [
            'destination' => 'Asia',
            'start_date' => '2024-12-01',
            'end_date' => '2024-12-10',
            'medical_expenses' => true,
            'trip_cancellation' => true,
            'number_of_travelers' => 10
        ];

        $destinationCosts = ['Europe' => 10, 'Asia' => 20, 'America' => 30];
        $coverageCosts = 20 + 30; // Medical Expenses + Trip Cancellation
        $expectedPrice = 10 * ($destinationCosts['Asia'] + $coverageCosts);

        $response = $this->post('/quote', $formData);

        $response->assertSessionHas('quote');
        $this->assertEquals($expectedPrice, session('quote'));
    }

    /** @test */
    public function it_does_not_store_invalid_data_in_the_database()
    {
        $formData = [
            'destination' => 'InvalidDestination',
            'start_date' => '2024-12-01',
            'end_date' => '2024-12-10',
            'number_of_travelers' => 2
        ];

        $this->post('/quote', $formData);

        // Assert that no record exists in the database
        $this->assertDatabaseCount('quotes', 0);
    }

    /** @test */
    public function it_stores_valid_data_in_the_database()
    {
        $formData = [
            'destination' => 'Asia',
            'start_date' => '2024-12-01',
            'end_date' => '2024-12-10',
            'medical_expenses' => true,
            'trip_cancellation' => false,
            'number_of_travelers' => 5
        ];

        $this->post('/quote', $formData);

        $this->assertDatabaseHas('quotes', [
            'destination' => 'Asia',
            'start_date' => '2024-12-01',
            'end_date' => '2024-12-10',
            'medical_expenses' => true,
            'trip_cancellation' => false,
            'number_of_travelers' => 5
        ]);
    }

    /** @test */
    public function it_calculates_price_with_no_additional_coverage()
    {
        $formData = [
            'destination' => 'America',
            'start_date' => '2024-12-01',
            'end_date' => '2024-12-10',
            'medical_expenses' => false,
            'trip_cancellation' => false,
            'number_of_travelers' => 4
        ];

        $destinationCosts = ['Europe' => 10, 'Asia' => 20, 'America' => 30];
        $expectedPrice = 4 * $destinationCosts['America'];

        $response = $this->post('/quote', $formData);

        $response->assertSessionHas('quote');
        $this->assertEquals($expectedPrice, session('quote'));
    }
    
}
