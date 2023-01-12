<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Http\Requests\UserForm;
class User extends Controller
{
    protected $repo;
    protected $response = ["success" => false, 
    "errors" => "",
    "message" => ""];
    public function __construct(UserRepository $bookRepo){
        $this->repo = $bookRepo;
    }
    public function customResponse($code = 500){
        return response()->json($this->response, $code);
    }
    public function index(){
        try{
            $query = !empty($_GET['q']) ? $_GET['q'] : '';
            $data = $this->repo->findAll($query);
            $this->response["data"] = $data;
            $this->response["success"] = true;
            return $this->customResponse(200);
        }catch(\Exception $e){
            $this->response["errors"]  = $e->getMessage();
            $this->response["success"] = false;
            return $this->customResponse();
        }
      
    }
    public function show($id){
        try{
            $data = $this->repo->findById($id);
            if(!$data) throw new Exception("User not found!", 404);
            $this->response["success"] = true;
            $this->response["data"] = $data;
            return $this->customResponse(200);
        }catch(\Exception $e){
            $this->response["errors"]  = $e->getMessage();
            $this->response["success"] = false;
            return $this->customResponse($e->getCode());
        }
    }
    public function store(UserForm $request){
        try{
            $save = $this->repo->save($request->toArray());
            if(!$save) throw new Exception("Could Not Save Userdata!", 400);
            $this->response["success"] = true;
            $this->response["message"] = "Save User Data Success";
            return $this->customResponse(201);
        }catch(\Exception $e){
            $this->response["errors"]  = $e->getMessage();
            $this->response["success"] = false;
            return $this->customResponse($e->getCode());
        }
    }
    public function update(UserForm $request, $id){
        try{
            $save = $this->repo->update($request->toArray(), $id);
            if(!$save) throw new Exception("Could Not Save Userdata!", 400);
            $this->response["success"] = true;
            $this->response["message"] = "Save User Data Success";
            return $this->customResponse(200);
        }catch(\Exception $e){
            $this->response["errors"]  = $e->getMessage();
            $this->response["success"] = false;
            return $this->customResponse($e->getCode());
        }
    }
    public function delete($id){
        try{
            $delete = $this->repo->delete($id);
            if(!$delete) throw new \Exception('Could not delete User Data', 400);
            $this->response["success"] = true;
            $this->response["message"] = "Delete Data Success!";
            return $this->customResponse(200);
        }catch(\Exception $e){
            $this->response["errors"]  = $e->getMessage();
            $this->response["success"] = false;
            return $this->customResponse($e->getCode());
        }
    }
}
