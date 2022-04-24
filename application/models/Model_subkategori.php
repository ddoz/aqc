<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_subkategori extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('Model_aktiviti');
    }
    
    function get() {
        $div = $this->session->userdata('userDivisi');
        $this->db->select("subkategori.*,kategori.kategoriNama");
        $this->db->from("subkategori");
        $this->db->join('kategori','kategori.kategoriId=subkategori.kategoriId');
        $this->db->where('LOWER(kategori.kategoriNama)',strtolower($div));
        $this->db->or_where('kategori.kategoriNama',"Umum");
        return $this->db->get()->result();
    }

    function getAdmin() {
        $div = $this->session->userdata('userDivisi');
        $this->db->select("subkategori.*,kategori.kategoriNama");
        $this->db->from("subkategori");
        $this->db->join('kategori','kategori.kategoriId=subkategori.kategoriId');
        return $this->db->get()->result();
    }

    function getById($id) {
        return $this->db->get_where('subkategori',array('subkategoriId'=>$id))->row();
    }

    function store($data){
        $ins = $this->db->insert('subkategori',$data);
        $this->db->insert('aktiviti',array('aktivitiNama'=>$this->db->last_query(),'aktivitiCreatedBy'=>$this->session->userdata('userId')));
        return $ins;
    }

    function update($id,$data) {
        $this->db->where('subkategoriId',$id);
        $up = $this->db->update('subkategori',$data);
        $this->db->insert('aktiviti',array('aktivitiNama'=>$this->db->last_query(),'aktivitiCreatedBy'=>$this->session->userdata('userId')));
        return $up;
    }

    function remove($id) {
        $this->db->where('subkategoriId',$id);
        $del = $this->db->delete('subkategori');
        $this->db->insert('aktiviti',array('aktivitiNama'=>$this->db->last_query(),'aktivitiCreatedBy'=>$this->session->userdata('userId')));
        return $del;
    }
     
}