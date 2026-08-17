<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelola_santri extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->cek_akses(['admin', 'bendahara']);
        $this->load->model('Santri_model');
        $this->load->model('Kelas_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $keyword  = $this->input->get('keyword');
        $per_page = 10;
        $page     = max(1, (int) $this->input->get('page'));
        $offset   = ($page - 1) * $per_page;

        $data['santri']       = $this->Santri_model->get_all($keyword, $per_page, $offset);
        $data['total_rows']   = $this->Santri_model->count_all($keyword);
        $data['current_page'] = $page;
        $data['total_pages']  = ceil($data['total_rows'] / $per_page);
        $data['keyword']      = $keyword;

        $this->load->view('templates/header');
        $this->load->view('santri/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        if ($this->input->method() !== 'post') {
            $data['wali_options']  = $this->Santri_model->get_wali_options();
            $data['kelas_options'] = $this->Kelas_model->get_all_aktif();
            $this->load->view('templates/header');
            $this->load->view('santri/form_tambah', $data);
            $this->load->view('templates/footer');
            return;
        }

        $this->form_validation->set_rules('nis', 'NIS', 'required|trim|is_unique[santri.nis]');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('kelas_id', 'Kelas', 'required|numeric'); // DIPERBAIKI
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|in_list[L,P]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors()); // DITAMBAHKAN, biar error kelihatan
            $data['wali_options']  = $this->Santri_model->get_wali_options();
            $data['kelas_options'] = $this->Kelas_model->get_all_aktif(); // DITAMBAHKAN, kalau tidak, dropdown kelas kosong saat validasi gagal
            $this->load->view('templates/header');
            $this->load->view('santri/form_tambah', $data);
            $this->load->view('templates/footer');
            return;
        }

        $data = [
            'nis'           => $this->input->post('nis', TRUE),
            'nama'          => $this->input->post('nama', TRUE),
            'kelas_id'      => $this->input->post('kelas_id', TRUE),
            'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
            'alamat'        => $this->input->post('alamat', TRUE),
            'wali_id'       => $this->input->post('wali_id', TRUE) ?: NULL,
            'status'        => 'aktif',
        ];

        $this->Santri_model->create($data);
        $this->session->set_flashdata('success', 'Data santri berhasil ditambahkan');
        redirect('kelola_santri');
    }

    public function edit($id)
    {
        $santri = $this->Santri_model->get_by_id($id);
        if (!$santri) {
            show_404();
        }

        if ($this->input->method() !== 'post') {
            $data['santri']        = $santri;
            $data['wali_options']  = $this->Santri_model->get_wali_options();
            $data['kelas_options'] = $this->Kelas_model->get_all_aktif();
            $this->load->view('templates/header');
            $this->load->view('santri/form_edit', $data);
            $this->load->view('templates/footer');
            return;
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('kelas_id', 'Kelas', 'required|numeric'); // DIPERBAIKI
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|in_list[L,P]');

        if ($this->form_validation->run() == FALSE) {
            $data['santri']        = $santri;
            $data['wali_options']  = $this->Santri_model->get_wali_options();
            $data['kelas_options'] = $this->Kelas_model->get_all_aktif(); // DITAMBAHKAN
            $this->session->set_flashdata('error', validation_errors()); // DITAMBAHKAN
            $this->load->view('templates/header');
            $this->load->view('santri/form_edit', $data);
            $this->load->view('templates/footer');
            return;
        }

        $data = [
            'nama'          => $this->input->post('nama', TRUE),
            'kelas_id'      => $this->input->post('kelas_id', TRUE),
            'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
            'alamat'        => $this->input->post('alamat', TRUE),
            'wali_id'       => $this->input->post('wali_id', TRUE) ?: NULL,
        ];

        $this->Santri_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data santri berhasil diperbarui');
        redirect('kelola_santri');
    }

    public function nonaktifkan($id)
    {
        $this->Santri_model->update($id, ['status' => 'nonaktif']);
        $this->session->set_flashdata('success', 'Santri berhasil dinonaktifkan');
        redirect('kelola_santri');
    }

    public function aktifkan($id)
    {
        $this->Santri_model->update($id, ['status' => 'aktif']);
        $this->session->set_flashdata('success', 'Santri berhasil diaktifkan');
        redirect('kelola_santri');
    }

    public function hapus($id)
    {
        if ($this->Santri_model->has_tagihan($id)) {
            $this->session->set_flashdata(
                'error',
                'Santri tidak dapat dihapus karena sudah memiliki tagihan atau riwayat pembayaran. Gunakan menu Nonaktifkan.'
            );
            redirect('kelola_santri');
            return;
        }

        $this->Santri_model->delete($id);
        $this->session->set_flashdata('success', 'Data santri berhasil dihapus');
        redirect('kelola_santri');
    }
}