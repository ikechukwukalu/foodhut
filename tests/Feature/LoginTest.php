<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use App\Models\User;

class LoginTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testErrorValidationForLogin()
    {
        $postData = [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => ''
        ];

        $response = $this->post('/api/auth/login', $postData, ['Accept' => 'application/json']);
        $responseArray = json_decode($response->getContent(), true);

        $this->assertTrue(isset($responseArray['errors']));
        $this->assertTrue(isset($responseArray['message']));
    }

    public function testLogin()
    {
        $postData = [
            'email' => 'testuser@foodhut.com',
            'password' => '12345678'
        ];

        $response = $this->post('/api/auth/login', $postData, ['Accept' => 'application/json']);
        $responseArray = json_decode($response->getContent(), true);

        $this->assertEquals(200, $responseArray['status_code']);
        $this->assertEquals( 'success', $responseArray['status']);
    }
}
