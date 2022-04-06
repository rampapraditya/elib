<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use App\Libraries\Nativesession;

/**
 * Description of Penelitian
 *
 * @author RAMPA
 */
class Penelitian extends BaseController {
    
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
            echo view('backend/penelitian/index');
            echo view('backend/foot');
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if($this->nativesession->get('logged_in')){
            $data = array();
            $list = $this->model->getAllQ("select a.idpenelitian, date_format(tanggal, '%d %M %Y') as tgl, time(tanggal) as waktu, a.judul, a.tahun, a.katakunci, b.nama_kategori, c.nama_sub_kat, a.strata from penelitian a, kategori_penelitian b, kategori_penelitian_sub c where a.idkategori = b.idkategori and a.idkat_p_sub = c.idkat_p_sub order by tanggal desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $row->tgl. ' '. $row->waktu;
                $val[] = $row->judul;
                $val[] = $row->tahun;
                $val[] = $row->nama_kategori;
                $val[] = $row->nama_sub_kat;
                $val[] = $row->strata;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-info btn-fw" onclick="doc('."'".$this->modul->enkrip_url($row->idpenelitian)."'".')">Dok</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="ganti('."'".$this->modul->enkrip_url($row->idpenelitian)."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus('."'".$row->idpenelitian."'".','."'".$row->judul."'".','."'".$row->tahun."'".')">Hapus</button>'
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
            $data['kategori'] = $this->model->getAll("kategori_penelitian");
            
            $temp = $this->request->uri->getSegment(3);
            if(strlen($temp) > 0){
                $kode = $this->modul->dekrip_url($temp);
                $jml = $this->model->getAllQR("select count(*) as jml from penelitian where idpenelitian = '".$kode."';")->jml;
                if($jml > 0){
                    $tersimpan = $this->model->getAllQR("select * from penelitian where idpenelitian = '".$kode."';");
                    
                    $data['kode'] = $tersimpan->idpenelitian;
                    $data['judul'] = $tersimpan->judul;
                    $data['tahun'] = $tersimpan->tahun;
                    $data['idkategori'] = $tersimpan->idkategori;
                    $data['katakunci'] = $tersimpan->katakunci;
                    $data['sinopsis'] = $tersimpan->sinopsis;
                    $data['sandi'] = $tersimpan->sandi;
                    $data['strata'] = $tersimpan->strata;
                    $data['penulis'] = $tersimpan->penulis;
                    $data['penerbit'] = $tersimpan->penerbit;
                
                    echo view('backend/head', $data);
                    echo view('backend/menu');
                    echo view('backend/penelitian/detil');
                    echo view('backend/foot');
            
                }else{
                    $this->modul->halaman("penelitian");
                }
            }else{
                $data['kode'] = $this->model->autokode("P","idpenelitian","penelitian", 2,7);
                $data['judul'] = "";
                $data['tahun'] = $this->modul->getTahun();
                $data['katakunci'] = "";
                $data['idkategori'] = "";
                $data['sinopsis'] = "";
                $data['sandi'] = "";
                $data['penulis'] = "";
                $data['penerbit'] = "";
                $data['strata'] = "Umum";
                
                echo view('backend/head', $data);
                echo view('backend/menu');
                echo view('backend/penelitian/detil');
                echo view('backend/foot');
            }
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if($this->nativesession->get('logged_in')){
            $mode = "simpan";
            $jml = $this->model->getAllQR("SELECT count(*) as jml FROM penelitian where idpenelitian = '".$this->request->getVar('kode')."';")->jml;
            if($jml > 0){
                $mode = "update";
            }

            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    if($mode == "simpan"){
                        $status = $this->simpan_dengan_gambar();
                    }else if($mode == "update"){
                        $status = $this->update_dengan_gambar();
                    }
                }
            }else{
                if($mode == "simpan"){
                    $status = "File thumbnail tidak ditemukan";
                }else if($mode == "update"){
                    $status = $this->update_tanpa_gambar();
                }
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function simpan_dengan_gambar() {
        $file = $this->request->getFile('file');
        $info_file = $this->modul->info_file($file);
        
        // cek nama file ada apa tidak
        if(file_exists(ROOTPATH.'public/uploads/'.$info_file['name'])){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move(ROOTPATH.'public/uploads');
            if($status_upload){
                $data = array(
                    'idpenelitian' => $this->model->autokode('P','idpenelitian', 'penelitian', 2, 7),
                    'tanggal' => $this->modul->TanggalWaktu(),
                    'judul' => $this->request->getVar('judul'),
                    'tahun' => $this->request->getVar('tahun'),
                    'katakunci' => $this->request->getVar('katakunci'),
                    'thumbnail' => $info_file['name'],
                    'sinopsis' => $this->request->getVar('ket'),
                    'idkategori' => $this->request->getVar('kategori'),
                    'idkat_p_sub' => $this->request->getVar('subkat'),
                    'sandi' => $this->request->getVar('sandi'),
                    'strata' => $this->request->getVar('strata'),
                    'penulis' => $this->request->getVar('penulis'),
                    'penerbit' => $this->request->getVar('penerbit')
                );
                $simpan = $this->model->add("penelitian",$data);
                if($simpan == 1){
                    $status = "Data tersimpan";
                }else{
                    $status = "Data gagal tersimpan";
                }
            }else{
                $status = "Data gagal terupload";
            }
        }
        
        return $status;
    }
    
    private function update_dengan_gambar() {
        $thumb = $this->model->getAllQR("select thumbnail from penelitian where idpenelitian = '".$this->request->getVar('kode')."';")->thumbnail;
        if(strlen($thumb) > 0){
            if(file_exists(ROOTPATH.'public/uploads/'.$thumb)){
                unlink(ROOTPATH.'public/uploads/'.$thumb);
            }
        }
        
        $file = $this->request->getFile('file');
        $info_file = $this->modul->info_file($file);
        
        // cek nama file ada apa tidak
        if(file_exists(ROOTPATH.'public/uploads/'.$info_file['name'])){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move(ROOTPATH.'public/uploads');
            if($status_upload){
                $data = array(
                    'tanggal' => $this->modul->TanggalWaktu(),
                    'judul' => $this->request->getVar('judul'),
                    'tahun' => $this->request->getVar('tahun'),
                    'katakunci' => $this->request->getVar('katakunci'),
                    'thumbnail' => $info_file['name'],
                    'sinopsis' => $this->request->getVar('ket'),
                    'idkategori' => $this->request->getVar('kategori'),
                    'idkat_p_sub' => $this->request->getVar('subkat'),
                    'sandi' => $this->request->getVar('sandi'),
                    'strata' => $this->request->getVar('strata'),
                    'penulis' => $this->request->getVar('penulis'),
                    'penerbit' => $this->request->getVar('penerbit')
                );
                $kond['idpenelitian'] = $this->request->getVar('kode');
                $update = $this->model->update("penelitian",$data,$kond);
                if($update == 1){
                    $status = "Data terupdate";
                }else{
                    $status = "Data gagal terupdate";
                }
            }else{
                $status = "Gagal upload data";
            }
        }
        
        return $status;
    }
    
    private function update_tanpa_gambar() {
        $data = array(
            'tanggal' => $this->modul->TanggalWaktu(),
            'judul' => $this->request->getVar('judul'),
            'tahun' => $this->request->getVar('tahun'),
            'katakunci' => $this->request->getVar('katakunci'),
            'sinopsis' => $this->request->getVar('ket'),
            'idkategori' => $this->request->getVar('kategori'),
            'idkat_p_sub' => $this->request->getVar('subkat'),
            'sandi' => $this->request->getVar('sandi'),
            'strata' => $this->request->getVar('strata'),
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit')
        );
        $kond['idpenelitian'] = $this->request->getVar('kode');
        $update = $this->model->update("penelitian",$data, $kond);
        if($update == 1){
            $status = "Data terupdate";
        }else{
            $status = "Data gagal terupdate";
        }
        return $status;
    }
    
    public function hapus() {
        if($this->nativesession->get('logged_in')){
            $idpenelitian = $this->uri->segment(3);
            $thumb = $this->model->getAllQR("select thumbnail from penelitian where idpenelitian = '".$idpenelitian."';")->thumbnail;
            if(strlen($thumb) > 0){
                if(file_exists($thumb)){
                    unlink($thumb);
                }
            }
            
            $kondisi['idpenelitian'] = $idpenelitian;
            $hapus = $this->model->delete("penelitian",$kondisi);
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
    
    public function dokumen() {
        if($this->nativesession->get('logged_in')){
            $ses = $this->nativesession->get('logged_in');
            $data['idusers'] = $ses['idusers'];
            $data['nrp'] = $ses['nrp'];
            $data['nama'] = $ses['nama'];
            $data['golongan'] = $ses['grup'];
            
            $temp = $this->request->uri->getSegment(3);
            if(strlen($temp) > 0){
                $kode = $this->modul->dekrip_url($temp);
                $jml = $this->model->getAllQR("select count(*) as jml from penelitian where idpenelitian = '".$kode."';")->jml;
                if($jml > 0){
                    $tersimpan = $this->model->getAllQR("select * from penelitian where idpenelitian = '".$kode."';");
                    
                    $data['kode'] = $tersimpan->idpenelitian;
                    $data['judul'] = $tersimpan->judul;
                
                    echo view('backend/head', $data);
                    echo view('backend/menu');
                    echo view('backend/penelitian/dokumen');
                    echo view('backend/foot');
            
                }else{
                    $this->modul->halaman("penelitian");
                }
            }else{
                $this->modul->halaman("penelitian");
            }
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function ajaxdokumen() {
        if($this->nativesession->get('logged_in')){
            $idpenelitian = $this->request->uri->getSegment(3);
            $data = array();
            $list = $this->model->getAllQ("select iddokumen, judul_dok, path from dokumen where idpenelitian = '".$idpenelitian."';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $row->judul_dok;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="unduh('."'".$row->iddokumen."'".')">Unduh</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus('."'".$row->iddokumen."'".','."'".$row->judul_dok."'".')">Hapus</button>'
                        . '</div>';
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses_dokumen() {
        if($this->nativesession->get('logged_in')){
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $status = $this->upload_dokumen();
                }
            }else{
                $status = "File pdf tidak ditemukan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function upload_dokumen() {
        $file = $this->request->getFile('file');
        $info_file = $this->modul->info_file($file);
        
        if(file_exists(ROOTPATH.'public/dokumen/'.$info_file['name'])){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move(ROOTPATH.'public/dokumen');
            if($status_upload){
                $data = array(
                    'iddokumen' => $this->model->autokode('D','iddokumen', 'dokumen', 2, 7),
                    'idpenelitian' => $this->request->getVar('kode'),
                    'judul_dok' => $this->request->getVar('judul'),
                    'path' => $info_file['name']
                );
                $simpan = $this->model->add("dokumen",$data);
                if($simpan == 1){
                    $status = "Dokumen tersimpan";
                }else{
                    $status = "Dokumen gagal tersimpan";
                }
            }else{
                $status = "Dokumen gagal terupload";
            }
        }
        
        return $status;
    }
    
    public function hapusdokumen() {
        if($this->nativesession->get('logged_in')){
            $iddokumen = $this->request->uri->getSegment(3);
            $path = $this->model->getAllQR("select path from dokumen where iddokumen = '".$iddokumen."';")->path;
            if(strlen($path) > 0){
                if(file_exists(ROOTPATH.'public/uploads/'.$path)){
                    unlink(ROOTPATH.'public/uploads/'.$path);
                }
            }
            
            $kondisi['iddokumen'] = $iddokumen;
            $hapus = $this->model->delete("dokumen",$kondisi);
            if($hapus == 1){
                $status = "Dokumen terhapus";
            }else{
                $status = "Dokumen gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function unduhfile() {
        if($this->nativesession->get('logged_in')){
            $kode = $this->request->uri->getSegment(3);
            $tmt2 = $this->model->getAllQR("select path from dokumen where iddokumen = '".$kode."';")->path;
            $this->response->download(ROOTPATH.'public/dokumen/'.$tmt2, null);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function getsubkat() {
        if($this->nativesession->get('logged_in')){
            $idkat = $this->request->uri->getSegment(3);
            $idpenelitian = $this->request->uri->getSegment(4);
            
            if($idkat == "-"){
                $str = '<option value="-">- PILIH SUB KATEGORI -</option>';
                $list = $this->model->getAllQ("SELECT idkat_p_sub, nama_sub_kat FROM kategori_penelitian_sub where idkategori = '".$idkat."';");
                foreach ($list->getResult() as $row) {
                    $str .= '<option value="'.$row->idkat_p_sub.'">'.$row->nama_sub_kat.'</option>';
                }
                echo json_encode(array("hasil" => $str));

                
                
            }else{
                $idsubkat = "";
                $cek = $this->model->getAllQR("select count(idkat_p_sub) as jml from penelitian where idpenelitian = '".$idpenelitian."';")->jml;
                if($cek > 0){
                    $idsubkat = $this->model->getAllQR("select idkat_p_sub from penelitian where idpenelitian = '".$idpenelitian."';")->idkat_p_sub;
                }
                

                $str = '<option value="-">- PILIH SUB KATEGORI -</option>';
                $list = $this->model->getAllQ("SELECT idkat_p_sub, nama_sub_kat FROM kategori_penelitian_sub where idkategori = '".$idkat."';");
                foreach ($list->getResult() as $row) {
                    if($row->idkat_p_sub == $idsubkat){
                        $str .= '<option selected value="'.$row->idkat_p_sub.'">'.$row->nama_sub_kat.'</option>';
                    }else{
                        $str .= '<option value="'.$row->idkat_p_sub.'">'.$row->nama_sub_kat.'</option>';
                    }
                }
                echo json_encode(array("hasil" => $str));

            }
        }else{
            $this->modul->halaman('login');
        }
    }
}
