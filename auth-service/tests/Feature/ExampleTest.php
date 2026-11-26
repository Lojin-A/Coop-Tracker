<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    // The site root sends visitors to the login page
    public function test_root_redirects_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    // Protected pages must not be open to guests
    public function test_guest_cannot_open_placements(): void
    {
        $this->get('/placements')->assertRedirect('/login');
    }
}
