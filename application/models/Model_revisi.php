<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_revisi extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('Model_aktiviti');
    }
    
    function getIkhtisarByMasterId($id) {
        return $this->db->get_where('revisiikhtisar',array('revisiikhtisarMasterId'=>$id))->result();
    }

    function getDetailByMasterId($id) {
        return $this->db->get_where('revisidetail',array('revisidetailMasterId'=>$id))->result();
    }

    function storeikhtisar($data){
        $store = $this->db->insert('revisiikhtisar',$data);
        $this->db->insert('aktiviti',array('aktivitiNama'=>$this->db->last_query(),'aktivitiCreatedBy'=>$this->session->userdata('userId')));
        if($store) {
            $this->db->trans_commit();
            return true;
        }
        $this->db->trans_rollback();
        return false;
    }

    function storedetail($data){
        $store = $this->db->insert('revisidetail',$data);
        $this->db->insert('aktiviti',array('aktivitiNama'=>$this->db->last_query(),'aktivitiCreatedBy'=>$this->session->userdata('userId')));
        if($store) {
            $this->db->trans_commit();
            return true;
        }
        $this->db->trans_rollback();
        return false;
    }

}