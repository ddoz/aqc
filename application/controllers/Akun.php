<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends CI_Controller {

	public function __construct() {
        parent::__construct();
        if(empty($this->session->userdata('userId'))) {
			redirect(base_url());
        }
        $this->load->model('Model_pengguna');
	}
	
	public function index()
	{
        $data = array(
            'script'    => 'script/js_akun',
            'page'      => 'akun/index',
            'link'      => '',
        );
		$this->load->view('layout/template',$data);
    }

    public function ubah() {
        $old = $this->input->post('old');
        $new = $this->input->post('new');
        $konf = $this->input->post('new_konf');
        if($new!=$konf) {
            $this->session->set_flashdata('status','<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Fail!</strong> Password konfirmasi salah.
          </div>');
            redirect(base_url().'akun');
        }else {
            if($this->Model_pengguna->changePassword($old,$new)) {
                $this->session->set_flashdata('status','<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong> Password berhasil diubah.
              </div>');
            }else {
                $this->session->set_flashdata('status','<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Fail!</strong> Password gagal diubah.
              </div>');
            }
        }
        redirect(base_url().'akun');
    }

}
