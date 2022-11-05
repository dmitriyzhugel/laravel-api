<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Tests\TestCase;
use Faker\Factory;

class CommentsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    public function test_comments_create(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'title' => $this->faker->text(),
            'content' => $this->faker->realText(1000),
            'user_id' => $user->id,
        ]);
        $commentData = [
            'comment' => $this->faker->realText(100),
            'post_id' => $post->id,
        ];

        // Test auth
        $response = $this->postJson('/api/comments', $commentData);
        $this->assertEquals($response->getStatusCode(), 401);

        // Test save Comment
        $response = $this
            ->actingAs($user)
            ->postJson('/api/comments', $commentData);

        $this->assertEquals($response->getStatusCode(), 201);
        $this->assertJson($response->content());
        $this->assertArrayHasKey('data', $response->json());
    }
}
