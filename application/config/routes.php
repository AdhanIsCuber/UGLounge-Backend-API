<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//---------------------------------api komentar----------------------------------------------------

$route['api/komentar']['GET']                          = 'api/apikomentar/komentar';
$route['api/komentar/format/(:any)']['GET']            = 'api/apikomentar/komentar/format/$1';
$route['api/komentar/(:num)']['GET']                   = 'api/apikomentar/komentar/id/$1';
$route['api/komentar/(:num)/format/(:any)']['GET']     = 'api/apikomentar/komentar/id/$1/format/$2';

$route['api/komentar']['POST']                         = 'api/apikomentar/komentar';
$route['api/komentar/(:num)']['PUT']                   = 'api/apikomentar/komentar/id/$1';
$route['api/komentar/(:num)']['DELETE']                = 'api/apikomentar/komentar/id/$1';

//---------------------------------api pengaduan----------------------------------------------------

$route['api/pengaduan']['GET']                          = 'api/apipengaduan/pengaduan';
$route['api/pengaduan/format/(:any)']['GET']            = 'api/apipengaduan/pengaduan/format/$1';
$route['api/pengaduan/(:num)']['GET']                   = 'api/apipengaduan/pengaduan/id/$1';
$route['api/pengaduan/(:num)/format/(:any)']['GET']     = 'api/apipengaduan/pengaduan/id/$1/format/$2';

$route['api/pengaduan']['POST']                         = 'api/apipengaduan/pengaduan';
$route['api/pengaduan/(:num)']['PUT']                   = 'api/apipengaduan/pengaduan/id/$1';
$route['api/pengaduan/(:num)']['DELETE']                = 'api/apipengaduan/pengaduan/id/$1';

//---------------------------------api pengguna----------------------------------------------------

$route['api/pengguna']['GET']                          = 'api/apipengguna/pengguna';
$route['api/pengguna/format/(:any)']['GET']            = 'api/apipengguna/pengguna/format/$1';
$route['api/pengguna/(:num)']['GET']                   = 'api/apipengguna/pengguna/id/$1';
$route['api/pengguna/(:num)/format/(:any)']['GET']     = 'api/apipengguna/pengguna/id/$1/format/$2';

$route['api/pengguna']['POST']                         = 'api/apipengguna/pengguna';
$route['api/pengguna/(:num)']['PUT']                   = 'api/apipengguna/pengguna/id/$1';
$route['api/pengguna/(:num)']['DELETE']                = 'api/apipengguna/pengguna/id/$1';

//---------------------------------api kategori jabatan----------------------------------------------

$route['api/kjabatan']['GET']                          = 'api/apikategori/jabatan';
$route['api/kjabatan/format/(:any)']['GET']            = 'api/apikategori/jabatan/format/$1';
$route['api/kjabatan/(:num)']['GET']                   = 'api/apikategori/jabatan/id/$1';
$route['api/kjabatan/(:num)/format/(:any)']['GET']     = 'api/apikategori/jabatan/id/$1/format/$2';

$route['api/kjabatan']['POST']                         = 'api/apikategori/jabatan';
$route['api/kjabatan/(:num)']['PUT']                   = 'api/apikategori/jabatan/id/$1';
$route['api/kjabatan/(:num)']['DELETE']                = 'api/apikategori/jabatan/id/$1';

//---------------------------------api kategori pengaduan--------------------------------------------

$route['api/kpengaduan']['GET']                          = 'api/apikategori/pengaduan';
$route['api/kpengaduan/format/(:any)']['GET']            = 'api/apikategori/pengaduan/format/$1';
$route['api/kpengaduan/(:num)']['GET']                   = 'api/apikategori/pengaduan/id/$1';
$route['api/kpengaduan/(:num)/format/(:any)']['GET']     = 'api/apikategori/pengaduan/id/$1/format/$2';

$route['api/kpengaduan']['POST']                         = 'api/apikategori/pengaduan';
$route['api/kpengaduan/(:num)']['PUT']                   = 'api/apikategori/pengaduan/id/$1';
$route['api/kpengaduan/(:num)']['DELETE']                = 'api/apikategori/pengaduan/id/$1';

//---------------------------------View Token---------------------------------------------------------
$route['api/login']['POST']                              = 'api/restdata/login';
