<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url() ?>public/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/assets/css/custom.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/assets/css/upload.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/assets/css/modal.css">
    <style>
        html {
            font-size: .9rem !important;
        }

        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }

        .blink {
            animation: blink 1s ease-in-out;
        }

        .img-circle {
            background-color: #0988aa;
            /* Mengubah warna latar belakang */
            color: white;
            /* Warna teks */
            font-size: 18px;
            /* Ukuran font */
            width: 40px;
            height: 40px;
            border-radius: 50%;
            /* Membuat lingkaran */
            text-align: center;
            line-height: 40px;
            /* Menyelaraskan teks di tengah */
            font-weight: bold;
        }
    </style>

    <style>
        .alert-custom hr {
            border-top: 1.5px solid #ffffff;
            /* Warna garis pemisah */
        }

        .card-successku {
            background-color: #a2e1b8;
            color: rgb(0, 0, 0);
            border: none;
        }

        .card-successku .card-body {
            background-color: #ffffff !important;
            color: #000000;
            border: none;
        }

        .card-primaryku {
            background-color: rgb(95, 176, 216);
            color: rgb(0, 0, 0);
            border: none;
        }

        .card-primaryku .card-body {
            background-color: #ffffff !important;
            color: #000000;
            border: none;
        }

        .card-dangerku {
            background-color: rgb(186, 89, 89);
            color: rgb(0, 0, 0);
            border: none;
        }

        .card-dangerku .card-body {
            background-color: #ffffff !important;
            color: #000000;
            border: none;
        }

        .card-infoku {
            background-color: rgb(123, 229, 255);
            color: rgb(0, 0, 0);
            /* Warna teks */
            border: none;
        }

        .card-infoku .card-body {
            background-color: #ffffff !important;
            color: #000000;
            border: none;
        }

        .card-warningku {
            background-color: rgb(253, 255, 151);
            color: rgb(0, 0, 0);
            border: none;
        }

        .card-warningku .card-body {
            background-color: #ffffff !important;
            color: #000000;
            border: none;
        }

        .card-secondaryku {
            background-color: #39cccc;
            color: rgb(0, 0, 0);
            border: none;
        }

        .card-secondaryku .card-body {
            background-color: #ffffff !important;
            color: #000000;
            border: none;
        }



        .btn-tool {
            color: black;
        }

        .card-aprioriku .card-body {
            background-color: #ffffff !important;
            color: #000000;
            border: none;
        }

        .card-aprioriku {
            background-color: #3c8dbc;
            color: #ffffff;
            border: none;
        }




        .custom-alert-danger {
            background-color: #ffcccc;
            /* Change to your preferred background color */
            color: #590000;
            /* Change to your preferred text color */

        }

        .custom-alert-danger .alert-icon {
            color: #590000;
            /* Change to match the border or text color */
        }


        .custom-alert-success {
            background-color: #a2e1b8;
            /* Change to your preferred background color */
            color: #064936;
            /* Change to your preferred text color */

        }

        .custom-alert-success .alert-icon {
            color: #064936;
            /* Change to match the border or text color */
        }


        /* Gaya untuk background lebih gelap dan opasitas */
        .small-box.bg-info {
            background-color: rgb(24, 120, 135) !important;
            /* Warna biru dengan opasitas */
            color: #fff;
            /* Teks berwarna putih */
        }

        .small-box.bg-success {
            background-color: rgb(2, 142, 98) !important;
            /* Warna hijau dengan opasitas */
            color: #fff;
            /* Teks berwarna putih */
        }

        .small-box.bg-primary {
            background-color: rgb(183, 71, 47) !important;
            /* Warna hijau dengan opasitas */
            color: #fff;
            /* Teks berwarna putih */
        }

        /* Gaya untuk footer box */
        .small-box-footer {
            background-color: rgba(0, 0, 0, 0.3);
            /* Gelap dengan sedikit transparansi */
            color: #fff;
            /* Teks putih */
        }

        /* Gaya ikon */
        .small-box .icon {
            color: #fff;
            /* Ikon dengan warna putih */
        }

        /* Sesuaikan teks di dalam kotak */
        .small-box .inner h3 {
            font-weight: bold;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
    <!-- Site wrapper -->
    <div class="wrapper">