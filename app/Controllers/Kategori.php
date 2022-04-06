<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use App\Libraries\Nativesession;

/**
 * Description of Kategori
 *
 * @author rampa
 */
class Kategori extends BaseController {
    
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
            echo view('backend/kategori_penelitian/index');
            echo view('backend/foot');
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if($this->nativesession->get('logged_in')){
            $data = array();
            $list = $this->model->getAll("kategori_penelitian");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $row->nama_kategori;
                $list1 = $this->model->getAllQ("SELECT nama_sub_kat FROM kategori_penelitian_sub where idkategori = '".$row->idkategori."';");
                $detil = '<table class="table table-hover" style="width: 100%;">
                            <tbody>';
                foreach ($list1->getResult() as $row1) {
                    $detil .= '<tr>';
                    $detil .= '<td>'.$row1->nama_sub_kat.'</td>';
                    $detil .= '</tr>';
                }
                $detil .= '</tbody></table>';
                $val[] = $detil;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-info btn-fw" onclick="subkat('."'".$this->modul->enkrip_url($row->idkategori)."'".')">Sub</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="ganti('."'".$row->idkategori."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus('."'".$row->idkategori."'".','."'".$row->nama_kategori."'".')">Hapus</button>'
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
            $data = array(
                'idkategori' => $this->model->autokode("K","idkategori","kategori_penelitian", 2, 7),
                'nama_kategori' => $this->request->getVar('nama')
            );
            $simpan = $this->model->add("kategori_penelitian",$data);
            if($simpan == 1){
                $status = "Data tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ganti(){
        if($this->nativesession->get('logged_in')){
            $kondisi['idkategori'] = $this->request->uri->getSegment(3);
            $data = $this->model->get_by_id("kategori_penelitian", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if($this->nativesession->get('logged_in')){
            $data = array(
                'nama_kategori' => $this->request->getVar('nama')
            );
            $kond['idkategori'] = $this->request->getVar('kode');
            $update = $this->model->update("kategori_penelitian",$data, $kond);
            if($update == 1){
                $status = "Data terupdate";
            }else{
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function hapus() {
        if($this->nativesession->get('logged_in')){
            $kondisi['idkategori'] = $this->request->uri->getSegment(3);
            $hapus = $this->model->delete("kategori_penelitian",$kondisi);
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
    
    public function detil() {
        if($this->nativesession->get('logged_in')){
            $ses = $this->nativesession->get('logged_in');
            $data['idusers'] = $ses['idusers'];
            $data['nrp'] = $ses['nrp'];
            $data['nama'] = $ses['nama'];
            $data['golongan'] = $ses['grup'];
            
            $idkat = $this->modul->dekrip_url($this->request->uri->getSegment(3));
            $jml = $this->model->getAllQR("select count(*) as jml from kategori_penelitian where idkategori = '".$idkat."';")->jml;
            if($jml > 0){
                $data['idkat'] = $idkat;
                $data['namakat'] = $this->model->getAllQR("select nama_kategori from kategori_penelitian where idkategori = '".$idkat."';")->nama_kategori;
                
                echo view('backend/head', $data);
                echo view('backend/menu');
                echo view('backend/kategori_penelitian/detil');
                echo view('backend/foot');
            }else{
                $this->modul->halaman('kategori');
            }
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function ajaxdetil() {
        if($this->nativesession->get('logged_in')){
            $idkat = $this->request->uri->getSegment(3);
            // load data
            $data = array();
            $list = $this->model->getAllQ("SELECT * FROM kategori_penelitian_sub where idkategori = '".$idkat."';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $row->nama_sub_kat;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="ganti('."'".$row->idkat_p_sub."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus('."'".$row->idkat_p_sub."'".','."'".$row->nama_sub_kat."'".')">Hapus</button>'
                        . '</div>';
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_add_sub() {
        if($this->nativesession->get('logged_in')){
            $data = array(
                'idkat_p_sub' => $this->model->autokode("S","idkat_p_sub","kategori_penelitian_sub", 2, 7),
                'nama_sub_kat' => $this->request->getVar('nama'),
                'idkategori' => $this->request->getVar('idkat')
            );
            $simpan = $this->model->add("kategori_penelitian_sub",$data);
            if($simpan == 1){
                $status = "Data tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit_sub() {
        if($this->nativesession->get('logged_in')){
            $data = array(
                'nama_sub_kat' => $this->request->getVar('nama')
            );
            $kond['idkat_p_sub'] = $this->request->getVar('kode');
            $update = $this->model->update("kategori_penelitian_sub",$data, $kond);
            if($update == 1){
                $status = "Data terupdate";
            }else{
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function gantisub(){
        if($this->nativesession->get('logged_in')){
            $kondisi['idkat_p_sub'] = $this->request->uri->getSegment(3);
            $data = $this->model->get_by_id("kategori_penelitian_sub", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    
    public function subhapus() {
        if($this->nativesession->get('logged_in')){
            $kondisi['idkat_p_sub'] = $this->request->uri->getSegment(3);
            $hapus = $this->model->delete("kategori_penelitian_sub",$kondisi);
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
