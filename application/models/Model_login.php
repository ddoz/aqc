<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_login extends CI_Model {
    
    function get() {
        return $this->db->get('users')->result();
    }

    function auth($user,$password) {
        // echo $user;die();
        $cekuser = $this->db->get_where('users',array('email'=>$user));
        if($cekuser->num_rows()>0) {
            $cekuser = $cekuser->row();
            if(password_verify($password,$cekuser->password)) {
                if($cekuser->user_level == "0") {
                    if($cekuser->email_verified_at=="") {
                        return false;
                    }
                }
                $data = array(
                    "userId"        => $cekuser->id,
                    "userName"      => $cekuser->email,
                    "userNamaLengkap"      => $cekuser->name,
                    "userLevel"    => $cekuser->user_level,
                );
                $this->session->set_userdata($data);
                
            }else {
                return false;
            }
        }else {
            return false;
        }
    }

    function getDivisiName($id) {
        return $this->db->get_where('divisi',array('divisiId'=>$id))->row()->divisiNama;
    }

    function getById($id) {
        return $this->db->get_where('kategori',array('kategoriId'=>$id))->row();
    }

    function store($data){
        return $this->db->insert('kategori',$data);
    }
     
}