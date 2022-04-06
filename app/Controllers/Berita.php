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
                    if(file_exists(ROOTPATH.'public/uploads/'.$row->thumb)){
                        $def = base_url().'/uploads/'.$row->thumb;
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
            
            $temp = $this->request->uri->getSegment(3);
            if(strlen($temp) > 0){
                $kode = $this->modul->dekrip_url($temp);
                $jml = $this->model->getAllQR("select count(*) as jml from blog where idblog = '".$kode."';")->jml;
                if($jml > 0){
                    $tersimpan = $this->model->getAllQR("select * from blog where idblog = '".$kode."';");
                    
                    $data['kode'] = $tersimpan->idblog;
                    $data['mode'] = "GANTI";
                    $data['judul'] = $tersimpan->judul;
                    $data['berita'] = $tersimpan->konten;

                    echo view('backend/head', $data);
                    echo view('backend/menu');
                    echo view('backend/berita/detil');
                    echo view('backend/foot');
                }else{
                    $this->modul->halaman('berita');
                }
            }else{
                $data['kode'] = $this->model->autokode("B","idblog","blog",2,7);
                $data['mode'] = "TAMBAH";
                $data['judul'] = "";
                $data['berita'] = "";
                
                echo view('backend/head', $data);
                echo view('backend/menu');
                echo view('backend/berita/detil');
                echo view('backend/foot');
            }
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if($this->nativesession->get('logged_in')){
            $mode = $this->request->getVar('mode');
            if($mode == "TAMBAH"){
                if (isset($_FILES['file']['name'])) {
                    if(0 < $_FILES['file']['error']) {
                        $status = "Error during file upload ".$_FILES['file']['error'];
                    }else{
                        $status = $this->simpan_dengan_gambar();
                    }
                }else{
                    $status = $this->simpan_tanpa_gambar();
                }
            }else if($mode == "GANTI"){
                if (isset($_FILES['file']['name'])) {
                    if(0 < $_FILES['file']['error']) {
                        $status = "Error during file upload ".$_FILES['file']['error'];
                    }else{
                        $status = $this->update_dengan_gambar();
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
    
    private function simpan_dengan_gambar() {
        $ses = $this->nativesession->get('logged_in');
        $idusers = $ses['idusers'];

        $file = $this->request->getFile('file');
        $info_file = $this->modul->info_file($file);
        
        if(file_exists(ROOTPATH.'public/uploads/'.$info_file['name'])){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move(ROOTPATH.'public/uploads');
            if($status_upload){
                $data = array(
                    'idblog' => $this->model->autokode('B','idblog', 'blog', 2, 7),
                    'tanggal' => $this->modul->TanggalSekarang(),
                    'judul' => $this->request->getVar('judul'),
                    'konten' => $this->request->getVar('konten'),
                    'idusers' => $idusers,
                    'thumb' => $info_file['name']
                );
                $simpan = $this->model->add("blog",$data);
                if($simpan == 1){
                    $status = "Berita tersimpan";
                }else{
                    $status = "Berita gagal tersimpan";
                }
            }else{
                $status = "File gagal terupload";
            }
        }
                
        return $status;
    }
    
    private function simpan_tanpa_gambar() {
        $ses = $this->nativesession->get('logged_in');
        $idusers = $ses['idusers'];
        
        $data = array(
            'idblog' => $this->model->autokode('B','idblog', 'blog', 2, 7),
            'tanggal' => $this->modul->TanggalSekarang(),
            'judul' => $this->request->getVar('judul'),
            'konten' => $this->request->getVar('konten'),
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
    
    private function update_dengan_gambar() {
        $ses = $this->nativesession->get('logged_in');
        $idusers = $ses['idusers'];
        
        $thumb = $this->model->getAllQR("select thumb from blog where idblog = '".$this->request->getVar('kode')."';")->thumb;
        if(strlen($thumb) > 0){
            if(file_exists(ROOTPATH.'public/uploads/'.$thumb)){
                unlink(ROOTPATH.'public/uploads/'.$thumb);
            }
        }
        
        $file = $this->request->getFile('file');
        $info_file = $this->modul->info_file($file);
        
        if(file_exists(ROOTPATH.'public/uploads/'.$info_file['name'])){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move(ROOTPATH.'public/uploads');
            if($status_upload){
                $data = array(
                    'judul' => $this->request->getVar('judul'),
                    'konten' => $this->request->getVar('konten'),
                    'idusers' => $idusers,
                    'thumb' => $info_file['name']
                );
                $kond['idblog'] = $this->request->getVar('kode');
                $simpan = $this->model->update("blog",$data,$kond);
                if($simpan == 1){
                    $status = "Berita terupdate";
                }else{
                    $status = "Berita gagal terupdate";
                }
            }else{
                $status = "File gagal terupload";
            }
        }
                
        return $status;
    }
    
    private function update_tanpa_gambar() {
        $ses = $this->nativesession->get('logged_in');
        $idusers = $ses['idusers'];
        
        $data = array(
            'judul' => $this->request->getVar('judul'),
            'konten' => $this->request->getVar('konten'),
            'idusers' => $idusers
        );
        $kond['idblog'] = $this->request->getVar('kode');
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
            $idblog = $this->request->uri->getSegment(3);
            
            $thumb = $this->model->getAllQR("select thumb from blog where idblog = '".$idblog."';")->thumb;
            if(strlen($thumb) > 0){
                if(file_exists(ROOTPATH.'public/uploads/'.$thumb)){
                    unlink(ROOTPATH.'public/uploads/'.$thumb);
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
