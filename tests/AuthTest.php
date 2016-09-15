<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{

    public function testAuthenticateReturnToken() {
        $this->json('POST', '/api/authenticate', ['email' => 'alberto.bravi@gmail.com', 'password' => 'ciaociao'], [])
            ->see('token');
    }

    public function testAuthenticateReturnWrongToken() {
        $this->json('POST', '/api/authenticate', ['email' => 'alberto@gmail.com', 'password' => 'ciao'], [])
            ->dontSee('token');
    }

}
