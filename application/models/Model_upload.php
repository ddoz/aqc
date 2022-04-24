<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_upload extends CI_Model {


    function __construct() {
        parent::__construct();
    }
    
    function store() {

        if (empty($_FILES) && empty($_POST) &&
                isset($_SERVER['REQUEST_METHOD']) &&
                strtolower($_SERVER['REQUEST_METHOD']) == 'post') {

                $postMax = ini_get('post_max_size');
                $response['status'] = false;
                $response['message'] = 'Data yang di inputkan melebihi batas Server. Maksimal total adalah '. $postMax;
                return $response;
                 exit();
        }

        if($this->ceknikdanemal($this->input->post('nomor_ktp'),$this->input->post('email_redaksi'))) { 
            $response['status'] = false;
            $response['message'] = 'No KTP dan Email sudah digunakan.';
            return $response;
            exit();
        }
        
        $config['upload_path']          = './berkas/proposal/';
        $config['allowed_types']        = 'jpg|png|jpeg|pdf|PDF';
        $config['max_size']             = 2048; // 1MB
        $config['encrypt_name']         = true;
        
        $this->load->library('upload',$config);

        $insert = [
            'nomor_ktp'=>$this->input->post('nomor_ktp'),
            'nomor_rekening'=>$this->input->post('nomor_rekening'),
            'nama_bank'=>$this->input->post('nama_bank'),
            'nomor_npwp'=>$this->input->post('nomor_npwp'),
            'tipemedia_id'=>$this->input->post('tipemedia_id'),
            'nama_media'=>$this->input->post('nama_media'),
            'nama_pic'=>$this->input->post('nama_pic'),
            'jabatan_pic'=>$this->input->post('jabatan_pic'),
            'alamat_redaksi_1'=>$this->input->post('alamat_redaksi_1'),
            'alamat_redaksi_2'=>$this->input->post('alamat_redaksi_2'),
            'provinsi'=>$this->input->post('provinsi'),
            'kota'=>$this->input->post('kota'),
            'kode_pos'=>$this->input->post('kode_pos'),
            'provinsi_redaksi'=>$this->input->post('provinsi_redaksi'),
            'kota_redaksi'=>$this->input->post('kota_redaksi'),
            'kode_pos_redaksi'=>$this->input->post('kode_pos_redaksi'),
            'email_redaksi'=>$this->input->post('email_redaksi'),
            'kontak_redaksi'=>$this->input->post('kontak_redaksi'),
            'website'=>$this->input->post('website'),
            'status'=> 'draft',
            'user_id'=>$this->session->userdata('userId'),
            'created_at'=>date('Y-m-d H:i:s')
        ];
        $response = [
            "status" => true,
            "message" => "Berhasil Simpan Data",
        ];

        $warning_message = [];
        if ($this->upload->do_upload('upload_rekening')) {
            $insert['upload_rekening'] = $this->upload->data("file_name");
        } else {
            $response['status'] = false;
            $response['message'] = 'Format File atau ukuran Upload Rekening tidak sesuai dengan ketentuan.';
            $warning_message[] = 'Format File atau ukuran Upload Rekening tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
        }
        if ($this->upload->do_upload('ktp_biro_lampung')) {
            $insert['ktp_biro_lampung'] = $this->upload->data("file_name");
        } else {
            $response['status'] = false;
            $response['message'] = 'Format File atau ukuran KTP Biro Lampung tidak sesuai dengan ketentuan.';
            $warning_message[] = 'Format File atau ukuran KTP Biro Lampung tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
        }
        if ($this->upload->do_upload('surat_tugas_biro')) {
            $insert['surat_tugas_biro'] = $this->upload->data("file_name");
        } else {
            $response['status'] = false;
            $response['message'] = 'Format File atau ukuran Surat Tugas Biro tidak sesuai dengan ketentuan.';
            $warning_message[] = 'Format File atau ukuran Surat Tugas Biro tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
        }
        if ($this->upload->do_upload('id_card')) {
            $insert['id_card'] = $this->upload->data("file_name");
        } else {
            $response['status'] = false;
            $response['message'] = 'Format File atau ukuran ID Card Pers tidak sesuai dengan ketentuan.';
            $warning_message[] = 'Format File atau ukuran ID Card Pers tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
        }
        // if ($this->upload->do_upload('kartu_identitas_pic')) {
        //     $insert['kartu_identitas_pic'] = $this->upload->data("file_name");
        // } else {
        //     $response['status'] = false;
        //     $response['message'] = 'Format File atau ukuran Kartu Identitas PIC tidak sesuai dengan ketentuan.';
        // }
        // if ($this->upload->do_upload('sk_pic')) {
        //     $insert['sk_pic'] = $this->upload->data("file_name");
        // } else {
        //     $response['status'] = false;
        //     $response['message'] = 'Format File atau ukuran Surat Tugas Kepala Biro tidak sesuai dengan ketentuan.';
        // }
        // if ($this->upload->do_upload('surat_permohonan_kerjasama')) {
        //     $insert['surat_permohonan_kerjasama'] = $this->upload->data("file_name");
        // } else {
        //     $response['status'] = false;
        //     $response['message'] = 'Format File atau ukuran Surat Permohonan Kerjasama tidak sesuai dengan ketentuan.';
        // }
        // if ($this->upload->do_upload('proposal_penawaran')) {
        //     $insert['proposal_penawaran'] = $this->upload->data("file_name");
        // } else {
        //     $response['status'] = false;
        //     $response['message'] = 'Format File atau ukuran Proposal Penawaran tidak sesuai dengan ketentuan.';
        // }
        // if ($this->upload->do_upload('siup_situ')) {
        //     $insert['siup_situ'] = $this->upload->data("file_name");
        // } else {
        //     $response['status'] = false;
        //     $response['message'] = 'Format File atau ukuran SIUP/SITU tidak sesuai dengan ketentuan.';
        // }
        // if ($this->upload->do_upload('npwp')) {
        //     $insert['npwp'] = $this->upload->data("file_name");
        // } else {
        //     $response['status'] = false;
        //     $response['message'] = 'Format File atau ukuran NPWP tidak sesuai dengan ketentuan.';
        // }
        // if ($this->upload->do_upload('sertifikat_kemenkumham')) {
        //     $insert['sertifikat_kemenkumham'] = $this->upload->data("file_name");
        // } else {
        //     $response['status'] = false;
        //     $response['message'] = 'Format File atau ukuran Sertifikat Kemenkumham tidak sesuai dengan ketentuan.';
        // }
        // if ($this->upload->do_upload('sertifikat_dewan_pers')) {
        //     $insert['sertifikat_dewan_pers'] = $this->upload->data("file_name");
        // } else {
        //     $response['status'] = false;
        //     $response['message'] = 'Format File atau ukuran Sertifikat Dewan Pers tidak sesuai dengan ketentuan.';
        // }
        // if ($this->upload->do_upload('spt_tahun_terakhir')) {
        //     $insert['spt_tahun_terakhir'] = $this->upload->data("file_name");
        // } else {
        //     $response['status'] = false;
        //     $response['message'] = 'Format File atau ukuran SPT Tahun Terakhir tidak sesuai dengan ketentuan.';
        // }
        // if ($this->upload->do_upload('surat_domisili_kantor_biro')) {
        //     $insert['surat_domisili_kantor_biro'] = $this->upload->data("file_name");
        // } else {
        //     $response['status'] = false;
        //     $response['message'] = 'Format File atau ukuran Surat Domisili Kantor Biro di Lampung Utara tidak sesuai dengan ketentuan.';
        // }

        $cekNPWP = $this->db->get_where('proposals',array('nomor_npwp'=>$insert['nomor_npwp'],'user_id!='=>$this->session->userdata('userId')));
        if($cekNPWP->num_rows() > 1) {
            $response['status'] = false;
            $response['message'] = 'Nomor NPWP Sudah digunakan di 2 Media.';
        }else {
            if($warning_message == null) {
                if($this->db->insert('proposals',$insert)) {
                    $response['status'] = true;
                    $response['message'] = 'Berhasil Simpan Data.';
                }else {
                    $this->db->insert('logmail',array("log"=>$this->db->error()));
                    $response['status'] = false;
                    $response['message'] = 'Gagal Simpan Data. Kesalahan Database.';
                }
            }else {
                $message = "<ul>";
                foreach($warning_message as $w) {
                    $message .= "<li>".$w."</li>";
                }
                $message .= "</ul>";
                $response['status'] = false;
                $response['message'] = $message;
            }
        }
        
        return $response;

    }

    function ceknikdanemal($nik,$email) {
        if ($this->db->get_where('proposals', array("nomor_ktp"=>$nik,"email_redaksi"=>$email))->num_rows()>0) {
            return true;
        }
    }

    function update($row) {


        if (empty($_FILES) && empty($_POST) &&
                isset($_SERVER['REQUEST_METHOD']) &&
                strtolower($_SERVER['REQUEST_METHOD']) == 'post') {

                $postMax = ini_get('post_max_size');
                
                $response['status'] = false;
                $response['message'] = 'Data yang di inputkan melebihi batas Server. Maksimal total adalah '. $postMax;
                return $response;
                exit();
        }

        if($this->ceknikdanemal($this->input->post('nomor_ktp'),$this->input->post('email_redaksi'))) { 
            $response['status'] = false;
            $response['message'] = 'No KTP dan Email sudah digunakan.';
            
            if($this->input->post('nomor_ktp_old')!=$this->input->post('nomor_ktp')) {
                return $response;
                exit();
            }

        }
        
        $config['upload_path']          = './berkas/proposal/';
        $config['allowed_types']        = 'jpg|png|jpeg|pdf|PDF';
        $config['max_size']             = 2048; // 1MB
        $config['encrypt_name']         = true;
        
        $this->load->library('upload',$config);

        $insert = [
            'nomor_ktp'=>$this->input->post('nomor_ktp'),
            'nomor_rekening'=>$this->input->post('nomor_rekening'),
            'nama_bank'=>$this->input->post('nama_bank'),
            'nomor_npwp'=>$this->input->post('nomor_npwp'),
            'tipemedia_id'=>$this->input->post('tipemedia_id'),
            'nama_media'=>$this->input->post('nama_media'),
            'nama_pic'=>$this->input->post('nama_pic'),
            'jabatan_pic'=>$this->input->post('jabatan_pic'),
            'alamat_redaksi_1'=>$this->input->post('alamat_redaksi_1'),
            'alamat_redaksi_2'=>$this->input->post('alamat_redaksi_2'),
            'kode_pos'=>$this->input->post('kode_pos'),
            'kode_pos_redaksi'=>$this->input->post('kode_pos_redaksi'),
            'email_redaksi'=>$this->input->post('email_redaksi'),
            'kontak_redaksi'=>$this->input->post('kontak_redaksi'),
            'website'=>$this->input->post('website'),
        ];
        $response = [
            "status" => true,
            "message" => "Berhasil Ubah Data",
        ];

        

        $warning_message = [];

        if($row->provinsi!=$this->input->post('provinsi') && $this->input->post('provinsi')!="") {
            $insert['provinsi'] = $this->input->post('provinsi');
        }
        if($row->kota!=$this->input->post('kota')  && $this->input->post('kota')!="") {
            $insert['kota'] = $this->input->post('kota');
        }

        if($row->provinsi_redaksi!=$this->input->post('provinsi_redaksi') && $this->input->post('provinsi_redaksi')!="") {
            $insert['provinsi_redaksi'] = $this->input->post('provinsi_redaksi');
        }
        if($row->kota_redaksi!=$this->input->post('kota_redaksi')  && $this->input->post('kota_redaksi')!="") {
            $insert['kota_redaksi'] = $this->input->post('kota_redaksi');
        }
        if(!empty($_FILES['upload_rekening']['name'])) {
            if ($this->upload->do_upload('upload_rekening')) {
                $insert['upload_rekening'] = $this->upload->data("file_name");
            } else {
                $response['status'] = false;
                $response['message'] = 'Format File atau ukuran Upload Rekening tidak sesuai dengan ketentuan.';
                $warning_message[] = 'Format File atau ukuran Upload Rekening tidak sesuai dengan ketentuan. '. $this->upload->display_errors();
            }
        }
        // if(!empty($_FILES['kartu_identitas_pic']['name'])) {
        //     if ($this->upload->do_upload('kartu_identitas_pic')) {
        //         $insert['kartu_identitas_pic'] = $this->upload->data("file_name");
        //     } else {
        //         $response['status'] = false;
        //         $response['message'] = 'Format File atau ukuran Kartu Identitas PIC tidak sesuai dengan ketentuan.';
        //         $warning_message[] = 'Format File atau ukuran Kartu Identitas PIC tidak sesuai dengan ketentuan.';
        //     }
        // }
        if(!empty($_FILES['ktp_biro_lampung']['name'])) {
            if ($this->upload->do_upload('ktp_biro_lampung')) {
                $insert['ktp_biro_lampung'] = $this->upload->data("file_name");
            } else {
                $response['status'] = false;
                $response['message'] = 'Format File atau ukuran KTP Biro Lampung tidak sesuai dengan ketentuan.';
                $warning_message[] = 'Format File atau ukuran KTP Biro Lampung tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
            }
        }
        if(!empty($_FILES['surat_tugas_biro']['name'])) {
            if ($this->upload->do_upload('surat_tugas_biro')) {
                $insert['surat_tugas_biro'] = $this->upload->data("file_name");
            } else {
                $response['status'] = false;
                $response['message'] = 'Format File atau ukuran Surat Tugas Biro tidak sesuai dengan ketentuan.';
                $warning_message[] = 'Format File atau ukuran Surat Tugas Biro tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
            }
        }
        if(!empty($_FILES['id_card']['name'])) {
            if ($this->upload->do_upload('id_card')) {
                $insert['id_card'] = $this->upload->data("file_name");
            } else {
                $response['status'] = false;
                $response['message'] = 'Format File atau ukuran ID Card Pres tidak sesuai dengan ketentuan.';
                $warning_message[] = 'Format File atau ukuran ID Card Pres tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
            }
        }
        // if(!empty($_FILES['sk_pic']['name'])) {
        //     if ($this->upload->do_upload('sk_pic')) {
        //         $insert['sk_pic'] = $this->upload->data("file_name");
        //     } else {
        //         $response['status'] = false;
        //         $response['message'] = 'Format File atau ukuran Surat Tugas Kepala Biro tidak sesuai dengan ketentuan.';
        //     }
        // }
        // if(!empty($_FILES['surat_permohonan_kerjasama']['name'])) {
        //     if ($this->upload->do_upload('surat_permohonan_kerjasama')) {
        //         $insert['surat_permohonan_kerjasama'] = $this->upload->data("file_name");
        //     } else {
        //         $response['status'] = false;
        //         $response['message'] = 'Format File atau ukuran Surat Permohonan Kerjasama tidak sesuai dengan ketentuan.';
        //     }
        // }
        // if(!empty($_FILES['proposal_penawaran']['name'])) {
        //     if ($this->upload->do_upload('proposal_penawaran')) {
        //         $insert['proposal_penawaran'] = $this->upload->data("file_name");
        //     } else {
        //         $response['status'] = false;
        //         $response['message'] = 'Format File atau ukuran Proposal Penawaran tidak sesuai dengan ketentuan.';
        //     }
        // }
        // if(!empty($_FILES['siup_situ']['name'])) {
        //     if ($this->upload->do_upload('siup_situ')) {
        //         $insert['siup_situ'] = $this->upload->data("file_name");
        //     } else {
        //         $response['status'] = false;
        //         $response['message'] = 'Format File atau ukuran SIUP/SITU tidak sesuai dengan ketentuan.';
        //     }
        // }
        // if(!empty($_FILES['npwp']['name'])) {
        //     if ($this->upload->do_upload('npwp')) {
        //         $insert['npwp'] = $this->upload->data("file_name");
        //     } else {
        //         $response['status'] = false;
        //         $response['message'] = 'Format File atau ukuran NPWP tidak sesuai dengan ketentuan.';
        //     }
        // }
        // if ($this->upload->do_upload('sertifikat_kemenkumham')) {
        //     $insert['sertifikat_kemenkumham'] = $this->upload->data("file_name");
        // } else {
        //     $response['status'] = false;
        //     $response['message'] = 'Format File atau ukuran Sertifikat Kemenkumham tidak sesuai dengan ketentuan.';
        // }
        // if(!empty($_FILES['sertifikat_dewan_pers']['name'])) {
        //     if ($this->upload->do_upload('sertifikat_dewan_pers')) {
        //         $insert['sertifikat_dewan_pers'] = $this->upload->data("file_name");
        //     } else {
        //         $response['status'] = false;
        //         $response['message'] = 'Format File atau ukuran Sertifikat Dewan Pers tidak sesuai dengan ketentuan.';
        //     }
        // }
        // if(!empty($_FILES['spt_tahun_terakhir']['name'])) {
        //     if ($this->upload->do_upload('spt_tahun_terakhir')) {
        //         $insert['spt_tahun_terakhir'] = $this->upload->data("file_name");
        //     } else {
        //         $response['status'] = false;
        //         $response['message'] = 'Format File atau ukuran SPT Tahun Terakhir tidak sesuai dengan ketentuan.';
        //     }
        // }
        // if(!empty($_FILES['surat_domisili_kantor_biro']['name'])) {
        //     if ($this->upload->do_upload('surat_domisili_kantor_biro')) {
        //         $insert['surat_domisili_kantor_biro'] = $this->upload->data("file_name");
        //     } else {
        //         $response['status'] = false;
        //         $response['message'] = 'Format File atau ukuran Surat Domisili Kantor Biro di Lampung Utara tidak sesuai dengan ketentuan.';
        //     }
        // }

        $cekNPWP = $this->db->get_where('proposals',array('nomor_npwp'=>$insert['nomor_npwp'],'user_id!='=>$this->session->userdata('userId')));
        if($cekNPWP->num_rows() > 1) {
            $response['status'] = false;
            $response['message'] = 'Nomor NPWP Sudah digunakan di 2 Media.';
        }else {

            if($warning_message == null) {
                $this->db->where('id',$row->id);
                if($this->db->update('proposals',$insert)) {
                    $response['status'] = true;
                    $response['message'] = 'Berhasil Ubah Data.';
                }else {
                    $this->db->insert('logmail',array("log"=>$this->db->error()));
                    $response['status'] = false;
                    $response['message'] = 'Gagal Update Data. Kesalahan Database.';
                }
            }else {
                $message = "<ul>";
                foreach($warning_message as $w) {
                    $message .= "<li>".$w."</li>";
                }
                $message .= "</ul>";

                $response['status'] = false;
                $response['message'] = $message;
            }
            
        }
        return $response;

    }

    function updatekelengkapan($row) {


        if (empty($_FILES) && empty($_POST) &&
                isset($_SERVER['REQUEST_METHOD']) &&
                strtolower($_SERVER['REQUEST_METHOD']) == 'post') {

                $postMax = ini_get('post_max_size');
                
                $response['status'] = false;
                $response['message'] = 'Data yang di inputkan melebihi batas Server atau anda belum mengisi data. Maksimal total adalah '. $postMax;
                return $response;
                exit();
        }

        $config['upload_path']          = './berkas/proposal/';
        $config['allowed_types']        = 'jpg|png|jpeg|pdf|PDF';
        $config['max_size']             = 5048; // 1MB
        $config['encrypt_name']         = true;
        
        $this->load->library('upload',$config);

        $insert = [];
        $response = [
            "status" => true,
            "message" => "Berhasil Ubah Data",
        ];

        // if ($this->upload->do_upload('upload_rekening')) {
        //     $insert['upload_rekening'] = $this->upload->data("file_name");
        // } else {
        //     $response['status'] = false;
        //     $response['message'] = 'Format File atau ukuran Upload Rekening tidak sesuai dengan ketentuan.';
        // }

        $warning_message = [];
       
        if(!empty($_FILES['akta_perusahaan']['name'])) {
            if ($this->upload->do_upload('akta_perusahaan')) {
                $insert['akta_perusahaan'] = $this->upload->data("file_name");
            } else {
                $response['status'] = false;
                $response['message'] = 'Format File atau ukuran Akta Perusahaan tidak sesuai dengan ketentuan.';
                $warning_message[] = 'Format File atau ukuran Akta Perusahaan tidak sesuai dengan ketentuan.';
            }
        }
        if(!empty($_FILES['kartu_identitas_pic']['name'])) {
            if ($this->upload->do_upload('kartu_identitas_pic')) {
                $insert['kartu_identitas_pic'] = $this->upload->data("file_name");
            } else {
                $response['status'] = false;
                $response['message'] = 'Format File atau ukuran Kartu Identitas PIC tidak sesuai dengan ketentuan.';
                $warning_message[] = 'Format File atau ukuran Kartu Identitas PIC tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
            }
        }
        if(!empty($_FILES['ktp_biro_lampung']['name'])) {
            if ($this->upload->do_upload('ktp_biro_lampung')) {
                $insert['ktp_biro_lampung'] = $this->upload->data("file_name");
            } else {
                $response['status'] = false;
                $response['message'] = 'Format File atau ukuran KTP Biro Lampung tidak sesuai dengan ketentuan.';
                $warning_message[] = 'Format File atau ukuran KTP Biro Lampung tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
            }
        }
        if(!empty($_FILES['surat_tugas_biro']['name'])) {
            if ($this->upload->do_upload('surat_tugas_biro')) {
                $insert['surat_tugas_biro'] = $this->upload->data("file_name");
            } else {
                $response['status'] = false;
                $response['message'] = 'Format File atau ukuran Surat Tugas Biro tidak sesuai dengan ketentuan.';
                $warning_message[] = 'Format File atau ukuran Surat Tugas Biro tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
            }
        }
        if(!empty($_FILES['id_card']['name'])) {
            if ($this->upload->do_upload('id_card')) {
                $insert['id_card'] = $this->upload->data("file_name");
            } else {
                $response['status'] = false;
                $response['message'] = 'Format File atau ukuran ID Card Pres tidak sesuai dengan ketentuan.';
                $warning_message[] = 'Format File atau ukuran ID Card Pres tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
            }
        }
        if(!empty($_FILES['sk_pic']['name'])) {
            if ($this->upload->do_upload('sk_pic')) {
                $insert['sk_pic'] = $this->upload->data("file_name");
            } else {
                $response['status'] = false;
                $response['message'] = 'Format File atau ukuran Surat Tugas Kepala Biro tidak sesuai dengan ketentuan.';
                $warning_message[] = 'Format File atau ukuran Surat Tugas Kepala Biro tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
            }
        }
        if(!empty($_FILES['surat_permohonan_kerjasama']['name'])) {
            if ($this->upload->do_upload('surat_permohonan_kerjasama')) {
                $insert['surat_permohonan_kerjasama'] = $this->upload->data("file_name");
            } else {
                $response['status'] = false;
                $response['message'] = 'Format File atau ukuran Surat Permohonan Kerjasama tidak sesuai dengan ketentuan.';
                $warning_message[] = 'Format File atau ukuran Surat Permohonan Kerjasama tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
            }
        }
        if(!empty($_FILES['proposal_penawaran']['name'])) {
            if ($this->upload->do_upload('proposal_penawaran')) {
                $insert['proposal_penawaran'] = $this->upload->data("file_name");
            } else {
                $response['status'] = false;
                $response['message'] = 'Format File atau ukuran Proposal Penawaran tidak sesuai dengan ketentuan.';
                $warning_message[] = 'Format File atau ukuran Proposal Penawaran tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
            }
        }
        if(!empty($_FILES['siup_situ']['name'])) {
            if ($this->upload->do_upload('siup_situ')) {
                $insert['siup_situ'] = $this->upload->data("file_name");
            } else {
                $response['status'] = false;
                $response['message'] = 'Format File atau ukuran SIUP/SITU tidak sesuai dengan ketentuan.';
                $warning_message[] = 'Format File atau ukuran SIUP/SITU tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
            }
        }
        if(!empty($_FILES['npwp']['name'])) {
            if ($this->upload->do_upload('npwp')) {
                $insert['npwp'] = $this->upload->data("file_name");
            } else {
                $response['status'] = false;
                $response['message'] = 'Format File atau ukuran NPWP tidak sesuai dengan ketentuan.';
                $warning_message[] = 'Format File atau ukuran NPWP tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
            }
        }
        if(!empty($_FILES['sertifikat_kemenkumham']['name'])) {
            if ($this->upload->do_upload('sertifikat_kemenkumham')) {
                $insert['sertifikat_kemenkumham'] = $this->upload->data("file_name");
            } else {
                $response['status'] = false;
                $response['message'] = 'Format File atau ukuran Sertifikat Kemenkumham tidak sesuai dengan ketentuan.';
                $warning_message[] = 'Format File atau ukuran Sertifikat Kemenkumham tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
            }
        }
        if(!empty($_FILES['sertifikat_dewan_pers']['name'])) {
            if ($this->upload->do_upload('sertifikat_dewan_pers')) {
                $insert['sertifikat_dewan_pers'] = $this->upload->data("file_name");
            } else {
                $response['status'] = false;
                $response['message'] = 'Format File atau ukuran Sertifikat Dewan Pers tidak sesuai dengan ketentuan.';
                $warning_message[] = 'Format File atau ukuran Sertifikat Dewan Pers tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
            }
        }
        if(!empty($_FILES['spt_tahun_terakhir']['name'])) {
            if ($this->upload->do_upload('spt_tahun_terakhir')) {
                $insert['spt_tahun_terakhir'] = $this->upload->data("file_name");
            } else {
                $response['status'] = false;
                $response['message'] = 'Format File atau ukuran SPT Tahun Terakhir tidak sesuai dengan ketentuan.';
                $warning_message[] = 'Format File atau ukuran SPT Tahun Terakhir tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
            }
        }
        if(!empty($_FILES['surat_domisili_kantor_biro']['name'])) {
            if ($this->upload->do_upload('surat_domisili_kantor_biro')) {
                $insert['surat_domisili_kantor_biro'] = $this->upload->data("file_name");
            } else {
                $response['status'] = false;
                $response['message'] = 'Format File atau ukuran Surat Domisili Kantor Biro di Lampung Utara tidak sesuai dengan ketentuan.';
                $warning_message[] = 'Format File atau ukuran Surat Domisili Kantor Biro di Lampung Utara tidak sesuai dengan ketentuan. '. $this->upload->display_errors();;
            }
        }

        if($warning_message == null) { 
            $this->db->where('id',$row->id);
            if($this->db->update('proposals',$insert)) {
                $response['status'] = true;
                $response['message'] = 'Berhasil Ubah Data.';
            }else {
                $this->db->insert('logmail',array("log"=>$this->db->error()));
                $response['status'] = false;
                $response['message'] = 'Gagal Update Data. Kesalahan Database.';
            }
        }else {
            $message = "<ul>";
            foreach($warning_message as $w) {
                $message .= "<li>".$w."</li>";
            }
            $message .= "</ul>";
            $response['status'] = false;
            $response['message'] = $message;
        }
        
        return $response;

    }

}