<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use App\Libraries\Nativesession;

/**
 * Description of Berita
 *
 * @author rampa
 */
class Berita extends BaseController {
    
    private $model;
    private $modul;
    private $nativesession;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
        $this->nativesession = new Nativesession();
    }
    
    public function index() {
        if($this->nativesession->get('logged_in')){
            $ses = $this->nativesession->get('logged_in');
            $data['idusers'] = $ses['idusers'];
            $data['nrp'] = $ses['nrp'];
            $data['nama'] = $ses['nama'];
            $data['golongan'] = $ses['grup'];
            
            echo view('backend/head', $data);
            echo view('backend/menu');
            echo view('backend/berita/index');
            echo view('backend/foot');
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if($this->nativesession->get('logged_in')){
            $data = array();
            $list = $this->model->getAllQ("select *, date_format(tanggal, '%d-%m-%Y') as tgl from blog order by idblog desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $def = base_url().'/assets/img/noimg.jpg';
                if(strlen($row->thumb) > 0){
                    if(file_exists($row->thumb)){
                        $def = base_url().substr($row->thumb, 1);
                    }
                }
                $val[] = '<img src="'.$def.'" style="width: 60px; height: auto;">';
                $val[] = $row->tgl;
                $val[] = $row->judul;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="ganti('."'".$this->modul->enkrip_url($row->idblog)."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus('."'".$row->idblog."'".','."'".$row->judul."'".')">Hapus</button>'
                        . '</div>';
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function detil() {
        if($this->nativesession->get('logged_in')){
            $ses = $this->nativesession->get('logged_in');
            $data['idusers'] = $ses['idusers'];
            $data['nrp'] = $ses['nrp'];
            $data['nama'] = $ses['nama'];
            $data['golongan'] = $ses['grup'];
            
            $temp = $this->uri->segment(3);
            if(strlen($temp) > 0){
                $kode = $this->modul->dekrip_url($temp);
                $jml = $this->model->getAllQR("select count(*) as jml from blog where idblog = '".$kode."';")->jml;
                if($jml > 0){
                    $tersimpan = $this->model->getAllQR("select * from blog where idblog = '".$kode."';");
                    
                    $data['kode'] = $tersimpan->idblog;
                    $data['mode'] = "GANTI";
                    $data['judul'] = $tersimpan->judul;
                    $data['berita'] = $tersimpan->konten;

                    $this->load->view('backend/head', $data);
                    $this->load->view('backend/menu');
                    $this->load->view('backend/berita/detil');
                    $this->load->view('backend/foot');
                }else{
                    $this->modul->halaman('berita');
                }
            }else{
                $data['kode'] = $this->model->autokode("B","idblog","blog",2,7);
                $data['mode'] = "TAMBAH";
                $data['judul'] = "";
                $data['berita'] = "";
                
                $this->load->view('backend/head', $data);
                $this->load->view('backend/menu');
                $this->load->view('backend/berita/detil');
                $this->load->view('backend/foot');
            }
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if($this->nativesession->get('logged_in')){
            $config['upload_path'] = './assets/temp/';
            $config['upload_newpath'] = './assets/img/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_filename'] = '255';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '3024'; //3 MB
            
            $mode = $this->input->post('mode');
            if($mode == "TAMBAH"){
                if (isset($_FILES['file']['name'])) {
                    if(0 < $_FILES['file']['error']) {
                        $status = "Error during file upload ".$_FILES['file']['error'];
                    }else{
                        $status = $this->simpan_dengan_gambar($config);
                    }
                }else{
                    $status = $this->simpan_tanpa_gambar();
                }
            }else if($mode == "GANTI"){
                if (isset($_FILES['file']['name'])) {
                    if(0 < $_FILES['file']['error']) {
                        $status = "Error during file upload ".$_FILES['file']['error'];
                    }else{
                        $status = $this->update_dengan_gambar($config);
                    }
                }else{
                    $status = $this->update_tanpa_gambar();
                }
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function simpan_dengan_gambar($config) {
        $ses = $this->nativesession->get('logged_in');
        $idusers = $ses['idusers'];
            
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {

            $datafile = $this->upload->data();
            $path = $config['upload_path'].$datafile['file_name'];
            $newpath = $config['upload_newpath'].$datafile['file_name'];

            $resize_foto = $this->resizeImage($path, $newpath);
            if($resize_foto){
                $data = array(
                    'idblog' => $this->model->autokode('B','idblog', 'blog', 2, 7),
                    'tanggal' => $this->modul->TanggalSekarang(),
                    'judul' => $this->input->post('judul'),
                    'konten' => $this->input->post('konten'),
                    'idusers' => $idusers,
                    'thumb' => $newpath
                );
                $simpan = $this->model->add("blog",$data);
                if($simpan == 1){
                    unlink($path);
                    $status = "Berita tersimpan";
                }else{
                    $status = "Berita gagal tersimpan";
                }
            }else{
                $status = "Resize foto gagal";
            }
        } else {
            $status = $this->upload->display_errors();
        }
        return $status;
    }
    
    private function simpan_tanpa_gambar() {
        $ses = $this->nativesession->get('logged_in');
        $idusers = $ses['idusers'];
        
        $data = array(
            'idblog' => $this->model->autokode('B','idblog', 'blog', 2, 7),
            'tanggal' => $this->modul->TanggalSekarang(),
            'judul' => $this->input->post('judul'),
            'konten' => $this->input->post('konten'),
            'idusers' => $idusers
        );
        $simpan = $this->model->add("blog",$data);
        if($simpan == 1){
            $status = "Berita tersimpan";
        }else{
            $status = "Berita gagal tersimpan";
        }
        return $status;
    }
    
    private function update_dengan_gambar($config) {
        $ses = $this->nativesession->get('logged_in');
        $idusers = $ses['idusers'];
        
        $thumb = $this->model->getAllQR("select thumb from blog where idblog = '".$this->input->post('kode')."';")->thumb;
        if(strlen($thumb) > 0){
            if(file_exists($thumb)){
                unlink($thumb);
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
                    'judul' => $this->input->post('judul'),
                    'konten' => $this->input->post('konten'),
                    'idusers' => $idusers,
                    'thumb' => $newpath
                );
                $kond['idblog'] = $this->input->post('kode');
                $simpan = $this->model->update("blog",$data,$kond);
                if($simpan == 1){
                    unlink($path);
                    $status = "Berita terupdate";
                }else{
                    $status = "Berita gagal terupdate";
                }
            }else{
                $status = "Resize foto gagal";
            }
        } else {
            $status = $this->upload->display_errors();
        }
        return $status;
    }
    
    private function update_tanpa_gambar() {
        $ses = $this->nativesession->get('logged_in');
        $idusers = $ses['idusers'];
        
        $data = array(
            'judul' => $this->input->post('judul'),
            'konten' => $this->input->post('konten'),
            'idusers' => $idusers
        );
        $kond['idblog'] = $this->input->post('kode');
        $simpan = $this->model->update("blog",$data,$kond);
        if($simpan == 1){
            $status = "Berita terupdate";
        }else{
            $status = "Berita gagal terupdate";
        }
        return $status;
    }
    
    public function hapus() {
        if($this->nativesession->get('logged_in')){
            $idblog = $this->uri->segment(3);
            
            $thumb = $this->model->getAllQR("select thumb from blog where idblog = '".$idblog."';")->thumb;
            if(strlen($thumb) > 0){
                if(file_exists($thumb)){
                    unlink($thumb);
                }
            }
            
            $kond['idblog'] = $idblog;
            $hapus = $this->model->delete("blog", $kond);
            if($hapus == 1){
                $status = "Berita terhapus";
            }else{
                $status = "Berita gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function resizeImage($path, $newpath){
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $path,
            'new_image' => $newpath,
            'maintain_ratio' => FALSE,
            'width' => 1024,
            'height' => 768
        );
        $this->load->library('image_lib', $config_manip);
        $hasil = $this->image_lib->resize();
        $this->image_lib->clear();
        return $hasil;
    }
}
