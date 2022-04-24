<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_favorit extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get() {
        $this->db->select('*');
        $this->db->from('favorit');
        $this->db->where('favoritUserId',$this->session->userdata('userId'));
        $fav = $this->db->get()->result();
        $dataf = array();
        if(!empty($fav)){
            $i = 0;
            foreach($fav as $f) {
                $dataf[$i] = $f;
                $this->db->select('*');
                $this->db->from('favoritdetail');
                $this->db->join('users','users.userId=favoritdetail.favoritdetailUserId');
                $this->db->join('divisi','users.userDivisi=divisi.divisiId');
                $this->db->where('favoritId',$f->favoritId);
                $dd = $this->db->get()->result();
                $data = array();
                foreach($dd as $d) {
                    $data[] = $d;
                }
                $dataf[$i]->detail = $data;
            $i++;
            }
            return array('status'=>true,'data'=>$dataf);
        }else {
            return array('status'=>false,'data'=>array());
        }
        
    }

    function getById($id) {
        return $this->db->get_where('favorit',array('favoritId'=>$id))->row();
    }

    function store($data,$detail){
        $this->db->trans_begin();
        $this->db->insert('favorit',$data);
        $id = $this->db->insert_id();
        $user = array();
        $i = 0;
        $j = 1;
        foreach($detail as $fav) {
            $user[$i]['favoritId'] = $id;
            $user[$i]['favoritdetailUserId'] = $fav;
            $user[$i]['favoritdetailUserLevel'] = $j;
        $i++;
        $j++;
        }
        $this->db->insert_batch('favoritdetail',$user);
        $this->db->insert('aktiviti',array('aktivitiNama'=>$this->db->last_query(),'aktivitiCreatedBy'=>$this->session->userdata('userId')));
        if($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            return false;
        }else {
            $this->db->trans_commit();
            return true;
        }
    }
     
    function update($id,$data,$detail) {
        $this->db->trans_begin();
        $this->db->where('favoritId',$id);
        $this->db->update('favorit',$data);

        $this->db->where('favoritId',$id);
        $this->db->delete('favoritdetail');

        $user = array();
        $i = 0;
        $j = 1;
        foreach($detail as $fav) {
            $user[$i]['favoritId'] = $id;
            $user[$i]['favoritdetailUserId'] = $fav;
            $user[$i]['favoritdetailUserLevel'] = $j;
        $i++;
        $j++;
        }
        $this->db->insert_batch('favoritdetail',$user);
        $this->db->insert('aktiviti',array('aktivitiNama'=>$this->db->last_query(),'aktivitiCreatedBy'=>$this->session->userdata('userId')));
        if($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            return false;
        }else {
            $this->db->trans_commit();
            return true;
        }
    }

    function remove($id) {
        $this->db->where('favoritId',$id);
        $this->db->delete('favoritdetail');
        $this->db->where('favoritId',$id);
        $del = $this->db->delete('favorit');
        $this->db->insert('aktiviti',array('aktivitiNama'=>$this->db->last_query(),'aktivitiCreatedBy'=>$this->session->userdata('userId')));
        return $del;
    }
}