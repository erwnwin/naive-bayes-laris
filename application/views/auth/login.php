<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>public/assets/dist/img/logo-jastip.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>public/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap">
    <link rel="stylesheet" href="<?= base_url() ?>public/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/css/login.css">
    <!-- <style>
        
    </style> -->

</head>

<body class="hold-transition login-page">
    <div class="login-container">
        <div class="svg-container">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="svg1">
                <path fill="#1e7ba9" fill-opacity="0.15" d="M43.2,-70.9C53.7,-60.6,58.2,-44.6,62,-30.1C65.9,-15.6,69.2,-2.6,69.8,11.7C70.3,26,68.2,41.7,60.2,53.6C52.1,65.4,38,73.6,22.7,78.9C7.3,84.3,-9.5,86.7,-25.3,83.4C-41.1,80,-56,70.7,-67.2,58.1C-78.3,45.4,-85.7,29.4,-86.9,13.2C-88.1,-3,-83.2,-19.4,-74.1,-31.5C-65,-43.7,-51.7,-51.7,-38.6,-60.9C-25.6,-70.1,-12.8,-80.5,1.8,-83.4C16.4,-86.2,32.8,-81.3,43.2,-70.9Z" transform="translate(100 100)" />
            </svg>
            <!-- <svg id="sw-js-blob-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="svg2">
                <path fill="#1e7ba9" fill-opacity="0.15" d="M18.7,-22.8C23.9,-18,27.4,-11.7,28.6,-5.1C29.7,1.6,28.5,8.7,25.7,16C22.9,23.4,18.5,31.1,11.3,35.7C4.2,40.4,-5.8,41.9,-14.7,39.2C-23.5,36.4,-31.2,29.4,-35.8,20.9C-40.4,12.4,-41.9,2.4,-39.9,-6.7C-37.9,-15.7,-32.3,-23.7,-25,-28.2C-17.8,-32.6,-8.9,-33.4,-1,-32.1C6.8,-30.9,13.6,-27.6,18.7,-22.8Z" width="100%" height="100%" transform="translate(50 50)" stroke-width="0" style="transition: all 0.3s ease 0s;" stroke="url(#sw-gradient)"></path>
            </svg> -->
            <!-- <svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="svg3">
                <polygon points="50,15 90,85 10,85" fill="#1e7ba9" fill-opacity="0.15" />
            </svg> -->
            <!-- <svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="svg4">
                <rect x="25" y="25" width="50" height="50" fill="#1e7ba9" fill-opacity="0.15" transform="rotate(45 50 50)" />
            </svg> -->
            <svg id="sw-js-blob-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="svg5">
                <path fill="#1e7ba9" fill-opacity="0.15" d="M18.7,-22.8C23.9,-18,27.4,-11.7,28.6,-5.1C29.7,1.6,28.5,8.7,25.7,16C22.9,23.4,18.5,31.1,11.3,35.7C4.2,40.4,-5.8,41.9,-14.7,39.2C-23.5,36.4,-31.2,29.4,-35.8,20.9C-40.4,12.4,-41.9,2.4,-39.9,-6.7C-37.9,-15.7,-32.3,-23.7,-25,-28.2C-17.8,-32.6,-8.9,-33.4,-1,-32.1C6.8,-30.9,13.6,-27.6,18.7,-22.8Z" width="100%" height="100%" transform="translate(50 50)" stroke-width="0" style="transition: all 0.3s ease 0s;" stroke="url(#sw-gradient)"></path>
            </svg>
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="svg6">
                <path fill="#1e7ba9" fill-opacity="0.15" d="M43.2,-70.9C53.7,-60.6,58.2,-44.6,62,-30.1C65.9,-15.6,69.2,-2.6,69.8,11.7C70.3,26,68.2,41.7,60.2,53.6C52.1,65.4,38,73.6,22.7,78.9C7.3,84.3,-9.5,86.7,-25.3,83.4C-41.1,80,-56,70.7,-67.2,58.1C-78.3,45.4,-85.7,29.4,-86.9,13.2C-88.1,-3,-83.2,-19.4,-74.1,-31.5C-65,-43.7,-51.7,-51.7,-38.6,-60.9C-25.6,-70.1,-12.8,-80.5,1.8,-83.4C16.4,-86.2,32.8,-81.3,43.2,-70.9Z" transform="translate(100 100)" />
            </svg>
            <svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="svg7">
                <polygon points="30,20 80,75 10,85" fill="#1e7ba9" fill-opacity="0.15" />
            </svg>
            <svg version="1.1" viewBox="0 0 2000 2000" width="180" height="180" xmlns="http://www.w3.org/2000/svg" class="svg4">
                <path transform="translate(188,592)" d="m0 0 13 1h1595l16 1 1 1v810l-1 1h-1624l-2-2-1-785-7-12v-3l7-2 2-9zm1380 217-3 8-5 19-16 64-8 38-17 66-7 29v6h92l3-6 16-66 9-42 16-64 11-45v-5l-60-2zm-961 11-19 4-15 6-16 9-11 9-15 16-9 11-8 9-8 16-6 18-3 20v22l4 19 7 16 7 9 5 5 9 7 17 7 18 6 10 5 10 8 4 7v8l-6 9-10 7-11 4h-12l-11-4-16-10-15-14-6-7-3 1-16 27-12 19-11 19-6 12v3l19 11 21 10 21 7 21 4 10 1h16l17-2 18-5 16-8 11-8 16-15 8-10 11-18 9-19 9-27 3-16v-15l-3-17-5-13-6-10-7-8-10-6-17-5-20-4-9-4-8-7-3-9v-7l4-10 1-3 4-2 10-4h12l16 5 17 9 9 7 3-1 12-23 10-19 9-15 6-11-2-5-6-7-14-9-11-5-15-5-22-4-8-1zm216 3-20 4-12 5-16 10-14 11-8 7-7 8-12 13-7 11-5 10-6 18-3 19v25l3 16 7 16 6 9 5 6 11 8 15 6 15 4 14 7 9 7h2l2 4 2 6v7l-6 8-9 8-7 3-5 1h-9l-13-4-14-8-10-8-11-11-3-4-4 2-8 17-15 24-16 27-5 8v2l16 9 19 10 16 7 20 5 22 3h16l20-3 18-6 13-7 11-8 17-14 13-18 11-25 7-19 5-18 1-5v-26l-3-15-8-16-8-10-8-7-10-4-30-5-10-4-5-4-5-10v-10l4-10 8-6 6-2h16l15 5 15 8 10 8 3-4 17-32 10-18 8-14-1-6-9-9-13-8-14-6-17-5-20-3zm-425 1-3 2-10 56-7 40-9 60-9 51-10 56-10 54v5l21 1 67 1 3-9 7-37 12-67 6-35 6-43 11-61 13-71v-3zm562 7-1 1-4 32-10 50-14 66-5 32-3 24-1 19v16l1 19 5 22 5 12 8 11 7 8 14 10 9 4 13 3 7 1h30l21-3 36-9 16-6 15-9 9-8 6-5 9-15 8-13 11-23 6-18 6-27 27-142 9-46v-5l-25-1h-63l-14 67-13 64-15 72-5 16-5 9-8 7-12 5h-10l-8-4-8-9-2-4v-10l10-58 14-71 6-36 6-34 2-10v-4zm272 2-2 6-12 57-7 39-6 36-13 65-18 89-7 35 1 1 77 1h100l10-48 5-25v-8l-2-1h-82l5-27 3-16h64l10-1 6-28 8-41 1-12h-73l9-37h77l2-2 14-71 1-10-14-1-72-1zm304 229-11 3-11 6-10 9-7 9-6 13-3 15 1 13 4 12 7 11 9 8 10 5 7 2 9 1 12-2 12-5 9-6 9-9 6-10 5-11 1-5v-19l-4-13-7-11-7-7-10-6-10-3zm-433 128-12 3-11 6-7 7-2 3v6l6 9 7 7 8 7 3 1 2 5v5l-9 1-7-3-8-5-5 1-13 10 1 4 6 5 11 5 8 2h14l12-5 10-9 6-12 1-3v-8l-5-5-23-10-3-2v-3l5-3h8l10 5 5-2 6-5 2-7-3-5-9-4-5-1zm48 3-5 1-10 35-9 37v2l4 1h12l3-3 6-19 3-10 24 1-1 8-6 22v2l21 1 3-4 11-39 7-30v-5h-18l-4 10-6 17-8 1h-14l1-9 3-12v-7zm110 0-12 4-14 9-10 9-5 9-4 11v17l5 10 7 6 9 4 4 1h11l12-3 13-7 9-8 6-9 5-14 1-3v-16l-5-10-7-7-9-3zm61 3-3 5-12 36-10 32v2l21 1 2-1 7-23 1-2 20-1 12-2 8-6 5-8 3-9v-11l-4-6-5-4-5-2-6-1z" fill="#00B3F8" fill-opacity="0.15" />
                <path transform="translate(1258,1210)" d="m0 0h12l7 3 4 5 1 2v11l-6 12-9 8-10 4h-10l-7-3-4-5-2-5v-9l6-12 8-7z" fill="#00B3F8" fill-opacity="0.15" />
                <path transform="translate(1338,1210)" d="m0 0h9l9 3 2 5-3 6-9 6-4 1h-10l-1-2 5-17z" fill="#00B3F8" fill-opacity="0.15" />
                <path transform="translate(185,600)" d="m0 0h1v19l-3-4-5-8v-3l7-2z" fill="#FEFEFE" fill-opacity="0.15" />
                <path transform="translate(171,592)" d="m0 0h9v4l-9 1-1-4z" fill="#FEFEFE" fill-opacity="0.15" />
                <path transform="translate(197,585)" d="m0 0 5 1-1 2h-5z" fill="#FEFEFE" fill-opacity="0.15" />
            </svg>
            <svg version="1.1" viewBox="0 0 2000 2000" width="180" height="180" xmlns="http://www.w3.org/2000/svg" class="svg2">
                <path transform="translate(188,592)" d="m0 0 13 1h1595l16 1 1 1v810l-1 1h-1624l-2-2-1-785-7-12v-3l7-2 2-9zm1380 217-3 8-5 19-16 64-8 38-17 66-7 29v6h92l3-6 16-66 9-42 16-64 11-45v-5l-60-2zm-961 11-19 4-15 6-16 9-11 9-15 16-9 11-8 9-8 16-6 18-3 20v22l4 19 7 16 7 9 5 5 9 7 17 7 18 6 10 5 10 8 4 7v8l-6 9-10 7-11 4h-12l-11-4-16-10-15-14-6-7-3 1-16 27-12 19-11 19-6 12v3l19 11 21 10 21 7 21 4 10 1h16l17-2 18-5 16-8 11-8 16-15 8-10 11-18 9-19 9-27 3-16v-15l-3-17-5-13-6-10-7-8-10-6-17-5-20-4-9-4-8-7-3-9v-7l4-10 1-3 4-2 10-4h12l16 5 17 9 9 7 3-1 12-23 10-19 9-15 6-11-2-5-6-7-14-9-11-5-15-5-22-4-8-1zm216 3-20 4-12 5-16 10-14 11-8 7-7 8-12 13-7 11-5 10-6 18-3 19v25l3 16 7 16 6 9 5 6 11 8 15 6 15 4 14 7 9 7h2l2 4 2 6v7l-6 8-9 8-7 3-5 1h-9l-13-4-14-8-10-8-11-11-3-4-4 2-8 17-15 24-16 27-5 8v2l16 9 19 10 16 7 20 5 22 3h16l20-3 18-6 13-7 11-8 17-14 13-18 11-25 7-19 5-18 1-5v-26l-3-15-8-16-8-10-8-7-10-4-30-5-10-4-5-4-5-10v-10l4-10 8-6 6-2h16l15 5 15 8 10 8 3-4 17-32 10-18 8-14-1-6-9-9-13-8-14-6-17-5-20-3zm-425 1-3 2-10 56-7 40-9 60-9 51-10 56-10 54v5l21 1 67 1 3-9 7-37 12-67 6-35 6-43 11-61 13-71v-3zm562 7-1 1-4 32-10 50-14 66-5 32-3 24-1 19v16l1 19 5 22 5 12 8 11 7 8 14 10 9 4 13 3 7 1h30l21-3 36-9 16-6 15-9 9-8 6-5 9-15 8-13 11-23 6-18 6-27 27-142 9-46v-5l-25-1h-63l-14 67-13 64-15 72-5 16-5 9-8 7-12 5h-10l-8-4-8-9-2-4v-10l10-58 14-71 6-36 6-34 2-10v-4zm272 2-2 6-12 57-7 39-6 36-13 65-18 89-7 35 1 1 77 1h100l10-48 5-25v-8l-2-1h-82l5-27 3-16h64l10-1 6-28 8-41 1-12h-73l9-37h77l2-2 14-71 1-10-14-1-72-1zm304 229-11 3-11 6-10 9-7 9-6 13-3 15 1 13 4 12 7 11 9 8 10 5 7 2 9 1 12-2 12-5 9-6 9-9 6-10 5-11 1-5v-19l-4-13-7-11-7-7-10-6-10-3zm-433 128-12 3-11 6-7 7-2 3v6l6 9 7 7 8 7 3 1 2 5v5l-9 1-7-3-8-5-5 1-13 10 1 4 6 5 11 5 8 2h14l12-5 10-9 6-12 1-3v-8l-5-5-23-10-3-2v-3l5-3h8l10 5 5-2 6-5 2-7-3-5-9-4-5-1zm48 3-5 1-10 35-9 37v2l4 1h12l3-3 6-19 3-10 24 1-1 8-6 22v2l21 1 3-4 11-39 7-30v-5h-18l-4 10-6 17-8 1h-14l1-9 3-12v-7zm110 0-12 4-14 9-10 9-5 9-4 11v17l5 10 7 6 9 4 4 1h11l12-3 13-7 9-8 6-9 5-14 1-3v-16l-5-10-7-7-9-3zm61 3-3 5-12 36-10 32v2l21 1 2-1 7-23 1-2 20-1 12-2 8-6 5-8 3-9v-11l-4-6-5-4-5-2-6-1z" fill="#00B3F8" fill-opacity="0.15" />
                <path transform="translate(1258,1210)" d="m0 0h12l7 3 4 5 1 2v11l-6 12-9 8-10 4h-10l-7-3-4-5-2-5v-9l6-12 8-7z" fill="#00B3F8" fill-opacity="0.15" />
                <path transform="translate(1338,1210)" d="m0 0h9l9 3 2 5-3 6-9 6-4 1h-10l-1-2 5-17z" fill="#00B3F8" fill-opacity="0.15" />
                <path transform="translate(185,600)" d="m0 0h1v19l-3-4-5-8v-3l7-2z" fill="#FEFEFE" fill-opacity="0.15" />
                <path transform="translate(171,592)" d="m0 0h9v4l-9 1-1-4z" fill="#FEFEFE" fill-opacity="0.15" />
                <path transform="translate(197,585)" d="m0 0 5 1-1 2h-5z" fill="#FEFEFE" fill-opacity="0.15" />
            </svg>
            <svg version="1.1" viewBox="0 0 2000 2000" width="180" height="180" xmlns="http://www.w3.org/2000/svg" class="svg3">
                <path transform="translate(188,592)" d="m0 0 13 1h1595l16 1 1 1v810l-1 1h-1624l-2-2-1-785-7-12v-3l7-2 2-9zm1380 217-3 8-5 19-16 64-8 38-17 66-7 29v6h92l3-6 16-66 9-42 16-64 11-45v-5l-60-2zm-961 11-19 4-15 6-16 9-11 9-15 16-9 11-8 9-8 16-6 18-3 20v22l4 19 7 16 7 9 5 5 9 7 17 7 18 6 10 5 10 8 4 7v8l-6 9-10 7-11 4h-12l-11-4-16-10-15-14-6-7-3 1-16 27-12 19-11 19-6 12v3l19 11 21 10 21 7 21 4 10 1h16l17-2 18-5 16-8 11-8 16-15 8-10 11-18 9-19 9-27 3-16v-15l-3-17-5-13-6-10-7-8-10-6-17-5-20-4-9-4-8-7-3-9v-7l4-10 1-3 4-2 10-4h12l16 5 17 9 9 7 3-1 12-23 10-19 9-15 6-11-2-5-6-7-14-9-11-5-15-5-22-4-8-1zm216 3-20 4-12 5-16 10-14 11-8 7-7 8-12 13-7 11-5 10-6 18-3 19v25l3 16 7 16 6 9 5 6 11 8 15 6 15 4 14 7 9 7h2l2 4 2 6v7l-6 8-9 8-7 3-5 1h-9l-13-4-14-8-10-8-11-11-3-4-4 2-8 17-15 24-16 27-5 8v2l16 9 19 10 16 7 20 5 22 3h16l20-3 18-6 13-7 11-8 17-14 13-18 11-25 7-19 5-18 1-5v-26l-3-15-8-16-8-10-8-7-10-4-30-5-10-4-5-4-5-10v-10l4-10 8-6 6-2h16l15 5 15 8 10 8 3-4 17-32 10-18 8-14-1-6-9-9-13-8-14-6-17-5-20-3zm-425 1-3 2-10 56-7 40-9 60-9 51-10 56-10 54v5l21 1 67 1 3-9 7-37 12-67 6-35 6-43 11-61 13-71v-3zm562 7-1 1-4 32-10 50-14 66-5 32-3 24-1 19v16l1 19 5 22 5 12 8 11 7 8 14 10 9 4 13 3 7 1h30l21-3 36-9 16-6 15-9 9-8 6-5 9-15 8-13 11-23 6-18 6-27 27-142 9-46v-5l-25-1h-63l-14 67-13 64-15 72-5 16-5 9-8 7-12 5h-10l-8-4-8-9-2-4v-10l10-58 14-71 6-36 6-34 2-10v-4zm272 2-2 6-12 57-7 39-6 36-13 65-18 89-7 35 1 1 77 1h100l10-48 5-25v-8l-2-1h-82l5-27 3-16h64l10-1 6-28 8-41 1-12h-73l9-37h77l2-2 14-71 1-10-14-1-72-1zm304 229-11 3-11 6-10 9-7 9-6 13-3 15 1 13 4 12 7 11 9 8 10 5 7 2 9 1 12-2 12-5 9-6 9-9 6-10 5-11 1-5v-19l-4-13-7-11-7-7-10-6-10-3zm-433 128-12 3-11 6-7 7-2 3v6l6 9 7 7 8 7 3 1 2 5v5l-9 1-7-3-8-5-5 1-13 10 1 4 6 5 11 5 8 2h14l12-5 10-9 6-12 1-3v-8l-5-5-23-10-3-2v-3l5-3h8l10 5 5-2 6-5 2-7-3-5-9-4-5-1zm48 3-5 1-10 35-9 37v2l4 1h12l3-3 6-19 3-10 24 1-1 8-6 22v2l21 1 3-4 11-39 7-30v-5h-18l-4 10-6 17-8 1h-14l1-9 3-12v-7zm110 0-12 4-14 9-10 9-5 9-4 11v17l5 10 7 6 9 4 4 1h11l12-3 13-7 9-8 6-9 5-14 1-3v-16l-5-10-7-7-9-3zm61 3-3 5-12 36-10 32v2l21 1 2-1 7-23 1-2 20-1 12-2 8-6 5-8 3-9v-11l-4-6-5-4-5-2-6-1z" fill="#00B3F8" fill-opacity="0.15" />
                <path transform="translate(1258,1210)" d="m0 0h12l7 3 4 5 1 2v11l-6 12-9 8-10 4h-10l-7-3-4-5-2-5v-9l6-12 8-7z" fill="#00B3F8" fill-opacity="0.15" />
                <path transform="translate(1338,1210)" d="m0 0h9l9 3 2 5-3 6-9 6-4 1h-10l-1-2 5-17z" fill="#00B3F8" fill-opacity="0.15" />
                <path transform="translate(185,600)" d="m0 0h1v19l-3-4-5-8v-3l7-2z" fill="#FEFEFE" fill-opacity="0.15" />
                <path transform="translate(171,592)" d="m0 0h9v4l-9 1-1-4z" fill="#FEFEFE" fill-opacity="0.15" />
                <path transform="translate(197,585)" d="m0 0 5 1-1 2h-5z" fill="#FEFEFE" fill-opacity="0.15" />
            </svg>
        </div>


        <div class="login-form-container">
            <div class="login-form">
                <!-- <img src="<?= base_url() ?>assets/dist/img/logo-jastip.png" alt="" style="width: 18%;"> -->
                <div class="mb-5">
                    <p class="lead">Login to Web Prediksi : Naive Bayes</p>
                </div>
                <form id="loginForm">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </span>
                            </div>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Email / username">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                            </div>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group remember-me-container">
                        <button type="submit" class="btn btn-default" id="btnLogin">
                            <span id="btnLoader" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                            Login
                        </button>
                    </div>
                </form>
                <!-- <a href="https://wa.link/62fh0h" class="lupa-password">Lupa password? Hubungi ADMIN</a> -->
            </div>
        </div>
    </div>
</body>


<script src="<?= base_url() ?>public/assets/plugins/jquery/jquery.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url() ?>public/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url() ?>public/assets/plugins/toastr/toastr.min.js"></script>
<!-- <script src="<?= base_url() ?>public/css/login.js"></script> -->
<script src="<?= base_url() ?>public/assets/js/login.js"></script>

</html>