<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_required_filed_on_login(): void
    {
        $this->json('POST', 'api/v1/login')
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    'email' => ["The email field is required."],
                    'password' => ["The password field is required."],
                ]
            ]);
    }

    public function test_attempt_login_with_wrong_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'anik@strimlabs.com',
            'password' => Hash::make('secret')
        ]);

        $loginData = [
            'email' => $user['email'],
            'password' => 'wrong'
        ];

        $this->json('POST', 'api/v1/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                'status' => 'Error',
                'message' => 'UnAuthorised Access',
                'code' => 401,
                'data' => null
            ]);
    }

    public function test_successfully_login(): void
    {
        $user = User::factory()->create([
            'email' => 'anik@strimlabs.com',
            'password' => Hash::make('secret')
        ]);

        $loginData = [
            'email' => $user['email'],
            'password' => 'secret'
        ];

        $this->json('POST', 'api/v1/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'code',
                'data' => [
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'subscription'
                    ],
                    'access_token'
                ]
            ])
            ->assertJsonFragment([
                'status' => 'Success',
                'message' => 'You have been successfully log in!',
                'code' => 200
            ]);
    }

    public function test_successfully_logout(): void
    {
        Passport::actingAs(User::factory()->create());

        $this->json('POST', 'api/v1/logout', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
