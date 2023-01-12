<?php 

namespace App\Repositories;
use App\Models\User;
use App\Interfaces\MasterDataInterface;
use Hash;
class UserRepository implements MasterDataInterface{
    protected $modul;
    public function __construct(User $model){
        $this->model = $model;
    }
    public function findAll(string $query){
        $output = [];
        if($query == ''){
            $output = $this->model->all();
        }else{
            $output = $this->model->all(); 
        }
        return $output;
    }
    public function findById(int $id){
        $output = $this->model->find($id);
        if(!$output) throw new \Exception("Could Not Find User Data", 404);
        return $output;
    }
    public function findByAttributes(array $conditions){
        $output = $this->model->where($conditions)->first();
        if(!$output) throw new \Exception("Could Not Find User Data", 404);
        return $output;
    }
    public function save(array $formdata){
        $formdata["password"] = Hash::make($formdata["password"]);
        $output = $this->model->create($formdata);
        if(!$output) throw new \Exception("Could Not Save User Data", 400);
        return $output;
    }
    public function update(array $formdata, $id){
        if(!empty($formdata["password"])){
            $formdata["password"] = Hash::make($formdata["password"]);
        }
        $output = $this->findById((int)$id);
        if(!$output) throw new \Exception("Could Not Find User Data",500);
        $update = $output->update($formdata);
        if(!$update) throw new \Exception("Could Not Update User Data", 400);
        return true;
    }
    public function delete($id){
        $output = $this->findById($id);
        $delete = $output->delete();
        if(!$delete) throw new \Exception("Could Not Delete User Data",500);
        return true;
    }
    public function model(){
        return $this->model;
    }
}