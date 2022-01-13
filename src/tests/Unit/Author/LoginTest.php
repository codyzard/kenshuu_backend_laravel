<?php

namespace Tests\Unit\Author;

use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Test user can access login page
     *
     * @return void
     */
    public function test_user_can_access_login_page()
    {
        $this->get(route('authors.login'))->assertStatus(200);
    }

    /**
     * Test user can login with author account
     *
     * @return void
     */
    public function test_user_can_login()
    {
        // Assert valid account
        $this->post(route('authors.login_process'), [
            'email_or_username' => 'mrahn1234@gmail.com',
            'password' => '123456',
        ])->assertStatus(302)->assertRedirect(route('homes.home'));

        // Assert logged
        $this->assertAuthenticated();
    }
}
