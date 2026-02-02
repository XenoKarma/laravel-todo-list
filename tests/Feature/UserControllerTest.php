<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserControllerTest extends TestCase
{
    // use WithoutMiddleware;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "andika"
        ])->get('/login')
        ->assertRedirect("/");
    }

    public function testLoginPage()
    {
        $this->get('/login')->assertSeeText("Halaman Login");
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "andika",
            "password" => "rahasia"
        ])
        ->assertRedirect("/")
        ->assertSessionHas("user", "andika");
    }
    
    public function testLoginSuccessForUser()
    {
        $this->withSession([
            "user" => "andika"
        ])
        ->post('/login', [
            "user" => "andika",
            "password" => "rahasia"
        ])
        ->assertRedirect("/");  
    }

    public function testLoginValidationError()
    {
        $this->post("/login", [])->assertSeeText("User or Password is Required");
    }

    public function testLoginFailed()
    {
        $this->post("/login", [
            "user" => "wrong",
            "password" => "wrong"
        ])->assertSeeText("User or Password is wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "andika",
        ])->post('/logout')
        ->assertRedirect('/')
        ->assertSessionMissing("user");
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
        ->assertRedirect('/');
    }
}
