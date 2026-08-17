<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $role;
    protected $user_id;
    protected $nama;

    public function __construct()
    {
        parent::__construct();

        // Cek sudah login atau belum
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        $this->role    = $this->session->userdata('role');
        $this->user_id = $this->session->userdata('user_id');
        $this->nama    = $this->session->userdata('nama');
    }

    // Panggil ini di awal method controller untuk membatasi akses per role
    // Contoh: $this->cek_akses(['admin']); atau $this->cek_akses(['admin','bendahara']);
    protected function cek_akses($allowed_roles)
    {
        if (!in_array($this->role, $allowed_roles)) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Akses Ditolak');
        }
    }
}