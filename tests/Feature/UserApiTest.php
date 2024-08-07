<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function testGetUser()
    {
        $user = User::factory()->create();
        $response = $this->getJson("/api/user/{$user->id}");
        $response->assertStatus(200);

        $response->assertJson([
            'is_success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    #[DataProvider('paginationProvider')]
    public function testGetUsersWithPagination($page, $perPage)
    {
        User::factory()->count(50)->create();
        $response = $this->json('GET', '/api/user', ['page' => $page, 'perPage' => $perPage]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'is_success',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        $responseData = $response->json();
        $this->assertCount($perPage, $responseData['data']);
    }

    public static function paginationProvider()
    {
        return [
            [1, 10],
            [2, 5],
            [3, 8],
        ];
    }

    public function testCreateUser()
    {
        $payload = [
            'name' => 'name9',
            'email' => 'name9@mail.ru',
            'password' => '11111113',
        ];
        $response = $this->postJson('/api/user', $payload);
        $response->assertStatus(201);
        $response->assertJson([
            'is_success' => true,
            'data' => [
                'name' => 'name9',
                'email' => 'name9@mail.ru',
            ],
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'name9@mail.ru',
        ]);
    }

    public function testUpdateUser()
    {
        $user = User::factory()->create();
        $payload = [
            'name' => 'name44',
            'email' => 'name441@mail.ru',
            'password' => '11111113',
        ];
        $response = $this->json('PUT', "/api/user/{$user->id}", $payload);
        $response->assertStatus(200);
        $response->assertJson([
            'is_success' => true,
            'data' => [
                'id' => $user->id,
                'name' => 'name44',
                'email' => 'name441@mail.ru',
            ],
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'name44',
            'email' => 'name441@mail.ru',
        ]);
    }

    public function testDeleteUser()
    {
        $user = User::factory()->create();
        $response = $this->json('DELETE', "/api/user/{$user->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'is_success' => true,
        ]);
        
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

}
