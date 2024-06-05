<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Shield\Entities\User;
use App\Models\SuppliersModel;

class AuthController extends ResourceController
{
    // Post
    public function register()
    {
        if(auth()->loggedIn()) {
            auth()->logout();
        }

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
            $supplierUsers = new SuppliersModel();

            $request = \Config\Services::request();

            // User Entity
            $user = new User([
                "username" => $request->getPost("username"),
                "email" => $request->getPost("email"),
                "password" => $request->getPost("password"),
            ]);

            $users->save($user);
            $user = $users->findById($users->getInsertID());
            $supplierUsers->save(["supplier_id" => $users->getInsertID(), "pengajuan" => false, "tetap" => false]);
            $users->addToDefaultGroup($user);

            $response = [
                "status" => true,
                "message" => "Supplier user saved successfully",
                "data" => []
            ];
        }

        return $this->respondCreated($response);
    }

    // Post
    public function login()
    {
        if(auth()->loggedIn()) {
            auth()->logout();
        }

        $rules = [
            "email" => "required|valid_email",
            "password" => "required"
        ];

        if(!$this->validate($rules)) {
            $response = [
                "status" => false,
                "message" => $this->validator->getErrors(),
                "data" => []
            ];
        }else {
            $request = \Config\Services::request();

            $credentials = [
                "email" => $request->getPost("email"),
                "password" => $request->getPost("password")
            ];

            $loginAttemp = auth()->attempt($credentials);

            if(!$loginAttemp->isOK()) {
                $response = [
                    "status" => false,
                    "message" => "Invalid login details",
                    "data" => []
                ];
            }else {

                // We have a valid data set
                $users = auth()->getProvider();
                $user = $users->findById(auth()->id());
                $token = $user->generateAccessToken("thisismysecretkey");
                $auth_token = $token->raw_token;

                $response = [
                    "status" => true,
                    "message" => "User logged in successully",
                    "data" => [
                        "token" => $auth_token
                    ]
                ];
            }
        }

        return $this->respondCreated($response);
    }

    // Get
    public function logout()
    {
        auth()->logout();
        auth()->user()->revokeAllAccessTokens();

        return $this->respondCreated([
            "status" => true,
            "message" => "User logged out successfully",
            "data" => []
        ]);
    }

    // Get
    public function accessDenied()
    {
        return $this->respondCreated([
            "status" => false,
            "message" => "Invalid access",
            "data" => []
        ]);
    }
}
