<?php

namespace Tests\Feature;

use App\Models\Bay;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PaymentTest extends TestCase
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
            'available' => true,
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
		]);
	}

	public function tearDown(): void 
    {
		parent::tearDown();
        Carbon::setTestNow();                                  
    }

    public function test_should_successfully_paid()
    {
        $bay = Bay::where('available', false)->first();

        $response = $this->postJson('/api/payment', [
            'bay_id' => $bay->id, 
            'code' => 'BOOK1', 
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => 1, 
            'booking_id' => 1,
            'duration' => 2.0, 
            'amount' => 20, 
        ]);

        $bayUpdated = Bay::find($bay->id);
        $this->assertTrue($bayUpdated->available);

        $bookingUpdated = Booking::find($bay->id);
        $this->assertTrue($bookingUpdated->paid);
    }
}
