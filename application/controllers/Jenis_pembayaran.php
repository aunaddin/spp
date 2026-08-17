<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_pembayaran extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->cek_akses(['admin', 'bendahara']);
        $this->load->model('Jenis_pembayaran_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $per_page = 10;
        $page     = max(1, (int) $this->input->get('page'));
        $offset   = ($page - 1) * $per_page;

        $data['jenis']         = $this->Jenis_pembayaran_model->get_all($per_page, $offset);
        $data['total_rows']    = $this->Jenis_pembayaran_model->count_all();
        $data['current_page']  = $page;
        $data['total_pages']   = ceil($data['total_rows'] / $per_page);

        $this->load->view('templates/header');
        $this->load->view('jenis_pembayaran/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        if ($this->input->method() !== 'post') {
            $this->load->view('templates/header');
            $this->load->view('jenis_pembayaran/form_tambah');
            $this->load->view('templates/footer');
            return;
        }

        $this->form_validation->set_rules('nama_pembayaran', 'Nama Pembayaran', 'required|trim');
        $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric|greater_than[0]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            $this->load->view('templates/header');
            $this->load->view('jenis_pembayaran/form_tambah');
            $this->load->view('templates/footer');
            return;
        }

        $data = [
            'nama_pembayaran' => $this->input->post('nama_pembayaran', TRUE),
            'nominal'         => $this->input->post('nominal', TRUE),
            'keterangan'      => $this->input->post('keterangan', TRUE),
            'status'          => 'aktif',
        ];

        $this->Jenis_pembayaran_model->create($data);
        $this->session->set_flashdata('success', 'Jenis pembayaran berhasil ditambahkan');
        redirect('jenis_pembayaran');
    }

    public function edit($id)
    {
        $jenis = $this->Jenis_pembayaran_model->get_by_id($id);
        if (!$jenis) {
            show_404();
        }

        if ($this->input->method() !== 'post') {
            $data['jenis'] = $jenis;
            $this->load->view('templates/header');
            $this->load->view('jenis_pembayaran/form_edit', $data);
            $this->load->view('templates/footer');
            return;
        }

        $this->form_validation->set_rules('nama_pembayaran', 'Nama Pembayaran', 'required|trim');
        $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric|greater_than[0]');

        if ($this->form_validation->run() == FALSE) {
            $data['jenis'] = $jenis;
            $this->session->set_flashdata('error', validation_errors());
            $this->load->view('templates/header');
            $this->load->view('jenis_pembayaran/form_edit', $data);
            $this->load->view('templates/footer');
            return;
        }

        $data = [
            'nama_pembayaran' => $this->input->post('nama_pembayaran', TRUE),
            'nominal'         => $this->input->post('nominal', TRUE),
            'keterangan'      => $this->input->post('keterangan', TRUE),
        ];

        $this->Jenis_pembayaran_model->update($id, $data);
        $this->session->set_flashdata('success', 'Jenis pembayaran berhasil diperbarui');
        redirect('jenis_pembayaran');
    }

    public function nonaktifkan($id)
    {
        $this->Jenis_pembayaran_model->update($id, ['status' => 'nonaktif']);
        $this->session->set_flashdata('success', 'Jenis pembayaran berhasil dinonaktifkan');
        redirect('jenis_pembayaran');
    }

    public function aktifkan($id)
    {
        $this->Jenis_pembayaran_model->update($id, ['status' => 'aktif']);
        $this->session->set_flashdata('success', 'Jenis pembayaran berhasil diaktifkan');
        redirect('jenis_pembayaran');
    }

    public function hapus($id)
    {
        // Cegah hapus kalau sudah dipakai di tagihan (jaga integritas data)
        if ($this->Jenis_pembayaran_model->is_used_in_tagihan($id)) {
            $this->session->set_flashdata('error', 'Tidak bisa dihapus, jenis pembayaran ini sudah dipakai di data tagihan. Nonaktifkan saja.');
            redirect('jenis_pembayaran');
            return;
        }

        $this->Jenis_pembayaran_model->delete($id);
        $this->session->set_flashdata('success', 'Jenis pembayaran berhasil dihapus');
        redirect('jenis_pembayaran');
    }
}