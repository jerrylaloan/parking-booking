<?php

namespace Tests\Feature;

use App\Models\Bay;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

	public function setUp(): void
	{
		parent::setUp();

        Carbon::setTestNow('2022-03-29 14:00:00');

		Bay::truncate();

        $bay1 = Bay::create([
	   		'name' => 'bay 1', 
            'location' => 'location 1', 
            'available' => false,
        ]);

        $bay2 = Bay::create([
	   		'name' => 'bay 2', 
            'location' => 'location 2', 
            'available' => false,
        ]);

        $bay3 = Bay::create([
	   		'name' => 'bay 3', 
            'location' => 'location 3', 
            'available' => true,
        ]);
 

		Booking::truncate();
		Booking::insert([
	   		[
                'bay_id' => $bay1->id, 
                'renter' => 'Renter One', 
                'code' => 'BOOK1', 
                'paid' => false, 
                'created_at' => Carbon::create('2022-03-29 12:00:00'),
            ],
	   		[
                'bay_id' => $bay2->id, 
                'renter' => 'Renter Two', 
                'code' => 'BOOK2', 
                'paid' => false, 
                'created_at' => Carbon::create('2022-03-29 13:00:00'),
            ],
		]);
	}

	public function tearDown(): void 
    {
		parent::tearDown();
        Carbon::setTestNow();                                  
    }

    public function test_should_return_not_found_response_for_unrecognizable_booking_code()
    {
        $response = $this->get('/api/booking/BOOK1_NOTFOUND');

        $response->assertStatus(404);
        $response->assertSimilarJson([
            'message' => 'Record not found.',
        ]);
    }

    public function test_should_active_booking_record_of_BOOK1_code()
    {
        $response = $this->get('/api/booking/BOOK1');

        $bay1 = Bay::where('name', 'bay 1')->first();
        $response->assertStatus(200);
        $response->assertSimilarJson([
            'id' => 1,
            'renter' => 'Renter One',
            'code' => 'BOOK1',
            'paid' => false,
            'hours' => 2, 
            'price' => 20, 
            'bay_id' => $bay1->id
        ]);
    }

    public function test_should_successfully_create_new_booking()
    {
        $bay = Bay::where('available', true)->first();

        $response = $this->postJson('/api/booking', [
            'renter' => 'John Doe', 
            'bay_id' => $bay->id, 
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => 3, 
            'renter' => 'John Doe',
            'bay_id' => 3
        ]);

        $decoded = json_decode($response->content());
        $this->assertIsString($decoded->code);

        $bayUpdated = Bay::find($bay->id);
        $this->assertFalse($bayUpdated->available);
    }

    public function test_should_auto_replace_to_available_bay_when_the_desired_bay_is_booked()
    {
        $bay = Bay::where('name', 'bay 1')->first();

        $response = $this->postJson('/api/booking', [
            'renter' => 'John Doe', 
            'bay_id' => $bay->id, 
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => 3, 
            'renter' => 'John Doe',
            'bay_id' => 3
        ]);

        $decoded = json_decode($response->content());
        $this->assertIsString($decoded->code);
    }

    public function test_should_send_400_response_if_the_bay_is_fully_booked()
    {
        $bay = Bay::where('available', true)->first();

        $this->postJson('/api/booking', [
            'renter' => 'John Doe', 
            'bay_id' => $bay->id, 
        ]);

        $response = $this->postJson('/api/booking', [
            'renter' => 'John Doe', 
            'bay_id' => $bay->id, 
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => "Bays are fully booked.", 
        ]);
    }
}
