<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'LoginController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'LoginController';
$route['auth/login'] = 'LoginController/login';
$route['logout'] = 'LoginController/logout';

$route['dashboard'] = 'admin/DashboardController';
$route['kategori'] = 'admin/KategoriController';
$route['data-set'] = 'admin/DataSetController';
$route['data-set/upload'] = 'admin/DataSetController/upload';
$route['data-set/sample'] = 'admin/DataSetController/download_sample';

$route['probabilitas'] = 'admin/ProbabilitasController';
$route['perhitungan'] = 'admin/PerhitunganController';
$route['perhitungan/prediksi'] = 'admin/PerhitunganController/prediksi';
$route['perhitungan/export'] = 'admin/PerhitunganController/export_pdf';
$route['perhitungan/predict_by_date'] = 'admin/PerhitunganController/predict_by_date_new';

$route['prediksi-minat'] = 'admin/PrediksiMinatController';
$route['prediksi-minat/act-result'] = 'admin/PrediksiMinatController/predict_interest';
$route['klasifikasi'] = 'admin/KlasifikasiController';
$route['klasifikasi/filter'] = 'admin/KlasifikasiController/filter_by_date_ajax';
$route['klasifikasi/export_to_excel'] = 'admin/KlasifikasiController/export_to_excel';

$route['riwayat-hasil'] = 'admin/HasilController';
$route['result'] = 'admin/HasilController';
$route['riwayat-hasil/export'] = 'admin/PerhitunganController/export_pdf';
$route['pengguna'] = 'admin/PenggunaController';
$route['profil'] = 'admin/ProfilController';

// prediction/proses_prediksi
$route['prediksi'] = 'Prediction';
$route['prediksi/proses'] = 'prediction/proses_prediksi';
$route['data-set/delete-selected'] = 'admin/DataSetController/delete_selected';
$route['data-set/delete-data'] = 'admin/DataSetController/delete_data';

$route['naivebayes/predict_by_range'] = 'admin/PerhitunganController/predict_by_range';
$route['perhitungan/detail/(:any)'] = 'admin/PerhitunganController/detail/$1';
$route['perhitungan/filterByPeriode'] = 'admin/PerhitunganController/filterByPeriode';

// $route['data-set'] = 'admin/DataSetController';
