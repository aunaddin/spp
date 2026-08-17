<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Format:
 * 'label' => teks menu
 * 'icon'  => class fontawesome
 * 'url'   => segment URL (dipakai di site_url())
 * 'roles' => role yang boleh lihat menu ini
 */
$config['menu'] = [
    [
        'label' => 'Dashboard',
        'icon'  => 'fas fa-tachometer-alt',
        'url'   => 'dashboard',
        'roles' => ['admin', 'bendahara', 'wali_santri'],
    ],
    [
        'label' => 'Kelola Data Pengguna',
        'icon'  => 'fas fa-users-cog',
        'url'   => 'kelola_pengguna',
        'roles' => ['admin'],
    ],
    [
        'label' => 'Kelola Data Santri',
        'icon'  => 'fas fa-user-graduate',
        'url'   => 'kelola_santri',
        'roles' => ['admin', 'bendahara'],
    ],
    [
        'label' => 'Kelola Kelas',
        'icon'  => 'fas fa-chalkboard-teacher',
        'url'   => 'kelola_kelas',
        'roles' => ['admin', 'bendahara'],
    ],
    [
        'label' => 'Kelola Jenis Pembayaran',
        'icon'  => 'fas fa-list',
        'url'   => 'jenis_pembayaran',
        'roles' => ['admin', 'bendahara'],
    ],
    [
        'label' => 'Kelola Data Tagihan',
        'icon'  => 'fas fa-file-invoice',
        'url'   => 'tagihan',
        'roles' => ['admin', 'bendahara'],
    ],
    [
        'label' => 'Transaksi Pembayaran',
        'icon'  => 'fas fa-cash-register',
        'url'   => 'transaksi',
        'roles' => ['admin', 'bendahara'],
    ],
    [
        'label' => 'Bayar via Transfer',
        'icon'  => 'fas fa-upload',
        'url'   => 'pembayaran-wali',
        'roles' => ['wali_santri'],
    ],
    [
        'label' => 'Konfirmasi Pembayaran',
        'icon'  => 'fas fa-check-circle',
        'url'   => 'transaksi/konfirmasi',
        'roles' => ['admin', 'bendahara'],
    ],
    [
        'label' => 'Riwayat Pembayaran',
        'icon'  => 'fas fa-history',
        'url'   => 'riwayat',
        'roles' => ['admin', 'bendahara', 'wali_santri'],
    ],
    [
        'label' => 'Pencarian Data Pembayaran',
        'icon'  => 'fas fa-search',
        'url'   => 'pencarian',
        'roles' => ['admin', 'bendahara', 'wali_santri'],
    ],
    [
        'label' => 'Cetak Laporan Pembayaran',
        'icon'  => 'fas fa-print',
        'url'   => 'laporan',
        'roles' => ['admin', 'bendahara'],
    ],
    [
        'label' => 'Kategori Pengeluaran',
        'icon'  => 'fas fa-tags',
        'url'   => 'kategori_pengeluaran',
        'roles' => ['admin', 'bendahara'],
    ],
    [
        'label' => 'Data Pengeluaran',
        'icon'  => 'fas fa-money-bill-wave',
        'url'   => 'pengeluaran',
        'roles' => ['admin', 'bendahara'],
    ],
    [
        'label' => 'Laporan Keuangan',
        'icon'  => 'fas fa-chart-pie',
        'url'   => 'laporan_keuangan',
        'roles' => ['admin', 'bendahara'],
    ],
    [
        'label' => 'Kelola Profil Akun',
        'icon'  => 'fas fa-user-edit',
        'url'   => 'profil',
        'roles' => ['admin', 'bendahara', 'wali_santri'],
    ],
];