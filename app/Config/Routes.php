<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//Routes Block Aset
$routes->get('/aset', 'Aset::index', ['filter' => 'role:superuser,hdo']);
$routes->get('/aset/index', 'Aset::index', ['filter' => 'role:superuser,hdo']);
$routes->get('/aset/detail', 'Aset::detail', ['filter' => 'role:superuser,hdo']);
$routes->get('/aset/tambah', 'Aset::tambah', ['filter' => 'role:superuser,hdo']);
$routes->get('/aset/simpan', 'Aset::tamsimpanbah', ['filter' => 'role:superuser,hdo']);
$routes->get('/aset/edit', 'Aset::edit', ['filter' => 'role:superuser,hdo']);
$routes->get('/aset/update', 'Aset::update', ['filter' => 'role:superuser,hdo']);
$routes->get('/aset/hapus', 'Aset::hapus', ['filter' => 'role:superuser,hdo']);

//Routes Block BTS
$routes->get('/bts', 'Bts::index', ['filter' => 'role:superuser,teknisi,hdo']);
$routes->get('/bts/index', 'Bts::index', ['filter' => 'role:superuser,teknisi,hdo']);
$routes->get('/bts/detail', 'Bts::detail', ['filter' => 'role:superuser,teknisi,hdo']);
$routes->get('/bts/tambah', 'Bts::tambah', ['filter' => 'role:superuser,teknisi,hdo']);
$routes->get('/bts/simpan', 'Bts::tambah', ['filter' => 'role:superuser,teknisi,hdo']);
$routes->get('/bts/edit', 'Bts::edit', ['filter' => 'role:superuser,teknisi,hdo']);
$routes->get('/bts/update', 'Bts::update', ['filter' => 'role:superuser,teknisi,hdo']);
$routes->get('/bts/hapus', 'Bts::hapus', ['filter' => 'role:superuser,teknisi,hdo']);

//Routes Block Error
$routes->get('/error', 'Error::index', ['filter' => 'role:superuser,teknisi,hdo']);
$routes->get('/error/index', 'Error::index', ['filter' => 'role:superuser,teknisi,hdo']);
$routes->get('/error/ajaxSearch', 'Error::ajaxSearch', ['filter' => 'role:superuser,teknisi,hdo,admin']);
$routes->get('/error/detail', 'Error::detail', ['filter' => 'role:superuser,teknisi,hdo']);
$routes->get('/error/tambah', 'Error::tambah', ['filter' => 'role:superuser,teknisi,hdo']);
$routes->get('/error/simpan', 'Error::simpan', ['filter' => 'role:superuser,teknisi,hdo']);
$routes->get('/error/edit', 'Error::edit', ['filter' => 'role:superuser,teknisi,hdo']);
$routes->get('/error/update', 'Error::update', ['filter' => 'role:superuser,teknisi,hdo']);
$routes->get('/error/hapus', 'Error::hapus', ['filter' => 'role:superuser,teknisi,hdo']);

//Routes Block Jurnal Keuangan
$routes->get('/jurnal', 'Jurnal::index', ['filter' => 'role:superuser,admin']);
$routes->get('/jurnal/index', 'Jurnal::index', ['filter' => 'role:superuser,admin']);

//Routes Block Kuitansi
$routes->get('/kuitansi', 'Kuitansi::index', ['filter' => 'role:superuser,admin']);
$routes->get('/kuitansi/index', 'Kuitansi::index', ['filter' => 'role:superuser,admin']);
$routes->get('/kuitansi/tambah', 'Kuitansi::tambah', ['filter' => 'role:superuser,admin']);
$routes->get('/kuitansi/simpan', 'Kuitansi::simpan', ['filter' => 'role:superuser,admin']);
$routes->get('/kuitansi/downloadkuitansi', 'Kuitansi::downloadkuitansi', ['filter' => 'role:superuser,admin']);
$routes->get('/kuitansi/edit', 'Kuitansi::edit', ['filter' => 'role:superuser,admin']);
$routes->get('/kuitansi/update', 'Kuitansi::update', ['filter' => 'role:superuser,admin']);
$routes->get('/kuitansi/hapus', 'Kuitansi::hapus', ['filter' => 'role:superuser,admin']);

