<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {

	public function __construct() {
        parent::__construct();
	}
	
	public function download()
	{
        $this->load->helper('download');
        $id = $this->uri->segment(3);
        $file = $this->db->get_where('order_media',array('md5(id)' => $id));
        if($file->num_rows()>0) {
            $f = $file->row();
            if($f->surat_order!='') {
                force_download(base_url().'/berkas/sk/'.$file->surat_order, NULL);
            }else {
                echo "Surat tidak tersedia. Silahkan <a href='".base_url()."welcome'> Login </a> untuk melihat data lengkap pada menu Order Media.";
            }
        }
    }
    
}
