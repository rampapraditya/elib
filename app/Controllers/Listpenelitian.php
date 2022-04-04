<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

/**
 * Description of Listpenelitian
 *
 * @author RAMPA
 */
class Listpenelitian extends BaseController {

    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index() {
        $jml_identitas = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
        if($jml_identitas > 0){
            $tersimpan_iden = $this->model->getAllQR("SELECT logo, alamat, email, tlp FROM identitas;");
            $logo = base_url().'assets/images/no_image.png';
            if(strlen($tersimpan_iden->logo) > 0){
                if(file_exists($tersimpan_iden->logo)){
                    $logo = base_url().substr($tersimpan_iden->logo, 2);
                }
            }
            $data['logo'] = $logo;
            $data['alamat'] = $tersimpan_iden->alamat;
            $data['tlp'] = $tersimpan_iden->tlp;
            $data['email'] = $tersimpan_iden->email;
            
        }else{
            $data['logo'] = base_url().'assets/images/no_image.png';
            $data['alamat'] = '';
            $data['tlp'] = '';
            $data['email'] = '';
        }
        
        // about
        $jml_tentang = $this->model->getAllQR("SELECT count(*) as jml FROM tentang;")->jml;
        if($jml_tentang > 0){
            $tersimpan_tentang = $this->model->getAllQR("select * from tentang;");
            $data['tentang'] = $tersimpan_tentang->pesan;
        }else{
            $data['tentang'] = "";
        }
        
        // media sosial
        $jml = $this->model->getAllQR("select count(*) as jml from medsos")->jml;
        if($jml > 0){
            $tersimpan_med = $this->model->getAllQR("select * from medsos");
            $data['tw'] = $tersimpan_med->tw;
            $data['ig'] = $tersimpan_med->ig;
            $data['fb'] = $tersimpan_med->fb;
            $data['lk'] = $tersimpan_med->lk;
            
        }else{
            $data['tw'] = "";
            $data['ig'] = "";
            $data['fb'] = "";
            $data['lk'] = "";
        }
        // kelas
        $data['kelas'] = $this->model->getAll("kategori_penelitian_sub");
        // kategori penelitian
        $data['kategori'] = $this->model->getAll("kategori_penelitian");
        
        $data['judul'] = "";
        $data['katakunci'] = "";
        $data['nilaikelas'] = "";
        $data['nilaikategori'] = "";
        
        // penelitian
        $data['penelitian'] = $this->model->getAllQ("select * from penelitian order by tanggal desc limit 50;");
        
        echo view('frontend/listpenelitian', $data);
    }
    
    public function cari() {
        
        // identitas
        $jml_identitas = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
        if($jml_identitas > 0){
            $tersimpan_iden = $this->model->getAllQR("SELECT logo, alamat, email, tlp FROM identitas;");
            $logo = base_url().'/assets/images/no_image.png';
            if(strlen($tersimpan_iden->logo) > 0){
                if(file_exists($tersimpan_iden->logo)){
                    $logo = base_url().substr($tersimpan_iden->logo, 1);
                }
            }
            $data['logo'] = $logo;
            $data['alamat'] = $tersimpan_iden->alamat;
            $data['tlp'] = $tersimpan_iden->tlp;
            $data['email'] = $tersimpan_iden->email;
            
        }else{
            $data['logo'] = base_url().'/assets/images/no_image.png';
            $data['alamat'] = '';
            $data['tlp'] = '';
            $data['email'] = '';
        }
        
        // about
        $jml_tentang = $this->model->getAllQR("SELECT count(*) as jml FROM tentang;")->jml;
        if($jml_tentang > 0){
            $tersimpan_tentang = $this->model->getAllQR("select * from tentang;");
            $data['tentang'] = $tersimpan_tentang->pesan;
        }else{
            $data['tentang'] = "";
        }
        
        // media sosial
        $jml = $this->model->getAllQR("select count(*) as jml from medsos")->jml;
        if($jml > 0){
            $tersimpan_med = $this->model->getAllQR("select * from medsos");
            $data['tw'] = $tersimpan_med->tw;
            $data['ig'] = $tersimpan_med->ig;
            $data['fb'] = $tersimpan_med->fb;
            $data['lk'] = $tersimpan_med->lk;
            
        }else{
            $data['tw'] = "";
            $data['ig'] = "";
            $data['fb'] = "";
            $data['lk'] = "";
        }
        // kelas
        $data['kelas'] = $this->model->getAll("kategori_penelitian_sub");
        // kategori penelitian
        $data['kategori'] = $this->model->getAll("kategori_penelitian");
        // penelitian
        $judul = $this->request->getVar('judul');
        $katakunci = $this->request->getVar('katakunci');
        $strata = $this->request->getVar('strata');
        $inputkategori = $this->request->getVar('kategori');
        
        $data['judul'] = $judul;
        $data['katakunci'] = $katakunci;
        $data['strata'] = $strata;
        $data['nilaikategori'] = $inputkategori;
        
        $data['penelitian'] = $this->model->getAllQ("select a.* from penelitian a where a.judul like '%".$judul."%' and a.katakunci like '%".$katakunci."%' and a.idkategori like '%".$inputkategori."%' and a.strata like '%".$strata."%' order by a.tanggal desc limit 50;");
        
        
        echo view('frontend/listpenelitian', $data);
    }
}
