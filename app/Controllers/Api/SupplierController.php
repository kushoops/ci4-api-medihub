<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Shield\Models\GroupModel;
use App\Models\SuppliersModel;

class SupplierController extends ResourceController
{
    // Get
    public function profile()
    {
        if(!auth()->user()->inGroup('supplier')){
            $response = [
                "status" => false,
                "message" => "User is not administrator, manajer, or supplier",
                "data" => []
            ];
        }else {
            $users = new SuppliersModel();
            $user = $users->where("supplier_id", auth()->id())->first();

            $response = [
                "status" => true,
                "message" => "Profile information of logged in user",
                "data" => $user
            ];
        }

        return $this->respondCreated($response);
    }

    // Get
    public function list()
    {
        
        if(! auth()->user()->inGroup('administrator', 'manajer')) {
            $response = [
                "status" => false,
                "message" => "User is not administrator or manajer",
                "data" => []
            ];
        }else {
            $supplierUsers = new SuppliersModel();
            $supplierUsers = $supplierUsers->findAll();

            $response = [
                "status" => true,
                "message" => "List of Supplier",
                "data" => $supplierUsers
            ];
        }

        return $this->respondCreated($response);
    }

    // Get
    public function single($supplier_id)
    {
        
        if(! auth()->user()->inGroup('administrator', 'manajer')) {
            $response = [
                "status" => false,
                "message" => "User is not administrator", 'manajer',
                "data" => []
            ];
        }else {
            $users = new SuppliersModel();
            $user = $users->where('supplier_id', $supplier_id)->first();

            $response = [
                "status" => true,
                "message" => "Detail of Supplier",
                "data" => $user
            ];
        }

        return $this->respondCreated($response);
    }

    // Put
    public function accept($supplier_id)
    {
        if(!auth()->user()->inGroup('administrator')){
            $response = [
                "status" => false,
                "message" => "User is not supplier",
                "data" => []
            ];
        }else {
            $users = new SuppliersModel();
            $user = $users->where('supplier_id', $supplier_id)->first();

            $request = \Config\Services::request();
            $data = $request->getPost();
            unset($data["_method"]);

            if($users->update($user["id"], $data)) {
                $response = [
                    "status" => true,
                    "message" => "Profile updated successfully",
                    "data" => []
                ];
            }else {
                $response = [
                    "status" => false,
                    "message" => "Failed to update user",
                    "data" => []
                ];
            }
        }

        return $this->respondCreated($response);
    }
    
    // Put
    public function updateData()
    {
        if(!auth()->user()->inGroup('supplier')){
            $response = [
                "status" => false,
                "message" => "User is not supplier",
                "data" => []
            ];
        }else {
            $users = new SuppliersModel();
            $user = $users->where("supplier_id", auth()->id())->first();

            $request = \Config\Services::request();
            $data = $request->getPost();
            unset($data["_method"]);
            
            $imageFile = $this->request->getFile("avatar");
            if(!empty($imageFile)) {
                $imageName = $imageFile->getName();
    
                // abc.png
                $imageArrays = explode(".", $imageName);
    
                // ["abc", "png"]
                $newImageName = round(microtime(true)) . "." . end($imageArrays);

                if($imageFile->move("images/suppliers/avatar", $newImageName)) {
                    if(!empty($data['old-avatar'])) {
                        unlink('images/suppliers/avatar/' . $data['old-avatar']);
                    }
                    $data['avatar'] = $newImageName;
                    unset($data["old-avatar"]);
                }else {
                    $response = [
                        "status" => false,
                        "message" => "Failed to upload avatar",
                        "data" => []
                    ];
                }
            }else {
                if(isset($data["old-avatar"])) {
                    $data["avatar"] = $data["old-avatar"];
                    unset($data["old-avatar"]);
                }
            }
            
            $imageFile = $this->request->getFile("data");
            if(!empty($imageFile)) {
                $imageName = $imageFile->getName();
    
                // abc.png
                $imageArrays = explode(".", $imageName);
    
                // ["abc", "png"]
                $newImageName = round(microtime(true)) . "." . end($imageArrays);

                if($imageFile->move("images/suppliers/data", $newImageName)) {
                    if(!empty($data['old-data'])) {
                        unlink('images/suppliers/data/' . $data['old-data']);
                    }
                    $data['data'] = $newImageName;
                    unset($data["old-data"]);
                }else {
                    $response = [
                        "status" => false,
                        "message" => "Failed to upload data",
                        "data" => []
                    ];
                }
            }else {
                if(isset($data["old-data"])) {
                    $data["data"] = $data["old-data"];
                    unset($data["old-data"]);
                }
            }


            if($users->update($user["id"], $data)) {
                $response = [
                    "status" => true,
                    "message" => "Profile updated successfully",
                    "data" => $data
                ];
            }else {
                $response = [
                    "status" => false,
                    "message" => "Failed to update user",
                    "data" => []
                ];
            }
        }

        return $this->respondCreated($response);
    }

    // Delete
    public function deleteSupplier($supplier_id)
    {
        if(!auth()->user()->inGroup('administrator')){
            $response = [
                "status" => false,
                "message" => "User is not administrator",
                "data" => []
            ];
        }else {
            $users = auth()->getProvider();
            $supplierUsers = new SuppliersModel();
        
            if(!$users->delete($supplier_id, true) || !$supplierUsers->where('supplier_id', $supplier_id)->delete()) {
                $response = [
                    "status" => false,
                    "message" => "Failed to delete supplier user",
                    "data" => []
                ];
            }else {
                $response = [
                    "status" => true,
                    "message" => "Supplier user deleted successfully",
                    "data" => []
                ];
            }
        }

        return $this->respondCreated($response);
    }
}
