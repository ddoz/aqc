<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_kategori extends CI_Model {

    function __contruct() {
        parent::__contruct();
        $this->load->model('Model_aktiviti');
    }
    
    function get() {
        return $this->db->get('kategori')->result();
    }

    function getById($id) {
        return $this->db->get_where('kategori',array('kategoriId'=>$id))->row();
    }

    function store($data){
        $ins = $this->db->insert('kategori',$data);
        $this->db->insert('aktiviti',array('aktivitiNama'=>$this->db->last_query(),'aktivitiCreatedBy'=>$this->session->userdata('userId')));
        return $ins;
    }
     
    function update($id,$data) {
        $this->db->where('kategoriId',$id);
        $up = $this->db->update('kategori',$data);
        $this->db->insert('aktiviti',array('aktivitiNama'=>$this->db->last_query(),'aktivitiCreatedBy'=>$this->session->userdata('userId')));
        return $up;
    }

    function remove($id) {
        $this->db->where('kategoriId',$id);
        $del = $this->db->delete('kategori');
        $this->db->insert('aktiviti',array('aktivitiNama'=>$this->db->last_query(),'aktivitiCreatedBy'=>$this->session->userdata('userId')));
        return $del;
    }
}