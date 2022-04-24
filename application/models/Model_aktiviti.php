<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_aktiviti extends CI_Model {

    public function saveAktiviti($aktiviti) {
        return $this->db->insert('aktiviti',array('aktivitiNama'=>$aktiviti,'aktivitiCreatedBy'=>$this->session->userdata('userId')));
    }

}