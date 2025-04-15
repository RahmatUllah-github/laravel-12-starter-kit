<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use App\Models\User;
use Tests\TestCase;

class GoogleLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_google()
    {
        // Fake Socialite response
        $abstractUser = \Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('1234567890');
        $abstractUser->shouldReceive('getEmail')->andReturn('testuser@example.com');
        $abstractUser->shouldReceive('getName')->andReturn('Test User');
        $abstractUser->shouldReceive('getAvatar')->andReturn('http://example.com/avatar.jpg');

        Socialite::shouldReceive('driver->stateless->userFromToken')
            ->once()
            ->andReturn($abstractUser);

        $response = $this->postJson('/api/social-auth/google', [
            'token' => 'fake-valid-token'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message',
                     'data' => [
                         'user' => [
                             'id', 'name', 'email'
                         ],
                         'token'
                     ]
                 ]);
    }
}
