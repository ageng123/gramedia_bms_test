<?php 
namespace App\Interfaces;

interface MasterDataInterface {
    public function findAll(string $query);
    public function findById(int $id);
    public function findByAttributes(array $conditions);
    public function save(array $formdata);
    public function update(array $formdata, $id);
    public function delete(int $id);
}