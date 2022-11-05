<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Tests\TestCase;
use Faker\Factory;

class CommentsTest extends TestCase
{
    protected static ?User $user = null;
    protected static ?Post $post = null;
    protected static ?int $commentId = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    /**
     * Test comment create
     * POST /api/comments
     */
    public function test_comments_create(): void
    {
        static::$user = User::factory()->create();
        static::$post = Post::factory()->create([
            'title' => $this->faker->text(),
            'content' => $this->faker->realText(1000),
            'user_id' => static::$user->id,
        ]);
        $commentData = [
            'comment' => $this->faker->realText(100),
            'post_id' => static::$post->id,
        ];

        // Test auth
        $response = $this->postJson('/api/comments', $commentData);
        $this->assertEquals($response->getStatusCode(), 401);

        // Test validation
        $response = $this
            ->actingAs(static::$user)
            ->postJson(
                '/api/comments',
                [
                    'comment1' => 'some wrong data'
                ]
            );
        $this->assertEquals($response->getStatusCode(), 422);

        //Test create
        $response = $this
            ->actingAs(static::$user)
            ->postJson('/api/comments', $commentData);

        $this->assertEquals($response->getStatusCode(), 201);
        $this->assertJson($response->content());
        $this->assertArrayHasKey('data', $response->json());

        static::$commentId = (int) $response->json('data')['id'];
    }

    /**
     * Test comment update
     * PUT /api/comments/{$id}
     */
    public function test_comments_update(): void
    {
        $commentData = [
            'comment' => $this->faker->realText(100),
        ];

        // Test auth
        $response = $this->putJson('/api/comments/' . static::$commentId, $commentData);
        $this->assertEquals($response->getStatusCode(), 401);

        // Test validation
        $response = $this
            ->actingAs(static::$user)
            ->putJson(
                '/api/comments/' . static::$commentId,
                [
                    'comment1' => 'some wrong data'
                ]
            );
        $this->assertEquals($response->getStatusCode(), 422);

        // Test save Comment
        $response = $this
            ->actingAs(static::$user)
            ->putJson('/api/comments/' . static::$commentId, $commentData);

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertJson($response->content());
        $this->assertArrayHasKey('data', $response->json());

        // Test not found
        $response = $this
            ->actingAs(static::$user)
            ->putJson('/api/comments/' . 0, $commentData);
        $this->assertEquals($response->getStatusCode(), 404);

        // Test Update for not author
        /** @var User $user */
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->putJson('/api/comments/' . static::$commentId, $commentData);

        $this->assertEquals($response->getStatusCode(), 403);
    }

    /**
     * Test comment delete
     */
    public function test_comments_delete(): void
    {
        // Test not auth user
        $response = $this->deleteJson('/api/comments/' . static::$commentId);
        $this->assertEquals($response->getStatusCode(), 401);

        // Test for not author
        /** @var User $user */
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->deleteJson('/api/comments/' . static::$commentId);
        $this->assertEquals($response->getStatusCode(), 403);
        $user->delete();

        // Test auth user
        $response = $this
            ->actingAs(static::$user)
            ->deleteJson('/api/comments/' . static::$commentId);
        $this->assertEquals($response->getStatusCode(), 204);
    }
}
