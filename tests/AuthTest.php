<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;

class AuthTest extends TestCase
{

    public function testAuthenticateReturnToken() {
        $this->json('POST', '/api/authenticate', ['email' => 'alberto.bravi@gmail.com', 'password' => 'secret'], [])
            ->see('token');
    }

    public function testAuthenticateReturnWrongToken() {
        $this->json('POST', '/api/authenticate', ['email' => 'alberto.bravi@gmail.com', 'password' => 'wrong_secret'], [])
            ->dontSee('token');
    }

}
