<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthForm;
use App\Repositories\UserRepository;
use Hash;
use JWTAuth;

class Authentication extends Controller
{
    //
    protected $repo;
    protected $response = ["errors" => "", "message" => "", "success" => false];
    public function __construct(UserRepository $repo){
        $this->repo = $repo;
    }
    private function customResponse(int $code){
        if($code == 0){
            $code = 500;
        }
        return response()->json($this->response, $code);
    }
    public function login(AuthForm $request){
        try{
            $user = $this->repo->findByAttributes(["email" => $request->email]);
            if(!$user) throw new \Exception("Could not find user", 404);
            if(!Hash::check($request->password, $user->password)) throw new \Exception("Invalid password", 400);
            $token = JWTAuth::fromUser($user);
            $this->response["data"] = ["token" => $token];
            $this->response["success"] = true;
            return $this->customResponse(200);
        }catch(\Exception $e){
            $this->response["success"] = false;
            $this->response["errors"] = $e->getMessage();
            return $this->customResponse($e->getCode());
        }
        
    }
    public function register(AuthForm $request){
        try{
            $user = $this->repo->save($request->toArray());
            if(!$user) throw new \Exception("Could not find user", 404);
            $loginData = $this->repo->findByAttributes(["email" => $request->email]);
            $token = JWTAuth::fromUser($user);
            $this->response["data"] = ["token" => $token];
            $this->response["success"] = true;
            return $this->customResponse(200);
        }catch(\Exception $e){
            $this->response["success"] = false;
            $this->response["errors"] = $e->getMessage();
            return $this->customResponse($e->getCode());
        }
    }
    
}
