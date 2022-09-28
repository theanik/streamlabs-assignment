<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function test_required_fields_for_registration(): void
    {
        $this->json('POST', 'api/v1/register', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => ["Name is required!"],
                    "email" => ["Email is required!"],
                    "password" => ["Password is required!"],
                ]
            ]);
    }

    public function test_password_confirmation_dose_not_match(): void
    {
        $user = [
            'name' => 'John Doe',
            'email' => 'doe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'wrong-secret'
        ];


        $this->json('POST', 'api/v1/register', $user,  ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => ['The password confirmation does not match.']
                ]
            ]);
    }

    public function test_successful_registration(): void
    {
        $userData = [
            "name" => "John Doe",
            "email" => "doe@example.com",
            "password" => "secret",
            "password_confirmation" => "secret"
        ];

        $this->json('POST', 'api/v1/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'code',
                'data' => [
                    'id',
                    'name',
                    'email',
                    'subscription'
                ]
            ]);
    }


    public function test_unique_email_on_registration(): void
    {
        $userData = [
            "name" => "John Doe",
            "email" => "doe@example.com",
            "password" => "secret",
            "password_confirmation" => "secret"
        ];

        $this->json('POST', 'api/v1/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(201);

        $this->json('POST', 'api/v1/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => ['The email has already been taken.']
                ]
            ]);
    }
}
