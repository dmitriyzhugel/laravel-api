<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Tests\TestCase;
use Faker\Factory;
use Faker\Generator;

class PostsTest extends TestCase
{
    protected Generator $faker;
    private static ?int $postId = null;
    private static ?User $user = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    public function test_posts_create(): void
    {
        static::$user = User::factory()->create();

        $postData = [
            'title' => $this->faker->text(),
            'content' => $this->faker->realText(1000),
        ];

        // Test not auth user
        $response = $this->postJson('/api/posts', $postData);
        $this->assertEquals($response->getStatusCode(), 401);

        // Test auth user
        $response = $this
            ->actingAs(static::$user)
            ->postJson('/api/posts', $postData);

        $this->assertEquals($response->getStatusCode(), 201);
        $this->assertJson($response->content());
        $this->assertArrayHasKey('data', $response->json());

        static::$postId = (int) $response->json('data')['id'];
    }

    /**
     * @depends test_posts_create
     */
    public function test_posts_update(): void
    {
        $postData = [
            'title' => $this->faker->text(),
            'content' => $this->faker->realText(1000),
        ];

        // Test not auth user
        $response = $this->putJson('/api/posts/' . static::$postId, $postData);
        $this->assertEquals($response->getStatusCode(), 401);

        // Test Request validation
        $response = $this
            ->actingAs(static::$user)
            ->putJson('/api/posts/' . static::$postId, [
                'title1' => 'wrong field name'
            ]);

        $this->assertEquals($response->getStatusCode(), 422);
        $this->assertArrayHasKey('errors', $response->json());

        // Test save Post
        $response = $this
            ->actingAs(static::$user)
            ->putJson('/api/posts/' . static::$postId, $postData);

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertJson($response->content());
        $this->assertArrayHasKey('data', $response->json());

        // Test not found
        $response = $this
            ->actingAs(static::$user)
            ->putJson('/api/posts/' . 0, $postData);

        $this->assertEquals($response->getStatusCode(), 404);

        // Test Update for not author
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->putJson('/api/posts/' . static::$postId, $postData);

        $this->assertEquals($response->getStatusCode(), 403);

        $user->delete();

    }
}
