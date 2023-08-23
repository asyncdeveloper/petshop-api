<?php

namespace Tests\Feature;

use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderStatusCRUDTest extends TestCase
{

    use DatabaseMigrations;

    protected Collection $orderStatusRoutes;

    public function setUp(): void
    {
        parent::setUp();

        $this->orderStatusRoutes = collect(Route::getRoutes())->filter(function ($route) {
                return Str::contains($route->uri, 'order-status');
            });
    }

    /**
     * @test
     */
    public function UserCanNotViewAccessOrderStatusEndpointsWhenTokenIsMissing(): void
    {
        foreach ($this->orderStatusRoutes as $route) {
            $response = $this->get(
                route(
                    $route->getName(),
                    [
                        'uuid' => fake()->uuid()
                    ]
                )
            );
            $response->assertStatus(401)->assertJson([
                    'error' => 'Token not parsed'
                ]);
        }
    }

    /**
     * @test
     */
    public function UserCanNotViewAccessOrderStatusEndpointsWhenTokenIsInvalid(): void
    {
        foreach ($this->orderStatusRoutes as $route) {
            $response = $this->get(
                route(
                    $route->getName(), ['uuid' => fake()->uuid()]
                ),
                [
                    'Authorization' => "Bearer 122222222"
                ]
            );

            $response->assertStatus(401)->assertJson([
                    'error' => 'Invalid token'
                ]);
        }
    }

    /**
     * @test
     */
    public function userCanNotViewAccessOrderStatusEndpointsWhenTokenIsExpired(): void
    {
        User::factory(1)->create();

        $user = User::first();

        $token = JWTAuth::customClaims(['exp' => now()->addSecond()->timestamp])->fromUser($user);

        sleep(2);

        foreach ($this->orderStatusRoutes as $route) {
            $response = $this->get(
                route(
                    $route->getName(), ['uuid' => fake()->uuid()]
                ), ['Authorization' => "Bearer {$token}"]
            );

            $response->assertStatus(401)->assertJson(['error' => 'Token has Expired']);
        }
    }

    /**
     * @test
     */
    public function loggedInUserCanViewAllOrderStatus(): void
    {
        User::factory(1)->create();
        OrderStatus::factory(5)->create();

        $user = User::first();
        $token = JWTAuth::fromUser($user);

        $response = $this->get(route('all-order-status'), ['Authorization' => "Bearer {$token}"]);

        $response->assertSuccessful()->assertJsonStructure(['success', 'data'])->assertJsonCount(5, 'data');
    }

    /**
     * @test
     */
    public function loggedInUserCanViewOneOrderStatus(): void
    {
        User::factory(1)->create();
        OrderStatus::factory(5)->create();

        $user = User::first();
        $token = JWTAuth::fromUser($user);

        $orderStatus = OrderStatus::inRandomOrder()->first();

        $response = $this->get(
            route('find-order-status',
                ['uuid' => $orderStatus->uuid]
            ),
            ['Authorization' => "Bearer {$token}"]
        );


        $response->assertSuccessful()
            ->assertJsonStructure([
                'success',
                'data'
            ])->assertJsonFragment($orderStatus->toArray());
    }

    /**
     * @test
     */
    public function loggedInUserCanCreateOrderStatus(): void
    {
        User::factory(1)->create();

        $user = User::first();
        $token = JWTAuth::fromUser($user);

        $orderStatusBody = [
            'title' => 'order1'
        ];

        $response = $this->post(
            route('create-order-status'), $orderStatusBody, [
                'Authorization' => "Bearer {$token}"
            ]
        );

        $response->assertSuccessful()->assertJsonStructure(['success', 'data']);

        $this->assertDatabaseHas('order_statuses', $orderStatusBody)->assertDatabaseCount(
                'order_statuses',
                1
            )->assertSame($orderStatusBody['title'], $response->json()['data']['title']);
    }

    /**
     * @test
     */
    public function loggedInUserCanUpdateOrderStatus(): void
    {
        User::factory(1)->create();
        OrderStatus::factory(10)->create();

        $user = User::first();
        $token = JWTAuth::fromUser($user);

        $orderStatus = OrderStatus::inRandomOrder()->first();

        $updateOrderStatusBody = [
            'title' => 'updated title'
        ];

        $response = $this->put(
            route(
                'update-order-status', ['uuid' => $orderStatus->uuid]
            ), $updateOrderStatusBody, [
                'Authorization' => "Bearer {$token}"
            ]
        );

        $response->assertSuccessful()->assertJsonStructure(['success', 'data']);

        $this->assertDatabaseHas('order_statuses', $updateOrderStatusBody)->assertDatabaseMissing(
                'order_statuses',
                ['title' => $orderStatus->title]
            )->assertSame($response->json()['data']['title'], $updateOrderStatusBody['title']);
    }

    /**
     * @test
     */
    public function loggedInUserCanDeleteOrderStatus(): void
    {
        User::factory(1)->create();
        OrderStatus::factory(10)->create();

        $user = User::first();
        $token = JWTAuth::fromUser($user);

        $orderStatus = OrderStatus::inRandomOrder()->first();

        $response = $this->delete(
            route('delete-order-status', ['uuid' => $orderStatus->uuid]), [], ['Authorization' => "Bearer {$token}"]
        );

        $response->assertNoContent();

        $this->assertDatabaseMissing('order_statuses', ['uuid' => $orderStatus->uuid]);
    }
}
