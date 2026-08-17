<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelola_kelas extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->cek_akses(['admin', 'bendahara']);
        $this->load->model('Kelas_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $per_page = 10;
        $page     = max(1, (int) $this->input->get('page'));
        $offset   = ($page - 1) * $per_page;

        $data['kelas']         = $this->Kelas_model->get_all($per_page, $offset);
        $data['total_rows']    = $this->Kelas_model->count_all();
        $data['current_page']  = $page;
        $data['total_pages']   = ceil($data['total_rows'] / $per_page);

        $this->load->view('templates/header');
        $this->load->view('kelas/index', $data);
        $this->load->view('templates/footer');
}

    public function tambah()
    {
        if ($this->input->method() !== 'post') {
            $this->load->view('templates/header');
            $this->load->view('kelas/form_tambah');
            $this->load->view('templates/footer');
            return;
        }

        $this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required|trim');
        $this->form_validation->set_rules('jenjang', 'Jenjang', 'required|in_list[MTs,MA]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            $this->load->view('templates/header');
            $this->load->view('kelas/form_tambah');
            $this->load->view('templates/footer');
            return;
        }

        $this->Kelas_model->create([
            'nama_kelas' => $this->input->post('nama_kelas', TRUE),
            'jenjang'    => $this->input->post('jenjang', TRUE),
            'status'     => 'aktif',
        ]);
        $this->session->set_flashdata('success', 'Kelas berhasil ditambahkan');
        redirect('kelola_kelas');
    }

    public function edit($id)
    {
        $kelas = $this->Kelas_model->get_by_id($id);
        if (!$kelas) show_404();

        if ($this->input->method() !== 'post') {
            $data['kelas'] = $kelas;
            $this->load->view('templates/header');
            $this->load->view('kelas/form_edit', $data);
            $this->load->view('templates/footer');
            return;
        }

        $this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required|trim');
        $this->form_validation->set_rules('jenjang', 'Jenjang', 'required|in_list[MTs,MA]');

        if ($this->form_validation->run() == FALSE) {
            $data['kelas'] = $kelas;
            $this->session->set_flashdata('error', validation_errors());
            $this->load->view('templates/header');
            $this->load->view('kelas/form_edit', $data);
            $this->load->view('templates/footer');
            return;
        }

        $this->Kelas_model->update($id, [
            'nama_kelas' => $this->input->post('nama_kelas', TRUE),
            'jenjang'    => $this->input->post('jenjang', TRUE),
        ]);
        $this->session->set_flashdata('success', 'Kelas berhasil diperbarui');
        redirect('kelola_kelas');
    }

    public function hapus($id)
    {
        if ($this->Kelas_model->is_used($id)) {
            $this->session->set_flashdata('error', 'Tidak bisa dihapus, kelas ini sudah dipakai santri');
            redirect('kelola_kelas');
            return;
        }
        $this->Kelas_model->delete($id);
        $this->session->set_flashdata('success', 'Kelas berhasil dihapus');
        redirect('kelola_kelas');
    }
}