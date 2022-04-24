<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Model_login');
	}
	
	public function index()
	{
		if(!empty($this->session->userdata('userId'))) {
			redirect(base_url()."home");
		}
		$this->load->view('login');
	}

	public function register()
	{
		if(!empty($this->session->userdata('userId'))) {
			redirect(base_url()."home");
		}
		$this->load->view('register');
	}

	public function reset()
	{
		if(!empty($this->session->userdata('userId'))) {
			redirect(base_url()."home");
		}
		$this->load->view('reset');
	}

	public function signup() {

		$jadwal = $this->db->get_where('jadwal_pengajuan_proposals',array("status_jadwal"=>"1"));

		if($jadwal->num_rows()==0) {
			$this->session->set_flashdata('status','Registrasi gagal. Periode Pendaftaran Belum Ada.');
			redirect(base_url()."welcome/register");
		}

		$time = strtotime(date("Y-m-d H:i:s"));
		$waktu_mulai = strtotime($jadwal->row()->waktu_mulai);
		$waktu_selesai = strtotime($jadwal->row()->waktu_selesai);
		
		if(($time <= $waktu_mulai)||($time >= $waktu_selesai)) {
			$this->session->set_flashdata('status','Registrasi gagal. Periode Pendaftaran Belum Dimulai atau Sudah Melewati Waktu Pendaftaran. Silahkan Lakukan Pendaftaran Pada Waktu Yang Ditentukan.');
			redirect(base_url()."welcome/register");
		}

		$data = [
			"name" => $this->input->post("nama_lengkap"),
			"email" => $this->input->post("username"),
			"password" => password_hash($this->input->post("password"),PASSWORD_BCRYPT),
			"user_level" => "0"
		];
		$this->db->db_debug = false;
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
        $this->email->to($data['email']); // Ganti dengan email tujuan

        // Lampiran email, isi dengan url/path file
        // $this->email->attach(base_url()."assets/front/images/logo.png");

        // Subject email
        $this->email->subject('Aktivasi Akun SIKEPLU');

        // Isi email
        $this->email->message("Silahkan Klik Link dibawah ini untuk melakukan aktivasi Akun.<br><br> Klik <strong><a href='".base_url()."welcome/aktivasi/".md5($data['email'])."' target='_blank' rel='noopener'>disini</a></strong>.");

        // Tampilkan pesan sukses atau error
        if ($this->email->send()) {
            $this->session->set_flashdata('status','Registrasi sukses. Silahkan Cek email untuk instruksi lebih lanjut');
			
			if($this->db->insert('users',$data)) {

				$this->session->set_flashdata('status','Registrasi sukses. Silahkan  Cek email untuk instruksi lebih lanjut');
			}else {
				$this->session->set_flashdata('status','Registrasi gagal. Silahkan coba dengan username lainnya.');
			}
        } else {
			// $this->db->insert("logmail",array("log"=>json_encode($this->email->print_debugger())));
            // $this->session->set_flashdata('status','Reset sukses. Silahkan Cek email untuk instruksi lebih lanjut');
            $this->session->set_flashdata('status','Registrasi gagal. Silahkan coba dengan email lainnya.');
        }
// echo $this->email->print_debugger();
// die();
		redirect(base_url()."welcome/register");
	}


    public function aktivasi($email)
    {
		$d = $this->db->get_where('users',array('md5(email)'=>$email));
		
		if($d->num_rows()>0) {

			$id = $d->row()->id;

			$this->db->where('id',$id);
			$up = $this->db->update('users',array('email_verified_at'=>date('Y-m-d H:i:s')));

			if($up) {
				$this->session->set_flashdata('status','Aktivasi sukses. Silahkan login');
			}else {
				$this->session->set_flashdata('status','Aktivasi gagal. Silahkan ulangi kembali');
			}

		}else {
			$this->session->set_flashdata('status','Aktivasi gagal. Silahkan hubungi kami jika mengalami kendala');
				redirect(base_url().'welcome');
		}

		
        redirect(base_url()."welcome");
    }

	public function reset_password($email,$passnew)
    {
		$d = $this->db->get_where('users',array('md5(email)'=>$email));
		
		if($d->num_rows()>0) {

			$id = $d->row()->id;

			$this->db->where('id',$id);
			$up = $this->db->update('users',array('password'=>password_hash($passnew,PASSWORD_BCRYPT)));

			if($up) {
				$this->session->set_flashdata('status','Reset sukses. Silahkan login');
			}else {
				$this->session->set_flashdata('status','Reset gagal. Silahkan ulangi kembali');
			}

		}else {
			$this->session->set_flashdata('status','Reset gagal. Silahkan hubungi kami jika mengalami kendala');
				redirect(base_url().'welcome');
		}

		
        redirect(base_url()."welcome");
    }

	public function auth() {
		$user = $this->input->post('username');
		$password = $this->input->post('password');

		$login = $this->Model_login->auth($user,$password);
		if($login) {
			$this->session->set_flashdata('status','Login sukses.');
		}else {
			$this->session->set_flashdata('status','Login gagal. Silahkan periksa kembali Username dan Password. Atau Pastikan Akun anda sudah terverifikasi, Silahkan Cek Email atau Spam');
		}
		redirect(base_url()."welcome");

	}

	public function signout() {
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
