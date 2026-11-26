<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    // Where to send the user after a successful sign up
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Validation rules for the sign up form
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    // Create the account; the role is always "student" and is never read from the form
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'], // hashed automatically by the User model cast
            'role'     => 'student',
        ]);
    }
}