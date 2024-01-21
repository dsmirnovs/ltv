<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TvProgrammeApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // seed the database
        $this->artisan('db:seed');
    }

    /**
     * Test request to API without api_key
     */
    public function test_api_without_key()
    {
        $response = $this->get('api/upcoming/1');
        $response->assertStatus(403);
    }

    /**
     * Test request to API with api_key
     */
    public function test_upcoming_with_api_key()
    {
        $response = $this->get('api/upcoming/1', ['x-api-key' => getenv('TV_API_KEY')]);
        $response->assertStatus(200);
    }

    /**
     * Test request to API with incorrect channel id (allowed only 1,2,3)
     */
    public function test_upcoming_with_incorrect_channel_id()
    {
        $response = $this->get('api/upcoming/5', ['x-api-key' => getenv('TV_API_KEY')]);
        $response->assertStatus(404);
    }

    /**
     * Test request to API guide
     */
    public function test_guide_with_api_key()
    {
        $response = $this->get('api/guide/1/2024-01-12', ['x-api-key' => getenv('TV_API_KEY')]);
        $response->assertStatus(200);
    }

    /**
     * Test request to API on-air
     */
    public function test_on_air_with_api_key()
    {
        $response = $this->get('api/on-air/1', ['x-api-key' => getenv('TV_API_KEY')]);
        $response->assertStatus(200);
    }

    /**
     * Test posting new data via api
     */
    public function test_correct_add_new_programme()
    {
        $testData = [
            'channel_nr' => 1,
            'name' => 'TEST',
            'begin_date' => '2024-01-20 09:20:35',
            'end_date' => '2024-01-20 09:45:30',
        ];
        $response = $this->post('api/addProgram', $testData, ['x-api-key' => getenv('TV_API_KEY')]);
        $response->assertStatus(201)
            ->assertJson([
                'name' => 'TEST',
            ]);
    }

    /**
     * Test posting new data via api two same begin date (error case)
     */
    public function test_add_new_programme_with_same_begin_time()
    {
        $testData = [
            'channel_nr' => 1,
            'name' => 'TEST',
            'begin_date' => '2024-01-20 09:20:35',
            'end_date' => '2024-01-20 09:45:30',
        ];
        $this->post('api/addProgram', $testData, ['x-api-key' => getenv('TV_API_KEY')]);

        $response = $this->post('api/addProgram', $testData, ['x-api-key' => getenv('TV_API_KEY')]);
        $response->assertStatus(400);
    }

    /**
     * Test posting new data with incorrect post data
     */
    public function test_add_new_programme_incorrect_post_data() {
        $testData = [
            'channel_nr' => 1,
            'name' => 'TEST',
            'begin_date' => '2024-01-20 09:20:35',
            'end_date' => '2024-01-20 09:45',
        ];
        $response = $this->post('api/addProgram', $testData, ['x-api-key' => getenv('TV_API_KEY')]);
        $response->assertStatus(400);
    }

    /**
     * Test ip limited request (per minute - 20 request allowed)
     */
    public function test_check_ip_address_requests_limit()
    {
        for ($i = 0; $i <= 19; $i++) {
            $this->get('api/upcoming/1', ['x-api-key' => getenv('TV_API_KEY')]);
        }
        $response = $this->get('api/upcoming/1', ['x-api-key' => getenv('TV_API_KEY')]);
        $response->assertStatus(429);
    }
}
