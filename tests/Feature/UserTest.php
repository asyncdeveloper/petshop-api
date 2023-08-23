<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function userCanRegister(): void
    {
        $user = array_merge(
            User::factory()->make()->toArray(), ['password' => '12345678', 'password_confirmation' => '12345678']
        );

        $response = $this->post(route('register'), $user);

        $response->assertStatus(201)->assertJsonStructure(['success', 'data']);

        $this->assertDatabaseHas('users', ['email' => $user['email']]);
    }

    /**
     * @test
     */
    public function userCanLogin(): void
    {
        User::factory(5)->create();

        $user = User::first();

        $response = $this->post(
            route('login'), [
                'email' => $user['email'],
                'password' => 'password' //default from factory
            ]
        );

        $response->assertSuccessful()->assertJsonStructure([
                'success',
                'data' => [
                    'access_token',
                    'id',
                    'uuid'
                ]
            ]);
    }

    /**
     * @test
     */
    public function userCanViewUserInfo(): void
    {
        User::factory(5)->create();

        $user = User::first();
        $token = JWTAuth::fromUser($user);

        $response = $this->get(
            route('user'), ['Authorization' => "Bearer {$token}"]
        );


        $response->assertSuccessful()->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'uuid'
                ]
            ]);

        $this->assertSame($response->json()['data']['id'], $user->id);
    }

    /**
     * @test
     */
    public function userCanEditUserInfo(): void
    {
        User::factory(5)->create();

        $user = User::first();
        $token = JWTAuth::fromUser($user);

        $userBody = array_merge($user->toArray(), [
            'first_name' => 'updated',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $response = $this->put(
            route('edit'), $userBody, ['Authorization' => "Bearer {$token}"]
        );

        $response->assertSuccessful()->assertJsonStructure(['success', 'data' => ['user']]);

        $this->assertDatabaseHas('users', ['first_name' => $userBody['first_name']])->assertDatabaseMissing(
                'users',
                ['title' => $user->title]
            )->assertSame($response->json()['data']['user']['first_name'], $userBody['first_name']);
    }

    /**
     * @test
     */
    public function userCanDeleteUserInfo(): void
    {
        User::factory(5)->create();

        $user = User::first();
        $token = JWTAuth::fromUser($user);

        $response = $this->delete(
            route('delete'), [], ['Authorization' => "Bearer {$token}"]
        );

        $response->assertNoContent();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
