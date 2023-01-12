<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BookRepository;
use App\Http\Requests\BooksForm as BookForm;
class Buku extends Controller
{
    //
    protected $repo;
    protected $response = ["success" => false, 
    "errors" => "",
    "message" => ""];
    public function __construct(BookRepository $bookRepo){
        $this->repo = $bookRepo;
    }
    public function customResponse($code = 500){
        if(is_string($code)){
            $code = 500;
        }
        return response()->json($this->response, $code);
    }
    public function index(){
        try{
            $q = $_GET["query"] ?? "";
            $data = $this->repo->findAll($q);
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
            if(!$data) throw new Exception("Books data not found!", 404);
            $this->response["success"] = true;
            $this->response["data"] = $data;
            return $this->customResponse(200);
        }catch(\Exception $e){
            $this->response["errors"]  = $e->getMessage();
            $this->response["success"] = false;
            return $this->customResponse($e->getCode());
        }
    }
    public function store(BookForm $request){
        try{
            $form = $request->toArray();
            $file = $request->file('gambar')->store("gambar/".date("Ym"));
            $form["gambar"] = $file;
            $save = $this->repo->save($form);
            if(!$save) throw new Exception("Could Not Save Book Data!", 400);
            $this->response["success"] = true;
            $this->response["message"] = "Save Book Data Success";
            return $this->customResponse(201);
        }catch(\Exception $e){
            $this->response["errors"]  = $e->getMessage();
            $this->response["success"] = false;
            return $this->customResponse($e->getCode());
        }
    }
    public function update(BookForm $request, $id){
        try{
            $form = $request->toArray();
            if(!empty($request->file('gambar'))){
                $file = $request->file('gambar')->store("gambar/".date("Ym"));
                $form["gambar"] = $file;
            }
            
            $save = $this->repo->update($form, $id);
            if(!$save) throw new Exception("Could Not Save Book Data!", 400);
            $this->response["success"] = true;
            $this->response["message"] = "Save Book Data Success";
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
            if(!$delete) throw new \Exception('Could not delete Books Data', 400);
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
