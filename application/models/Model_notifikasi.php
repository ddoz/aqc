<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_notifikasi extends CI_Model {

    function __contruct() {
        parent::__construct();
        $this->load->model('Model_aktiviti');
    }
    
    function getNotifikasi() {
        $id = $this->session->userdata('userId');
        return $this->db->get_where('notifikasi',array('notifikasiUser'=>$id));
    }

    function saveUserNotif($appId) {
        $id = $this->session->userdata('userId');
        $insert = array(
            'userId'  => $id,
            'notifId' => $appId
        );
        $this->db->where('userId',$id);
        $this->db->delete('akunnotifikasi');
        $ins = $this->db->insert('akunnotifikasi',$insert);
        $this->db->insert('aktiviti',array('aktivitiNama'=>$this->db->last_query(),'aktivitiCreatedBy'=>$this->session->userdata('userId')));
        return $ins;
    }

    function saveNotif($msg,$tujuanId) {
        $data = array(
            'notifikasiIsi' => $msg,
            'notifikasiUser' => $tujuanId,
        );  

        return $this->db->insert('notifikasi',$data);
    }

    function sendMessage($msg,$appId=array(),$tujuanId,$idsaya){

		$content = array(
			"en" => $msg
        );
        
        $header = array(
            "en" => 'Notifikasi Paperless System'
        );
		
		$fields = array(
			'app_id' => "6f7d87c2-0b29-4418-be0d-4508876994e1",
			'include_player_ids' => $appId,
            'contents' => $content,
            'heading' => $header
		);
		
		$fields = json_encode($fields);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
												   'Authorization: Basic NzgyYjE1YzMtNzY3Zi00ZWQ4LTgxMTYtZmYwZTdiZjBjMGUz'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}

}