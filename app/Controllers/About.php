<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use App\Libraries\Nativesession;

/**
 * Description of About
 *
 * @author rampa
 */
class About extends BaseController{
    
    private $model;
    private $modul;
    private $nativesession;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
        $this->nativesession = new Nativesession();
    }
    
    public function index(){
        if($this->nativesession->get('logged_in')){
            $ses = $this->nativesession->get('logged_in');
            $data['idusers'] = $ses['idusers'];
            $data['nrp'] = $ses['nrp'];
            $data['nama'] = $ses['nama'];
            $data['golongan'] = $ses['grup'];
            $data['slider'] = $this->model->getAll("slider_tentang");
            $data['jmlslider'] = $this->model->getAllQR("select count(*) as jml from slider_tentang")->jml;
            
            echo view('backend/head', $data);
            echo view('backend/menu');
            echo view('backend/front/about');
            echo view('backend/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxslider() {
        if($this->nativesession->get('logged_in')){
            $data = array();
            
            $no = 1;
            $list = $this->model->getAll("slider_tentang");
            foreach ($list->getResult() as $row) {
                $val = array();
                $def = base_url().'/assets/img/noimg.jpg';
                if(strlen($row->path)){
                    if(file_exists($row->path)){
                        $def = base_url().substr($row->path, 1);
                    }
                }
                $val[] = $no;
                $val[] = '<img src="'.$def.'" style="width: 70px; height: auto;">';
                $val[] = $row->judul;
                $val[] = $row->keterangan;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="ganti('."'".$row->idslider_tentang."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus('."'".$row->idslider_tentang."'".','."'".$no."'".')">Hapus</button>'
                        . '</div>';
                $data[] = $val;
                
                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function loaddata() {
        if($this->nativesession->get('logged_in')){
            $jml = $this->model->getAllQR("select count(*) as jml from tentang;")->jml;
            if($jml > 0){
                $tersimpan = $this->model->getAllQR("select * from tentang;");
                $pesan = $tersimpan->pesan;
            }else{
                $pesan = "";
            }
            echo json_encode(array("pesan" => $pesan));
        }else{
            $this->modul->halaman('login');
        }   
    }
    
    public function proses() {
        if($this->nativesession->get('logged_in')){
            $mode = "simpan";
            $jml = $this->model->getAllQR("SELECT count(*) as jml FROM tentang;")->jml;
            if($jml > 0){
                $mode = "update";
            }

            if($mode == "simpan"){
                $status = $this->simpan_tanpa_foto();
            }else if($mode == "update"){
                $status = $this->update_tanpa_foto();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function simpan_tanpa_foto() {
        $data = array(
            'idtentang' => $this->model->autokode("T","idtentang","tentang", 2, 7),
            'pesan' => $this->request->getVar('pesan')
        );
        $simpan = $this->model->add("tentang",$data);
        if($simpan == 1){
            $status = "Data tersimpan";
        }else{
            $status = "Data gagal tersimpan";
        }
        return $status;
    }
    
    private function update_tanpa_foto() {
        $data = array(
            'pesan' => $this->request->getVar('pesan')
        );
        $update = $this->model->updateNK("tentang",$data);
        if($update == 1){
            $status = "Data terupdate";
        }else{
            $status = "Data gagal terupdate";
        }
        return $status;
    }
    
    public function simpan_slider() {
        if($this->nativesession->get('logged_in')){
            $config['upload_path'] = './assets/temp/';
            $config['upload_newpath'] = './assets/img/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_filename'] = '255';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '3024'; //3 MB
            
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $status = $this->simpandenganfoto($config);
                }
            }else{
                $status = "File tidak ditemukan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function simpandenganfoto($config) {
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {

            $datafile = $this->upload->data();
            $path = $config['upload_path'].$datafile['file_name'];
            $newpath = $config['upload_newpath'].$datafile['file_name'];

            $resize_foto = $this->resizeImage($path, $newpath);
            if($resize_foto){
                $data = array(
                    'idslider_tentang' => $this->model->autokode('S','idslider_tentang', 'slider_tentang', 2, 7),
                    'path' => $newpath,
                    'judul' => $this->request->getVar('judul'),
                    'keterangan' => $this->request->getVar('ket')
                );
                $simpan = $this->model->add("slider_tentang",$data);
                if($simpan == 1){
                    unlink($path);
                    $status = "Data tersimpan";
                }else{
                    $status = "Data gagal tersimpan";
                }
            }else{
                $status = "Resize foto gagal";
            }
        } else {
            $status = $this->upload->display_errors();
        }
        return $status;
    }
    
    public function ganti_slider() {
        if($this->nativesession->get('logged_in')){
            $config['upload_path'] = './assets/temp/';
            $config['upload_newpath'] = './assets/img/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_filename'] = '255';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '3024'; //3 MB
            
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $status = $this->update_slider_dengan_foto($config);
                }
            }else{
                $status = $this->update_slider_tanpa_foto();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function update_slider_dengan_foto($config) {
        $lawas = $this->model->getAllQR("SELECT path FROM slider_tentang where idslider_tentang = '".$this->request->getVar('kode')."';")->path;
        if(strlen($lawas) > 0){
            if(file_exists($lawas)){
                unlink($lawas);
            }
        }
        
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {

            $datafile = $this->upload->data();
            $path = $config['upload_path'].$datafile['file_name'];
            $newpath = $config['upload_newpath'].$datafile['file_name'];

            $resize_foto = $this->resizeImage($path, $newpath);
            if($resize_foto){
                $data = array(
                    'path' => $newpath,
                    'judul' => $this->request->getVar('judul'),
                    'keterangan' => $this->request->getVar('ket')
                );
                $kond['idslider_tentang'] = $this->request->getVar('kode');
                $update = $this->model->update("slider_tentang",$data,$kond);
                if($update == 1){
                    unlink($path);
                    $status = "Data terupdate";
                }else{
                    $status = "Data gagal terupdate";
                }
            }else{
                $status = "Resize foto gagal";
            }
        } else {
            $status = $this->upload->display_errors();
        }
        return $status;
    }
    
    private function update_slider_tanpa_foto() {
        $data = array(
            'judul' => $this->request->getVar('judul'),
            'keterangan' => $this->request->getVar('ket')
        );
        $kond['idslider_tentang'] = $this->request->getVar('kode');
        $update = $this->model->update("slider_tentang",$data,$kond);
        if($update == 1){
            $status = "Data terupdate";
        }else{
            $status = "Data gagal terupdate";
        }
        return $status;
    }
    
    private function resizeImage($path, $newpath){
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $path,
            'new_image' => $newpath,
            'maintain_ratio' => FALSE,
            'width' => 800,
            'height' => 600
        );
        $this->load->library('image_lib', $config_manip);
        $hasil = $this->image_lib->resize();
        $this->image_lib->clear();
        return $hasil;
    }
    
    public function showslider(){
        if($this->nativesession->get('logged_in')){
            $kondisi['idslider_tentang'] = $this->uri->segment(3);
            $data = $this->model->get_by_id("slider_tentang", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function hapusslider() {
        if($this->nativesession->get('logged_in')){
            $idslider_tentang = $this->uri->segment(3);
            
            $lawas = $this->model->getAllQR("SELECT path FROM slider_tentang where idslider_tentang = '".$idslider_tentang."';")->path;
            if(strlen($lawas) > 0){
                if(file_exists($lawas)){
                    unlink($lawas);
                }
            }
            
            $kondisi['idslider_tentang'] = $idslider_tentang;
            $hapus = $this->model->delete("slider_tentang",$kondisi);
            if($hapus == 1){
                $status = "Data terhapus";
            }else{
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
