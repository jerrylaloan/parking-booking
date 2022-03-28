<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery\MockInterface;
use App\Services\BayService;

class BaysTest extends TestCase
{
    use RefreshDatabase;

	public function setUp(): void
	{
		parent::setUp();

		$mock = $this->mock(BayService::class, function (MockInterface $mock) {
    		$mock->shouldReceive('getAll')->with('all')->andReturn([
				[
            		'id' => 1,
            		'location' => 'location 1',
            		'available' => true
				], 
				[
            		'id' => 2,
            		'location' => 'location 2',
            		'available' => true
				], 
				[
            		'id' => 3,
            		'location' => 'location 3',
            		'available' => true
				]
			]);
		});
	}

 	public function test_should_return_200_response_for_successful_api_invocation()
 	{
 	    $response = $this->get('/api/bays');

 	    $response->assertStatus(200);
 	}

    public function test_should_return_3_bays_in_the_response_data()
    {
        $response = $this->get('/api/bays');

        $response->assertJson([
          [
            'id' => 1,
            'location' => 'location 1',
            'available' => true
          ], 
          [
            'id' => 2,
            'location' => 'location 2',
            'available' => true
          ], 
          [
            'id' => 3,
            'location' => 'location 3',
            'available' => true
          ], 
        ]);
    }
}