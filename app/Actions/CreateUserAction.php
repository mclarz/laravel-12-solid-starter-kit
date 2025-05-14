<?php

namespace App\Actions;


use App\Models\User;

class CreateUserAction
{

    public function execute(array $data)
    {
        // Create the user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        // Return the created user
        return $user;
    }
}
