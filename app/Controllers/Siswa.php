<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use App\Libraries\Nativesession;

/**
 * Description of Siswa
 *
 * @author RAMPA
 */
class Siswa extends BaseController {
    
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
            
            $data['korps'] = $this->model->getAll("korps");
            $data['pangkat'] = $this->model->getAllQ("select * from pangkat where idpangkat <> 'P00001';");
            
            echo view('backend/head', $data);
            echo view('backend/menu');
            echo view('backend/pengguna/index');
            echo view('backend/foot');
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if($this->nativesession->get('logged_in')){
            $data = array();
            $list = $this->model->getAllQ("select a.*, b.nama_pangkat, c.nama_korps from pengguna a, pangkat b, korps c where a.idpangkat = b.idpangkat and a.idkorps = c.idkorps;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $row->nrp;
                $val[] = $row->nama_pangkat.' '.$row->nama;
                $val[] = $row->email;
                $val[] = $row->nama_korps;
                $val[] = $this->modul->dekrip_pass($row->pass);
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="ganti('."'".$row->idsiswa."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus('."'".$row->idsiswa."'".','."'".$row->nama."'".')">Hapus</button>'
                        . '</div>';
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_add() {
        if($this->nativesession->get('logged_in')){
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $status = $this->simpan_dengan_gambar();
                }
            }else{
                $status = $this->simpan_tanpa_gambar();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function simpan_tanpa_gambar() {
        $nrp = $this->request->getVar('nrp');
        $cek = $this->model->getAllQR("select count(*) as jml from pengguna where nrp = '".$nrp."';")->jml;
        if($cek > 0){
            $status = "Gunakan NRP lain";
        }else{
            $data = array(
                'idsiswa' => $this->model->autokode("S","idsiswa","pengguna", 2, 7),
                'nama' => $this->request->getVar('nama'),
                'nrp' => $this->request->getVar('nrp'),
                'email' => $this->request->getVar('email'),
                'idpangkat' => $this->request->getVar('pangkat'),
                'idkorps' => $this->request->getVar('korps'),
                'pass' => $this->modul->enkrip_pass($this->request->getVar('pass'))
            );
            $simpan = $this->model->add("pengguna",$data);
            if($simpan == 1){
                $status = "Data tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
        }
        
        return $status;
    }
    
    private function simpan_dengan_gambar() {
        $nrp = $this->request->getVar('nrp');
        $cek = $this->model->getAllQR("select count(*) as jml from pengguna where nrp = '".$nrp."';")->jml;
        if($cek > 0){
            $status = "Gunakan NRP lain";
        }else{
            
            $file = $this->request->getFile('file');
            $info_file = $this->modul->info_file($file);

            if(file_exists(ROOTPATH.'public/uploads/'.$info_file['name'])){
                $status = "Gunakan nama file lain";
            }else{
                $status_upload = $file->move(ROOTPATH.'public/uploads');
                if($status_upload){
                    $data = array(
                        'idsiswa' => $this->model->autokode("S","idsiswa","pengguna", 2, 7),
                        'nama' => $this->request->getVar('nama'),
                        'nrp' => $this->request->getVar('nrp'),
                        'email' => $this->request->getVar('email'),
                        'idpangkat' => $this->request->getVar('pangkat'),
                        'idkorps' => $this->request->getVar('korps'),
                        'foto' => $info_file['name'],
                        'pass' => $this->modul->enkrip_pass($this->request->getVar('pass'))
                    );
                    $simpan = $this->model->add("pengguna",$data);
                    if($simpan == 1){
                        $status = "Data tersimpan";
                    }else{
                        $status = "Data gagal tersimpan";
                    }
                }else{
                    $status = "Gagal upload file";
                }
            }
        }
        return $status;
    }
    
    public function ganti(){
        if($this->nativesession->get('logged_in')){
            $kondisi['idsiswa'] = $this->request->uri->getSegment(3);
            $data = $this->model->get_by_id("pengguna", $kondisi);
            echo json_encode(
                    array(
                        "idsiswa" => $data->idsiswa,
                        "nrp" => $data->nrp,
                        "nama" => $data->nama,
                        "email" => $data->email,
                        "idpangkat" => $data->idpangkat,
                        "idkorps" => $data->idkorps,
                        "pass" => $this->modul->dekrip_pass($data->pass)
                    ));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if($this->nativesession->get('logged_in')){
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $status = $this->update_dengan_gambar();
                }
            }else{
                $status = $this->update_tanpa_gambar();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function update_dengan_gambar() {
        $foto = $this->model->getAllQR("select foto from pengguna where idsiswa = '".$this->request->getVar('kode')."';")->foto;
        if(strlen($foto) > 0){
            if(file_exists(ROOTPATH.'public/upload/'.$foto)){
                unlink(ROOTPATH.'public/upload/'.$foto);
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
                    'nama' => $this->request->getVar('nama'),
                    'nrp' => $this->request->getVar('nrp'),
                    'email' => $this->request->getVar('email'),
                    'idpangkat' => $this->request->getVar('pangkat'),
                    'idkorps' => $this->request->getVar('korps'),
                    'foto' => $info_file['name'],
                    'pass' => $this->modul->enkrip_pass($this->request->getVar('pass'))
                );
                $kond['idsiswa'] = $this->request->getVar('kode');
                $update = $this->model->update("pengguna",$data, $kond);
                if($update == 1){
                    $status = "Data terupdate";
                }else{
                    $status = "Data gagal terupdate";
                }
            }else{
                $status = "Gagal upload file";
            }
        }
        return $status;
    }
    
    private function update_tanpa_gambar() {
        $data = array(
            'nama' => $this->request->getVar('nama'),
            'nrp' => $this->request->getVar('nrp'),
            'email' => $this->request->getVar('email'),
            'idpangkat' => $this->request->getVar('pangkat'),
            'idkorps' => $this->request->getVar('korps'),
            'pass' => $this->modul->enkrip_pass($this->request->getVar('pass'))
        );
        $kond['idsiswa'] = $this->request->getVar('kode');
        $update = $this->model->update("pengguna",$data,$kond);
        if($update == 1){
            $status = "Data terupdate";
        }else{
            $status = "Data gagal terupdate";
        }
        return $status;
    }
    
    public function hapus() {
        if($this->nativesession->get('logged_in')){
            $idsiswa = $this->request->uri->getSegment(3);
            $foto = $this->model->getAllQR("select foto from pengguna where idsiswa = '".$idsiswa."';")->foto;
            if(strlen($foto) > 0){
                if(file_exists(ROOTPATH.'public/uploads/'.$foto)){
                    unlink(ROOTPATH.'public/uploads/'.$foto);
                }
            }
            
            $kondisi['idsiswa'] = $idsiswa;
            $hapus = $this->model->delete("pengguna",$kondisi);
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
    
    private function resizeImage($path, $newpath){
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $path,
            'new_image' => $newpath,
            'maintain_ratio' => TRUE,
            'width' => 150,
            'height' => 150
        );
        $this->load->library('image_lib', $config_manip);
        $hasil = $this->image_lib->resize();
        $this->image_lib->clear();
        return $hasil;
    }
}
