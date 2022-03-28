<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery\MockInterface;
use App\Services\BayService;
use App\Models\Bay;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;

class BaysTest extends TestCase
{
    use RefreshDatabase;

	public function setUp(): void
	{
		parent::setUp();

		Bay::truncate();
		Bay::insert([
	   		['name' => 'bay 1', 'location' => 'location 1', 'available' => true],
	   		['name' => 'bay 2', 'location' => 'location 2', 'available' => true],
	   		['name' => 'bay 3', 'location' => 'location 3', 'available' => true],
		]);
	}

 	public function test_should_return_200_response_for_successful_api_invocation()
 	{
 	    $response = $this->get('/api/bays');

 	    $response->assertStatus(200);
		assertEquals(3, count($response->json()));
 	}

    public function test_should_return_3_bays_in_the_response_data()
    {
        $response = $this->get('/api/bays');

        $response->assertSimilarJson([
          [
            'id' => 1,
			'name' => 'bay 1',
            'location' => 'location 1',
            'available' => true
          ], 
          [
            'id' => 2,
			'name' => 'bay 2', 
            'location' => 'location 2',
            'available' => true
          ], 
          [
            'id' => 3,
			'name' => 'bay 3', 
            'location' => 'location 3',
            'available' => true
          ], 
        ]);
    }

    public function test_should_return_0_elements_for_request_with_not_available_query_string()
    {
        $response = $this->get('/api/bays?status=not_available');

		assertEquals(0, count($response->json()));
        $response->assertSimilarJson([]);
    }
}