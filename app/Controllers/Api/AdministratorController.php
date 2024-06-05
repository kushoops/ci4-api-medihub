<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Shield\Entities\User;

class AdministratorController extends ResourceController
{
    // Post
    public function register()
    {
        $rules = [
            "username" => "required|is_unique[users.username]",
            "email" => "required|valid_email|is_unique[auth_identities.secret]",
            "password" => "required"
        ];

        if(!$this->validate($rules)) {
            $response = [
                "status" => false,
                "message" => $this->validator->getErrors(),
                "data" => [] 
            ];
        }else {

            // User Model
            $users = auth()->getProvider();

            $request = \Config\Services::request();

            // User Entity
            $user = new User([
                "username" => $request->getPost("username"),
                "email" => $request->getPost("email"),
                "password" => $request->getPost("password"),
            ]);

            $users->save($user);
            $user = $users->findById($users->getInsertID());
            $user->addGroup('administrator');

            $response = [
                "status" => true,
                "message" => "Administrator user saved successfully",
                "data" => []
            ];
        }

        return $this->respondCreated($response);
    }
}
