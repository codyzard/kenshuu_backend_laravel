<?php

namespace Tests\Unit\Author;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use WithFaker;

    /**
     * Test user can access register page
     *
     * @return void
     */
    public function test_user_can_access_register_page()
    {
        $this->get(route('authors.register'))->assertStatus(200);
    }

    /**
     * Test user can register account and login
     *
     * @return void
     */
    public function test_user_can_register_and_login()
    {
        // New author account
        $fake_author = factory(Author::class)->make();

        // Login with new author accout and assert rediect homepage
        $this->post(route('authors.register_process'), [
            'email' => $fake_author->email,
            'password' => '123456',
        ])->assertStatus(302)->assertRedirect(route('homes.home'));

        // Authenticated
        $this->actingAs($fake_author); // Same 'attempt' function in web application
        $author = Auth::user();  // Get author after authenticating

        // Assert instance, email is valid
        $this->assertInstanceOf(Author::class, $author);
        $this->assertEquals($author->email, $fake_author->email);
        $this->assertAuthenticatedAs($author);
    }
}
