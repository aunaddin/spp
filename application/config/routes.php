<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'auth';
$route['forgot-password']          = 'ForgotPasswordController/index';
$route['forgot-password/kirim']    = 'ForgotPasswordController/kirim';
$route['reset-password/(:any)']    = 'ForgotPasswordController/reset/$1';
$route['dashboard']  = 'dashboard';

$route['kelola_pengguna']              = 'kelola_pengguna/index';
$route['kelola_pengguna/tambah']       = 'kelola_pengguna/tambah';
$route['kelola_pengguna/edit/(:num)']  = 'kelola_pengguna/edit/$1';

$route['kelola_santri']             = 'kelola_santri/index';
$route['kelola_santri/tambah']      = 'kelola_santri/tambah';
$route['kelola_santri/edit/(:num)'] = 'kelola_santri/edit/$1';

$route['jenis_pembayaran']              = 'jenis_pembayaran/index';
$route['jenis_pembayaran/tambah']       = 'jenis_pembayaran/tambah';
$route['jenis_pembayaran/edit/(:num)']  = 'jenis_pembayaran/edit/$1';

$route['tagihan']              = 'tagihan/index';
$route['tagihan/generate']     = 'tagihan/generate';
$route['tagihan/tambah']       = 'tagihan/tambah';
$route['tagihan/edit/(:num)']  = 'tagihan/edit/$1';

$route['transaksi']                = 'transaksi/index';
$route['transaksi/bayar/(:num)']   = 'transaksi/bayar/$1';
$route['transaksi/bukti/(:num)']   = 'transaksi/bukti/$1';

$route['riwayat'] = 'riwayat/index';

$route['pencarian'] = 'pencarian/index';

$route['laporan']       = 'laporan/index';
$route['laporan/cetak'] = 'laporan/cetak';

$route['profil'] = 'profil/index';

$route['kategori_pengeluaran']              = 'kategori_pengeluaran/index';
$route['kategori_pengeluaran/tambah']       = 'kategori_pengeluaran/tambah';
$route['kategori_pengeluaran/edit/(:num)']  = 'kategori_pengeluaran/edit/$1';

$route['pengeluaran']              = 'pengeluaran/index';
$route['pengeluaran/tambah']       = 'pengeluaran/tambah';
$route['pengeluaran/edit/(:num)']  = 'pengeluaran/edit/$1';

$route['laporan_keuangan']       = 'laporan_keuangan/index';
$route['laporan_keuangan/cetak'] = 'laporan_keuangan/cetak';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['pembayaran-wali']              = 'Pembayaran_wali/index';
$route['pembayaran-wali/bayar/(:num)'] = 'Pembayaran_wali/bayar/$1';

$route['transaksi/konfirmasi']               = 'transaksi/konfirmasi';
$route['transaksi/detail-konfirmasi/(:num)'] = 'transaksi/detail_konfirmasi/$1';
$route['transaksi/setujui/(:num)']           = 'transaksi/setujui/$1';
$route['transaksi/tolak/(:num)']             = 'transaksi/tolak/$1';