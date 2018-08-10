<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserInfo()
    {
        $user  = User::find(1);
        $token = JWTAuth::fromUser($user);

        $response = $this->json('GET', '/api/users');
        $response->assertStatus(400);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->json('GET', '/api/users');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'joined'
            ]
        ]);

        $this->assertEquals($user->name, $response->decodeResponseJson('data')['name']);
    }
}
