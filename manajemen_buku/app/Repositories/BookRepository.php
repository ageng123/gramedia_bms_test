<?php 

namespace App\Repositories;
use App\Models\TabelBuku;
use App\Interfaces\MasterDataInterface;
class BookRepository implements MasterDataInterface{
    protected $modul;
    public function __construct(TabelBuku $model){
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
        if(!$output) throw new \Exception("Could Not Find Books Data", 404);
        return $output;
    }
    public function findByAttributes(array $conditions){
        $output = $this->model->where($conditions)->first();
        if(!$output) throw new \Exception("Could Not Find Books Data", 404);
        return $output;
    }
    public function save(array $formdata){
        $output = $this->model->create($formdata);
        if(!$output) throw new \Exception("Could Not Save Books Data", 400);
        return $output;
    }
    public function update(array $formdata, $id){
        $output = $this->model->where("id", $id)->first();
        if(!$output) throw new \Exception("Could Not Find Books Data",500);
        $save = $output->update($formdata);
        if(!$save) throw new \Exception("Could Not Update Books Data",500);
        return true;
    }
    public function delete($id){
        $output = $this->findById($id);
        $delete = $output->delete();
        if(!$delete) throw new \Exception("Could Not Delete Books Data",500);
        return true;
    }
    public function model(){
        return $this->model;
    }
}