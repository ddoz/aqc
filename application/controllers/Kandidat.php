<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kandidat extends CI_Controller {

	public function __construct() {
    parent::__construct();
    if(empty($this->session->userdata('userId'))) {
			redirect(base_url());
		}
	}
	
	public function index()
	{
        $this->db->select("kandidat.*,periode.nama_periode");
        $this->db->join("periode","periode.id=kandidat.periode_id");
        $kandidat = $this->db->get('kandidat')->result();
        $data = array(
            'script'    => 'script/js_jadwal',
            'page'      => 'kandidat/index',
            'link'      => 'kandidat',
            'link_t'    => 'master',
            'table'     => $kandidat
        );
		$this->load->view('layout/template',$data);
    }
    
    public function form() {
        $data = array(
            'script'    => 'script/js_jadwal',
            'page'      => 'kandidat/form',
            'link'      => 'kandidat',
            'link_t'    => 'master',
        );
		$this->load->view('layout/template',$data);
    }

    public function save() {
        $data = array(
            "waktu_mulai"              => date('Y-m-d H:i:s',strtotime($this->input->post('waktu_mulai'))),
            "waktu_selesai"              => date('Y-m-d H:i:s',strtotime($this->input->post('waktu_selesai'))),
            "status_jadwal"              => $this->input->post('status_jadwal'),
        );

        if($this->db->insert('jadwal_pengajuan_proposals',$data)) {
            $this->session->set_flashdata('status','<div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> Berhasil simpan data.
          </div>');
        }else {
            $this->session->set_flashdata('status','<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Fail!</strong> Gagal simpan data.
          </div>');
        }
        redirect(base_url()."jadwal");
    }

    public function update() {
        $data = array(
            "waktu_mulai"              => $this->input->post('waktu_mulai'),
            "waktu_selesai"              => $this->input->post('waktu_selesai'),
            "status_jadwal"              => $this->input->post('status_jadwal'),
        );

        $this->db->where('id', $this->input->post('id'));
        if($this->db->update('jadwal_pengajuan_proposals',$data)) {
            $this->session->set_flashdata('status','<div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> Berhasil simpan data.
          </div>');
        }else {
            $this->session->set_flashdata('status','<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Fail!</strong> Gagal simpan data.
          </div>');
        }
        redirect(base_url()."jadwal");
    }

    public function hapus() {
        $id = $this->uri->segment(3);
        $this->db->where('id', $id);
        if($this->db->delete('jadwal_pengajuan_proposals',)) {
            $this->session->set_flashdata('status','<div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> Berhasil hapus data.
            </div>');
        }else {
            $this->session->set_flashdata('status','<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Fail!</strong> Gagal hapus data.
            </div>');
        }

        redirect(base_url()."jadwal");
    }

    public function hapusdetail() {
        $id = $this->uri->segment(3);
        $tipe = $this->uri->segment(4);

        $ceking = $this->db->get_where('kriteria_pilihs', array('kriteriadetail_id'=>$id));
        if($ceking->num_rows()>0) {
            $this->session->set_flashdata('status','<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Fail!</strong> Gagal hapus data. Sudah ada dalam transaksi.
            </div>');
            redirect(base_url()."kriteria/detail/".$tipe);
        }

        $this->db->where('id', $id);
        if($this->db->delete('kriteria_penilaian_details')) {
            $this->session->set_flashdata('status','<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> Berhasil hapus data.
            </div>');
        }else {
            $this->session->set_flashdata('status','<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Fail!</strong> Gagal hapus data.
            </div>');
        }

        redirect(base_url()."kriteria/detail/".$tipe);
    }

}
