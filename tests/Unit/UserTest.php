<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
   public function test_user_registration_validation_rules()
{
    $validData = [
        'name' => 'テストユーザー',
        'email' => 'valid@example.com',
        'password' => 'securepassword',
    ];

    $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'password' => ['required', 'string', 'min:8'],
    ];

    $validator = Validator::make($validData, $rules);

    $this->assertTrue($validator->passes());
}

public function test_user_registration_fails_with_invalid_email()
{
    $invalidData = [
        'name' => 'テストユーザー',
        'email' => 'not-an-email',
        'password' => 'securepassword',
    ];

    $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'password' => ['required', 'string', 'min:8'],
    ];

    $validator = Validator::make($invalidData, $rules);

    $this->assertFalse($validator->passes());
    $this->assertArrayHasKey('email', $validator->errors()->toArray());
}

    public function test_password_is_hashed_on_creation()
{
    $user = \App\Models\User::factory()->create([
        'password' => 'plaintext1234',
    ]);

    $this->assertNotEquals('plaintext1234', $user->password);
    $this->assertTrue(Hash::check('plaintext1234', $user->password));
}
}
