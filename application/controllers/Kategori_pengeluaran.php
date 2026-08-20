<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_pengeluaran extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->cek_akses(['admin', 'bendahara']);
        $this->load->model('Kategori_pengeluaran_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $per_page = 10;
        $page     = max(1, (int) $this->input->get('page'));
        $offset   = ($page - 1) * $per_page;

        $data['kategori']      = $this->Kategori_pengeluaran_model->get_all($per_page, $offset);
        $data['total_rows']    = $this->Kategori_pengeluaran_model->count_all();
        $data['current_page']  = $page;
        $data['total_pages']   = ceil($data['total_rows'] / $per_page);

        $this->load->view('templates/header');
        $this->load->view('kategori_pengeluaran/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        if ($this->input->method() !== 'post') {
            $this->load->view('templates/header');
            $this->load->view('kategori_pengeluaran/form_tambah');
            $this->load->view('templates/footer');
            return;
        }

        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            $this->load->view('templates/header');
            $this->load->view('kategori_pengeluaran/form_tambah');
            $this->load->view('templates/footer');
            return;
        }

        $data = [
            'nama_kategori' => $this->input->post('nama_kategori', TRUE),
            'keterangan'    => $this->input->post('keterangan', TRUE),
            'status'        => 'aktif',
        ];

        $this->Kategori_pengeluaran_model->create($data);
        $this->session->set_flashdata('success', 'Kategori pengeluaran berhasil ditambahkan');
        redirect('kategori_pengeluaran');
    }

    public function edit($id)
    {
        $kategori = $this->Kategori_pengeluaran_model->get_by_id($id);
        if (!$kategori) {
            show_404();
        }

        if ($this->input->method() !== 'post') {
            $data['kategori'] = $kategori;
            $this->load->view('templates/header');
            $this->load->view('kategori_pengeluaran/form_edit', $data);
            $this->load->view('templates/footer');
            return;
        }

        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['kategori'] = $kategori;
            $this->session->set_flashdata('error', validation_errors());
            $this->load->view('templates/header');
            $this->load->view('kategori_pengeluaran/form_edit', $data);
            $this->load->view('templates/footer');
            return;
        }

        $data = [
            'nama_kategori' => $this->input->post('nama_kategori', TRUE),
            'keterangan'    => $this->input->post('keterangan', TRUE),
        ];

        $this->Kategori_pengeluaran_model->update($id, $data);
        $this->session->set_flashdata('success', 'Kategori pengeluaran berhasil diperbarui');
        redirect('kategori_pengeluaran');
    }

    public function nonaktifkan($id)
    {
        $this->Kategori_pengeluaran_model->update($id, ['status' => 'nonaktif']);
        $this->session->set_flashdata('success', 'Kategori berhasil dinonaktifkan');
        redirect('kategori_pengeluaran');
    }

    public function aktifkan($id)
    {
        $this->Kategori_pengeluaran_model->update($id, ['status' => 'aktif']);
        $this->session->set_flashdata('success', 'Kategori berhasil diaktifkan');
        redirect('kategori_pengeluaran');
    }

    public function hapus($id)
    {
        if ($this->Kategori_pengeluaran_model->is_used_in_pengeluaran($id)) {
            $this->session->set_flashdata('error', 'Tidak bisa dihapus, kategori ini sudah dipakai di data pengeluaran. Nonaktifkan saja.');
            redirect('kategori_pengeluaran');
            return;
        }

        $this->Kategori_pengeluaran_model->delete($id);
        $this->session->set_flashdata('success', 'Kategori pengeluaran berhasil dihapus');
        redirect('kategori_pengeluaran');
    }
}