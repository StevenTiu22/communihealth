<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserManagement extends TestCase
{
    public function test_user_can_login(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
