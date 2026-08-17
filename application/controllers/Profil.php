<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        // Tidak perlu cek_akses — semua role boleh akses profilnya sendiri
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $user = $this->User_model->get_by_id($this->user_id);

        if ($this->input->method() !== 'post') {
            $data['user'] = $user;
            $this->load->view('templates/header');
            $this->load->view('profil/index', $data);
            $this->load->view('templates/footer');
            return;
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');

        // Kalau user mau ganti password, wajib isi password lama untuk verifikasi
        $password_baru = $this->input->post('password_baru', TRUE);
        if (!empty($password_baru)) {
            $this->form_validation->set_rules('password_lama', 'Password Lama', 'required');
            $this->form_validation->set_rules('password_baru', 'Password Baru', 'min_length[5]');
            $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'matches[password_baru]');
        }

        if ($this->form_validation->run() == FALSE) {
            $data['user'] = $user;
            $this->session->set_flashdata('error', validation_errors());
            $this->load->view('templates/header');
            $this->load->view('profil/index', $data);
            $this->load->view('templates/footer');
            return;
        }

        $data_update = [
            'nama'  => $this->input->post('nama', TRUE),
            'email' => $this->input->post('email', TRUE),
            'no_hp' => $this->input->post('no_hp', TRUE),
        ];

        // Kalau mau ganti password, cek dulu password lama benar
        if (!empty($password_baru)) {
            $password_lama = $this->input->post('password_lama', TRUE);

            if (md5($password_lama) !== $user->password) {
                $data['user'] = $user;
                $this->session->set_flashdata('error', 'Password lama tidak sesuai');
                $this->load->view('templates/header');
                $this->load->view('profil/index', $data);
                $this->load->view('templates/footer');
                return;
            }

            $data_update['password'] = md5($password_baru);
        }

        $this->User_model->update_profil($this->user_id, $data_update);

        // Update juga session supaya nama di navbar/sidebar langsung berubah tanpa perlu login ulang
        $this->session->set_userdata('nama', $data_update['nama']);

        $this->session->set_flashdata('success', 'Profil berhasil diperbarui');
        redirect('profil');
    }
}