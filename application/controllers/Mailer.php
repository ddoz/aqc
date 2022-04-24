<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailer extends CI_Controller {

    /**
     * Kirim email dengan SMTP Gmail.
     *
     */
    public function lupa_password()
    {

        $cek = $this->db->get_where('users', array('email' => $this->input->post('email')));

        if($cek->num_rows()>0) {

            $user = $cek->row();
            // Konfigurasi email
            $config = [
                'mailtype'  => 'html',
                'charset'   => 'utf-8',
                'protocol'  => 'smtp',
                'smtp_host' => 'mail.lampungutarakab.go.id',
                'smtp_user' => 'sikeplu@lampungutarakab.go.id',  // Email gmail
                'smtp_pass'   => 'sikeplu2022',  // Password gmail
                'smtp_crypto' => 'tls',
                'smtp_port'   => 587,
                'newline' => "\r\n"
            ];

            // Load library email dan konfigurasinya
            $this->load->library('email', $config);

            // Email dan nama pengirim
            $this->email->from('sikeplu@lampungutarakab.go.id', 'Sikeplu');

            // Email penerima
            $this->email->to($user->email); // Ganti dengan email tujuan

            // Lampiran email, isi dengan url/path file
            // $this->email->attach(base_url()."assets/front/images/logo.png");

            // Subject email
            $this->email->subject('Reset Password Akun SIKEPLU');

            $passnew = $this->unique_id();

            // Isi email
            $this->email->message("Form Reset Password<br><b>Password Baru : ".$passnew."</b><br>Silahkan Klik Link dibawah ini untuk melakukan reset Password.<br><br> Klik <strong><a href='".base_url()."welcome/reset_password/".md5($user->email)."/".$passnew."'' target='_blank' rel='noopener'>disini</a></strong> Untuk RESET PASSWORD.");

            // Tampilkan pesan sukses atau error
            if ($this->email->send()) {
                $this->session->set_flashdata('status','Reset sukses. Silahkan Cek email untuk instruksi lebih lanjut');
            } else {
                $this->session->set_flashdata('status','Reset gagal. Silahkan coba dengan email terdaftar.');
            }
        }else {
            $this->session->set_flashdata('status','Reset gagal. Silahkan coba dengan email yang terdaftar.');
        }
        redirect(base_url()."welcome");

    }

    function unique_id($l = 8) {
        return substr(md5(uniqid(mt_rand(), true)), 0, $l);
    }

}