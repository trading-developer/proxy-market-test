<?php

namespace Tests;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class TestCase
 * @package Tests
 */
abstract class TestCase extends BaseTestCase
{

    public const DEFAULT_PASSWORD = '123456';

    use CreatesApplication;
    use WithFaker;

//    use DatabaseMigrations;
//    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->user([
            'password' => Hash::make(self::DEFAULT_PASSWORD)
        ]);

        $this->actingAs($this->user);
        Carbon::setTestNow();
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|User
     */
    protected function user(array $data = [])
    {
        return User::factory()->create($data);
    }

    /**
     * @return int
     */
    protected function randInt(): int
    {
        return $this->faker->numberBetween(50000);
    }

    /**
     * @return string
     */
    protected function getToken(): string
    {
        return Auth::attempt([
            'email' => $this->user->email,
            'password' => self::DEFAULT_PASSWORD
        ]);
    }

    /**
     * @return array
     */
    protected function getAuthHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->getToken(),
            'Accept' => 'application/json',
        ];
    }
}
