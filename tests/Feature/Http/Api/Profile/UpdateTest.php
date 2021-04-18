<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Api\Profile;

use Database\Factories\UserFactory;
use Illuminate\Http\Response;
use Tests\TestCase;

final class UpdateTest extends TestCase
{
    public function test()
    {
        $user = UserFactory::new()->createOne([
            'email' => 'info@kingscode.nl',
        ]);

        $response = $this->actingAs($user, 'api')->json('put', 'profile', [
            'name' => 'King',
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('users', [
            'name' => 'King',
        ]);
    }

    public function testValidationErrors()
    {
        $user = UserFactory::new()->createOne();

        $response = $this->actingAs($user, 'api')->json('put', 'profile');

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJsonValidationErrors([
            'name',
        ]);
    }
}
