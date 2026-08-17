<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        // Kalau sudah login, redirect ke dashboard sesuai role
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        $this->load->view('auth/login');
    }

    public function login()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/login');
            return;
        }

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        $user = $this->User_model->get_by_username($username);

        if (!$user) {
            $this->session->set_flashdata('error', 'Username tidak ditemukan');
            redirect('auth');
            return;
        }

        if ($user->status !== 'aktif') {
            $this->session->set_flashdata('error', 'Akun Anda tidak aktif, hubungi admin');
            redirect('auth');
            return;
        }

        if (md5($password) !== $user->password) {
            $this->session->set_flashdata('error', 'Password salah');
            redirect('auth');
            return;
        }

        // Set session data
        $session_data = [
            'user_id'    => $user->id,
            'username'   => $user->username,
            'nama'       => $user->nama,
            'role'       => $user->role,
            'logged_in'  => TRUE
        ];
        $this->session->set_userdata($session_data);

        redirect('dashboard');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}