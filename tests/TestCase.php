<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\CreatesApplication;
abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase,CreatesApplication, WithFaker;

    /**
     * A default user instance for use in tests.
     *
     * @var \App\Models\User
     */
    protected User $user;

    /**
     * Set up the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create and authenticate a default user for feature tests
        $this->user = User::factory()->create();
    }
}