//Routes Block Pekerjaan
$routes->get('/pekerjaan', 'Pekerjaan::index', ['filter' => 'role:superuser,hdo']);
$routes->get('/pekerjaan/index', 'Pekerjaan::index', ['filter' => 'role:superuser,hdo']);
$routes->get('/pekerjaan/tambah', 'Pekerjaan::tambah', ['filter' => 'role:superuser,hdo']);
$routes->get('/pekerjaan/workorder', 'Pekerjaan::workorder', ['filter' => 'role:superuser,hdo,teknisi']);
$routes->get('/pekerjaan/ajaxSearch', 'Pekerjaan::ajaxSearch', ['filter' => 'role:superuser,hdo,teknisi,admin']);
$routes->get('/pekerjaan/simpan', 'Pekerjaan::simpan', ['filter' => 'role:superuser,hdo']);
$routes->get('/pekerjaan/simpanteknisi', 'Pekerjaan::simpanteknisi', ['filter' => 'role:superuser,hdo,teknisi']);
$routes->get('/pekerjaan/verifikasi', 'Pekerjaan::verifikasi', ['filter' => 'role:superuser,hdo']);
$routes->get('/pekerjaan/submit', 'Pekerjaan::submit', ['filter' => 'role:superuser,hdo']);
$routes->get('/pekerjaan/lihat', 'Pekerjaan::lihat', ['filter' => 'role:superuser,hdo']);
$routes->get('/pekerjaan/edit', 'Pekerjaan::edit', ['filter' => 'role:superuser,hdo']);
$routes->get('/pekerjaan/update', 'Pekerjaan::update', ['filter' => 'role:superuser,hdo']);
$routes->get('/pekerjaan/hapus', 'Pekerjaan::hapus', ['filter' => 'role:superuser,hdo']);

//Routes Block Pelanggan
$routes->get('/pelanggan', 'Pelanggan::index', ['filter' => 'role:superuser,hdo,admin']);
$routes->get('/pelanggan/index', 'Pelanggan::index', ['filter' => 'role:superuser,hdo,admin']);
$routes->get('/pelanggan/detail', 'Pelanggan::detail', ['filter' => 'role:superuser,hdo,admin']);
$routes->get('/pelanggan/tambah', 'Pelanggan::tambah', ['filter' => 'role:superuser,hdo,admin']);
$routes->get('/pelanggan/simpan', 'Pelanggan::simpan', ['filter' => 'role:superuser,hdo,admin']);
$routes->get('/pelanggan/activate', 'Pelanggan::activate', ['filter' => 'role:superuser,hdo,admin']);
$routes->get('/pelanggan/edit', 'Pelanggan::edit', ['filter' => 'role:superuser,hdo,admin']);
$routes->get('/pelanggan/update', 'Pelanggan::update', ['filter' => 'role:superuser,hdo,admin']);
$routes->post('user/ajaxList', 'User::ajaxList', ['filter' => 'role:superuser,hdo,admin']);

//Routes Block Pemasukan
$routes->get('/pemasukan', 'Pemasukan::index', ['filter' => 'role:superuser,admin']);
$routes->get('/pemasukan/index', 'Pemasukan::index', ['filter' => 'role:superuser,admin']);
$routes->get('/pemasukan/tambah', 'Pemasukan::tambah', ['filter' => 'role:superuser,admin']);
$routes->get('/pemasukan/simpan', 'Pemasukan::simpan', ['filter' => 'role:superuser,admin']);
$routes->get('/pemasukan/ajaxSearch', 'Pemasukan::ajaxSearch', ['filter' => 'role:superuser,admin,hdo,teknisi']);
$routes->get('/pemasukan/edit', 'Pemasukan::edit', ['filter' => 'role:superuser,admin']);
$routes->get('/pemasukan/update', 'Pemasukan::update', ['filter' => 'role:superuser,admin']);
$routes->get('/pemasukan/downloadinvoice', 'Pemasukan::downloadinvoice', ['filter' => 'role:superuser,admin']);
$routes->get('/pemasukan/konfirmasi', 'Pemasukan::konfirmasi', ['filter' => 'role:superuser,admin']);
$routes->get('/pemasukan/bayar', 'Pemasukan::bayar', ['filter' => 'role:superuser,admin']);
$routes->get('/pemasukan/downloadkuitansi', 'Pemasukan::downloadkuitansi', ['filter' => 'role:superuser,admin']);
$routes->get('/pemasukan/kuitansi', 'Pemasukan::kuitansi', ['filter' => 'role:superuser,admin']);
$routes->get('/pemasukan/hapus', 'Pemasukan::hapus', ['filter' => 'role:superuser,admin']);

