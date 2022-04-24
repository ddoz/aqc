<?php

function getJumlahOrder($id) {
    $CI =& get_instance();
    return $CI->db->query("SELECT COUNT(*) as jumlah FROM order_media WHERE id_media=$id AND status_order='1'")->row()->jumlah;
}