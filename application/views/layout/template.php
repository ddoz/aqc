<?php 

$this->load->view("layout/header");

($page!='')?$this->load->view($page):'Halaman Tidak Ditemukan';
$this->load->view("layout/footer");

?>