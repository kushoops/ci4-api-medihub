<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\GroupModel;

class ManajerController extends ResourceController
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

            if (! auth()->user()->inGroup('administrator')) {
                $response = [
                    "status" => false,
                    "message" => "User is not administrator",
                    "data" => []
                ];
            }else {
                $users->save($user);
                $user = $users->findById($users->getInsertID());
                $user->addGroup('manajer');
    
                $response = [
                    "status" => true,
                    "message" => "Manajer user saved successfully",
                    "data" => []
                ];
            }
        }

        return $this->respondCreated($response);
    }

    // Get
    public function list()
    {
        
        if(! auth()->user()->inGroup('administrator')) {
            $response = [
                "status" => false,
                "message" => "User is not administrator",
                "data" => []
            ];
        }else {
            $groupUsers = new GroupModel();
            $groupUsers = $groupUsers->where('group', 'manajer')->findColumn('id');

            $users = auth()->getProvider();
            $list = [];
            foreach($groupUsers as $user_id) {
                array_push($list, $users->findById($user_id));
            }

            $response = [
                "status" => true,
                "message" => "List of Manajer",
                "data" => $list
            ];
        }

        return $this->respondCreated($response);
    }

    // Delete
    public function deleteManager($manajer_id)
    {
        if(!auth()->user()->inGroup('administrator')){
            $response = [
                "status" => false,
                "message" => "User is not administrator",
                "data" => []
            ];
        }else {
            $users = auth()->getProvider();
        
            if(!$users->delete($manajer_id, true)) {
                $response = [
                    "status" => false,
                    "message" => "Failed to delete manajer user",
                    "data" => []
                ];
            }else {
                $response = [
                    "status" => true,
                    "message" => "Manajer user deleted successfully",
                    "data" => []
                ];
            }
        }

        return $this->respondCreated($response);
    }
}
