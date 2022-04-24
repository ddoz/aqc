<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_divisi extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('Model_aktiviti');
    }
    
    function get() {
        return $this->db->get('divisi')->result();
    }

    function getById($id) {
        return $this->db->get_where('divisi',array('divisiId'=>$id))->row();
    }

    function store($data){
        $ins =  $this->db->insert('divisi',$data);
        $this->db->insert('aktiviti',array('aktivitiNama'=>$this->db->last_query(),'aktivitiCreatedBy'=>$this->session->userdata('userId')));
        return $ins;
    }
     
    function update($id,$data) {
        $this->db->where('divisiId',$id);
        $up = $this->db->update('divisi',$data);
        $this->db->insert('aktiviti',array('aktivitiNama'=>$this->db->last_query(),'aktivitiCreatedBy'=>$this->session->userdata('userId')));
        return $up;
    }

    function remove($id) {
        $this->db->where('divisiId',$id);
        $del = $this->db->delete('divisi');
        $this->db->insert('aktiviti',array('aktivitiNama'=>$this->db->last_query(),'aktivitiCreatedBy'=>$this->session->userdata('userId')));
        return $del;
    }
}