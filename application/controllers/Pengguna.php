<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {

	public function __construct() {
    parent::__construct();
    if(empty($this->session->userdata('userId')) || $this->session->userdata('userLevel')!='1') {
			redirect(base_url());
		}
    $this->load->model(array('Model_pengguna','Model_divisi','Model_notifikasi'));
	}
	
	public function index()
	{
        $data = array(
            'script'    => 'script/js_pengguna',
            'page'      => 'pengguna/index',
            'link'      => 'pengguna',
            'link_t'    => 'master',
            'table'     => $this->Model_pengguna->get()
        );
		$this->load->view('layout/template',$data);
    }
    
    public function form() {
        $data = array(
            'script'    => 'script/js_pengguna',
            'page'      => 'pengguna/form',
            'link'      => 'pengguna',
            'link_t'    => 'master',
        );
		  $this->load->view('layout/template',$data);
    }

    public function save() {
        $data = array(
            "email"              => $this->input->post('email'),
            "password"          => password_hash($this->input->post('password'),PASSWORD_DEFAULT),
            "name"       => $this->input->post('name'),
            "user_level"            => $this->input->post('level'),
            "email_verified_at"     => date('Y-m-d H:i:s'),
            "created_at"     => date('Y-m-d H:i:s'),
            "updated_at"     => date('Y-m-d H:i:s'),
        );

        if($this->db->insert('users',$data)) {
            $this->session->set_flashdata('status','<div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> Berhasil simpan data.
          </div>');
            redirect(base_url()."pengguna");
        }else {
            $this->session->set_flashdata('status','<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Fail!</strong> Gagal simpan data.
          </div>');
            redirect(base_url()."pengguna");
        }
    }


    public function delete() {
        $id = $this->uri->segment(3);
        $this->db->where('id', $id);
        if($this->db->delete('users')) {
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
        redirect(base_url()."pengguna");
    }

    public function resetpassword() {
        $id = $this->uri->segment(3);
        $this->db->where('id', $id);
        if($this->db->update('users',array('password'=>password_hash("12345678",PASSWORD_BCRYPT)))) {
            $this->session->set_flashdata('status','<div class="alert alert-info alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> Berhasil reset password.
          </div>');
        }else {
            $this->session->set_flashdata('status','<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Fail!</strong> Gagal reset password.
          </div>');
        }
        redirect(base_url().'pengguna');
    }

    public function aktivasi() {
      $id = $this->uri->segment(3);
      $this->db->where('id',$id);
			$up = $this->db->update('users',array('email_verified_at'=>date('Y-m-d H:i:s')));

			if($up) {
				$this->session->set_flashdata('status','<div class="alert alert-info alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> Berhasil aktivasi akun.
          </div>');
			}else {
				$this->session->set_flashdata('status','<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Fail!</strong> Gagal aktivasi akun.
          </div>');
			}
      redirect(base_url().'pengguna');
    }


}
