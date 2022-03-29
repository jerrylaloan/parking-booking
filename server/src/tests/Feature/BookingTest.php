<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingTest extends TestCase
{
    public function test_should_return_not_found_response_for_unrecognizable_booking_code()
    {
        $response = $this->get('/api/booking/BOOK1');

        $response->assertStatus(404);
        $response->assertSimilarJson([
            'message' => 'Record not found.',
        ]);
    }
}
