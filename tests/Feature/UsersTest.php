<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class UsersTest extends TestCase
{
    public function test_users_list()
    {
        $response = $this->getJson('/api/users');
        $this->assertEquals($response->getStatusCode(), 401);

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->json('GET', '/api/users');

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertJson($response->content());
    }
}