//Routes Block Pendaftaran
$routes->get('/pendaftaran', 'Pendaftaran::index', ['filter' => 'role:superuser,hdo,admin,teknisi']);
$routes->get('/pendaftaran/index', 'Pendaftaran::index', ['filter' => 'role:superuser,hdo,admin,teknisi']);
$routes->get('/pendaftaran/detail', 'Pendaftaran::detail', ['filter' => 'role:superuser,hdo,admin,teknisi']);
$routes->get('/pendaftaran/tambah', 'Pendaftaran::tambah', ['filter' => 'role:superuser,hdo,admin,teknisi']);
$routes->get('/pendaftaran/simpan', 'Pendaftaran::simpan', ['filter' => 'role:superuser,hdo,admin,teknisi']);
$routes->get('/pendaftaran/updatestatus', 'Pendaftaran::updatestatus', ['filter' => 'role:superuser,hdo,admin,teknisi']);
$routes->get('/pendaftaran/tolak', 'Pendaftaran::tolak', ['filter' => 'role:superuser,hdo,admin,teknisi']);
$routes->get('/pendaftaran/registrasi', 'Pendaftaran::registrasi', ['filter' => 'role:superuser,hdo,admin,teknisi']);
$routes->get('/pendaftaran/edit', 'Pendaftaran::edit', ['filter' => 'role:superuser,hdo,admin,teknisi']);
$routes->get('/pendaftaran/update', 'Pendaftaran::update', ['filter' => 'role:superuser,hdo,admin,teknisi']);

//Routes Block Pengeluaran
$routes->get('/pengeluaran', 'Pengeluaran::index', ['filter' => 'role:superuser,admin']);
$routes->get('/pengeluaran/index', 'Pengeluaran::index', ['filter' => 'role:superuser,admin']);
$routes->get('/pengeluaran/detail', 'Pengeluaran::detail', ['filter' => 'role:superuser,admin']);
$routes->get('/pengeluaran/tambah', 'Pengeluaran::tambah', ['filter' => 'role:superuser,admin']);
$routes->get('/pengeluaran/simpan', 'Pengeluaran::simpan', ['filter' => 'role:superuser,admin']);
$routes->get('/pengeluaran/edit', 'Pengeluaran::edit', ['filter' => 'role:superuser,admin']);
$routes->get('/pengeluaran/update', 'Pengeluaran::update', ['filter' => 'role:superuser,admin']);

//Routes Block Tagihan
$routes->get('/tagihan', 'Tagihan::index', ['filter' => 'role:superuser,admin']);
$routes->get('/tagihan/index', 'Tagihan::index', ['filter' => 'role:superuser,admin']);
$routes->get('/tagihan/tampilkan', 'Tagihan::tampilkan', ['filter' => 'role:superuser,admin']);
$routes->get('/tagihan/download', 'Tagihan::download', ['filter' => 'role:superuser,admin']);
$routes->get('/tagihan/downloadlastreport', 'Tagihan::downloadlastreport', ['filter' => 'role:superuser,admin']);
$routes->get('/tagihan/downloadinvoice', 'Tagihan::downloadinvoice', ['filter' => 'role:superuser,admin']);
$routes->get('/tagihan/downloadkuitansi', 'Tagihan::downloadkuitansi', ['filter' => 'role:superuser,admin']);
$routes->get('/tagihan/generate', 'Tagihan::generate', ['filter' => 'role:superuser,admin']);
$routes->get('/tagihan/daftar', 'Tagihan::daftar', ['filter' => 'role:superuser,admin']);
$routes->get('/tagihan/konfirmasi', 'Tagihan::konfirmasi', ['filter' => 'role:superuser,admin']);
$routes->get('/tagihan/bayar', 'Tagihan::bayar', ['filter' => 'role:superuser,admin']);
$routes->get('/tagihan/kuitansi', 'Tagihan::kuitansi', ['filter' => 'role:superuser,admin']);

//Routes Block Users
$routes->get('/users', 'Users::index', ['filter' => 'role:superuser']);
$routes->get('/users/index', 'Users::index', ['filter' => 'role:superuser']);
$routes->get('/users/tambah', 'Users::tambah', ['filter' => 'role:superuser']);
$routes->get('/users/save', 'Users::save', ['filter' => 'role:superuser']);
$routes->get('/users/activate', 'Users::activate', ['filter' => 'role:superuser,admin,hdo,teknisi']);
$routes->get('/users/changePassword', 'Users::changePassword', ['filter' => 'role:superuser']);
$routes->get('/users/setPassword', 'Users::setPassword', ['filter' => 'role:superuser,admin,hdo,teknisi']);
$routes->get('/users/changeGroup', 'Users::changeGroup', ['filter' => 'role:superuser']);

//Routes Block Log
$routes->get('/log', 'Log::index', ['filter' => 'role:superuser,hdo']);
$routes->get('/log/index', 'Log::index', ['filter' => 'role:superuser,hdo']);
