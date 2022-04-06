<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use App\Libraries\Nativesession;

/**
 * Description of Pangkat
 *
 * @author rampa
 */
class Pangkat extends BaseController {
    
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
            echo view('backend/pangkat/index');
            echo view('backend/foot');
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if($this->nativesession->get('logged_in')){
            $data = array();
            $list = $this->model->getAll("pangkat");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $row->nama_pangkat;
                if($row->idpangkat == "P00001"){
                    $val[] = '<div style="text-align: center;"></div>';
                }else{
                    $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="ganti('."'".$row->idpangkat."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus('."'".$row->idpangkat."'".','."'".$row->nama_pangkat."'".')">Hapus</button>'
                        . '</div>';
                }
                
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
                'idpangkat' => $this->model->autokode("P","idpangkat","pangkat", 2, 7),
                'nama_pangkat' => $this->request->getVar('nama')
            );
            $simpan = $this->model->add("pangkat",$data);
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
            $kondisi['idpangkat'] = $this->request->uri->getSegment(3);
            $data = $this->model->get_by_id("pangkat", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if($this->nativesession->get('logged_in')){
            $data = array(
                'nama_pangkat' => $this->request->getVar('nama')
            );
            $kond['idpangkat'] = $this->request->getVar('kode');
            $update = $this->model->update("pangkat",$data, $kond);
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
            $kondisi['idpangkat'] = $this->request->uri->getSegment(3);
            $hapus = $this->model->delete("pangkat",$kondisi);
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
