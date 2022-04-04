<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;

/**
 * Description of Custommodel
 *
 * @author RAMPA
 */
class Mcustom {
    
    protected  $db;
    
    public function __construct() {
        $this->db = db_connect();
    }
    
    public function getAllQ($q) {
        $query = $this->db->query($q);
        return $query;
    }
    
    public function getAllQR($q) {
        $query = $this->db->query($q);
        return $query->getRowObject();
    }
    
    public function getAll($tb_name) {
        $builder = $this->db->table($tb_name);
        $query = $builder->get();
        return $query;
    }
    
    public function getAllW($tb_name, $kondisi) {
        $builder = $this->db->table($tb_name);
        $builder->where($kondisi);
        $query = $builder->get();
        return $query;
    }
    
    public function getAllQR_tb($tb_name, $kondisi) {
        $builder = $this->db->table($tb_name);
        $builder->where($kondisi);
        $query = $builder->get();
        return $query->getRowObject();
    }
    
    public function getAllQR_nontb($tb_name) {
        $builder = $this->db->table($tb_name);
        $query = $builder->get();
        return $query->getRowObject();
    }
    
    public function add($table, $data){
        $builder = $this->db->table($table);
        return $builder->insert($data);
    }
    
    public function delete($table,$kondisi){
        $this->db->where($kondisi);
        $delete = $this->db->delete($table);
        return $delete;
    }
    
    public function update($table, $data, $condition){
        $builder = $this->db->table($table);
        $builder->where($condition);
        return $builder->update($data);
    }
    
    public function select_max($tb_name, $kolom) {
        $builder = $this->db->table($tb_name);
        $builder->selectMax($kolom);
        $query = $builder->get();
        return $query;
    }
    
    public function select_min($tb_name, $kolom) {
        $builder = $this->db->table($tb_name);
        $builder->selectMin($kolom);
        $query = $builder->get();
        return $query;
    }
    
    public function select_avg($tb_name, $kolom) {
        $builder = $this->db->table($tb_name);
        $builder->selectAvg($kolom);
        $query = $builder->get();
        return $query;
    }
    
    public function select_sum($tb_name, $kolom) {
        $builder = $this->db->table($tb_name);
        $builder->selectSum($kolom);
        $query = $builder->get();
        return $query;
    }
    
    public function select_count($tb_name, $kolom) {
        $builder = $this->db->table($tb_name);
        $builder->selectCount($kolom);
        $query = $builder->countAllResults();
        return $query;
    }
    
    
}
