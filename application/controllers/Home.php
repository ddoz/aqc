<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(empty($this->session->userdata('userId'))) {
			redirect(base_url());
		}
		$this->load->model('Model_upload');
	}
	
	public function index()
	{

        $periode_aktif = $this->db->get_where('periode',array('status'=>'1'));
        $result = [];
        if($periode_aktif->num_rows()>0) {
            $periode =  $periode_aktif->row();
            $result['periode'] = $periode;


            $this->db->select("kandidat.nama_kandidat,kandidat.nama_pasangan,kandidat.poto_a,
            kandidat.poto_b,kandidat.partai,
            max(suara_masuk.jumlah_suara) as jumlah_suara");
            $this->db->from("kandidat");
            $this->db->join("suara_masuk","suara_masuk.kandidat_id=kandidat.id");
            $this->db->where('suara_masuk.periode_id',$periode->id);
            $res = $this->db->group_by("kandidat.id")->get()->result();
            $result['hasil'] = $res;

            $this->db->select("SUM(jumlah_pemilih) as total");
            $this->db->from("tps");
            $this->db->where("periode_id",$periode->id);
            $result['pemilih'] = $this->db->get()->row();
        }

        $data = array(
            'script'    => 'script/js_home',
            'page'      => 'home/index',
			'link'      => 'home',
            'hasil'     => $result
        );
		$this->load->view('layout/template',$data);
	}

	public function detail() {
        $id = $this->uri->segment(3);
        if(is_numeric($id)) {
            $detail = $this->Model_upload->getById($id);
            if($detail['status']) {
                $data = array(
                    'script'    => 'script/js_home',
                    'page'      => 'home/detail',
                    'link'      => 'home',
                    'table'     => $detail['output']
                );
                $this->load->view('layout/template',$data);
            }else {
                $this->session->set_flashdata('status','Data Tidak Ditemukan');
                redirect(base_url().'home');
            }
        }else {
            $this->session->set_flashdata('status','Data Tidak Ditemukan');
            redirect(base_url().'home');
        }
    }

}
