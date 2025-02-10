<?php

namespace Tests\Unit\Models;

use App\Models\User as ModelsUser;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_attributes_are_set_correctly(): void
    {
        $user = new ModelsUser([
            'name' => 'Welen',
            'email' => 'welen@teste.com',
        ]);

        $this->assertEquals('Welen', $user->name);
        $this->assertEquals('welen@teste.com', $user->email);
    }

    public function test_non_fillable_attributes_are_not_set()
    {
        $user = new ModelsUser([
            'name' => 'Welen',
            'email' => 'welen@teste.com',
            'gender' => 'male',
        ]);

        $this->assertArrayNotHasKey('gender', $user->getAttributes());
    }
}
