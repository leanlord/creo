<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SendingRequestTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_anyone_can_put_a_request()
    {
        $responce = $this->post('/', [
            'name' => $this->faker->name(),
            'number' => $this->faker->phoneNumber()
        ]);

        $responce->assertStatus(200);
    }
}
