<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelola_pengguna extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->cek_akses(['admin']); // hanya admin
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $keyword  = $this->input->get('keyword');
        $per_page = 10;
        $page     = max(1, (int) $this->input->get('page'));
        $offset   = ($page - 1) * $per_page;

        $data['users']        = $this->User_model->get_all_users($keyword, $per_page, $offset);
        $data['total_rows']   = $this->User_model->count_all_users($keyword);
        $data['current_page'] = $page;
        $data['total_pages']  = ceil($data['total_rows'] / $per_page);
        $data['keyword']      = $keyword;

        $this->load->view('templates/header');
        $this->load->view('pengguna/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        // GET: tampilkan form kosong
        if ($this->input->method() !== 'post') {
            $this->load->view('templates/header');
            $this->load->view('pengguna/form_tambah');
            $this->load->view('templates/footer');
            return;
        }

        // POST: proses simpan
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,bendahara,wali_santri]');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            $this->load->view('templates/header');
            $this->load->view('pengguna/form_tambah');
            $this->load->view('templates/footer');
            return;
        }

        $data = [
            'username' => $this->input->post('username', TRUE),
            'password' => md5($this->input->post('password', TRUE)),
            'nama'     => $this->input->post('nama', TRUE),
            'email'    => $this->input->post('email', TRUE),
            'no_hp'    => $this->input->post('no_hp', TRUE),
            'role'     => $this->input->post('role', TRUE),
            'status'   => 'aktif',
        ];

        $insert_result = $this->User_model->create($data);

        if ($insert_result === FALSE) {
            $this->session->set_flashdata('error', 'Gagal simpan: ' . $this->db->error()['message']);
            redirect('kelola_pengguna/tambah');
            return;
        }

        $this->session->set_flashdata('success', 'Pengguna berhasil ditambahkan');
        redirect('kelola_pengguna');
    }

    public function edit($id)
    {
        $user = $this->User_model->get_by_id($id);
        if (!$user) {
            show_404();
        }

        // GET: tampilkan form terisi data lama
        if ($this->input->method() !== 'post') {
            $data['user'] = $user;
            $this->load->view('templates/header');
            $this->load->view('pengguna/form_edit', $data);
            $this->load->view('templates/footer');
            return;
        }

        // POST: proses update
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,bendahara,wali_santri]');

        if ($this->form_validation->run() == FALSE) {
            $data['user'] = $user;
            $this->session->set_flashdata('error', validation_errors());
            $this->load->view('templates/header');
            $this->load->view('pengguna/form_edit', $data);
            $this->load->view('templates/footer');
            return;
        }

        $data = [
            'nama'  => $this->input->post('nama', TRUE),
            'email' => $this->input->post('email', TRUE),
            'no_hp' => $this->input->post('no_hp', TRUE),
            'role'  => $this->input->post('role', TRUE),
        ];

        $password_baru = $this->input->post('password', TRUE);
        if (!empty($password_baru)) {
            $data['password'] = md5($password_baru);
        }

        $this->User_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data pengguna berhasil diperbarui');
        redirect('kelola_pengguna');
    }

    public function nonaktifkan($id)
    {
        if ($id == $this->user_id) {
            $this->session->set_flashdata('error', 'Anda tidak bisa menonaktifkan akun sendiri');
            redirect('kelola_pengguna');
            return;
        }

        $this->User_model->update($id, ['status' => 'nonaktif']);
        $this->session->set_flashdata('success', 'Pengguna berhasil dinonaktifkan');
        redirect('kelola_pengguna');
    }

    public function aktifkan($id)
    {
        $this->User_model->update($id, ['status' => 'aktif']);
        $this->session->set_flashdata('success', 'Pengguna berhasil diaktifkan');
        redirect('kelola_pengguna');
    }

    public function hapus($id)
    {
        if ($id == $this->user_id) {
            $this->session->set_flashdata('error', 'Anda tidak bisa menghapus akun sendiri');
            redirect('kelola_pengguna');
            return;
        }

        $this->User_model->delete($id);
        $this->session->set_flashdata('success', 'Pengguna berhasil dihapus');
        redirect('kelola_pengguna');
    }
}