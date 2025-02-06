<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php $title = isset($title) ? $title : 'SIPEMA | Sistem Informasi Prodi D3 TI Madiun'; ?>
    <title><?= $title ?></title>
    <link rel="icon" href="<?= base_url('../sipema_assets/img/logo.ico') ?>">
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="<?= base_url('../assets/css/simplebar.css') ?>">
    <!-- Fonts CSS -->
    <link
        href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="<?= base_url('../assets/css/feather.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('../assets/css/select2.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('../assets/css/dropzone.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('../assets/css/uppy.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('../assets/css/jquery.steps.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('../assets/css/jquery.timepicker.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('../assets/css/quill.snow.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('../assets/css/dataTables.bootstrap4.css') ?>" />
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="<?= base_url('../assets/css/daterangepicker.css') ?>" />
    <!-- App CSS -->
    <link rel="stylesheet" href="<?= base_url('../assets/css/app-light.css') ?>" id="lightTheme" />
    <link rel="stylesheet" href="<?= base_url('../assets/css/app-dark.css') ?>" id="darkTheme" disabled />
    <!-- SweetAlert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css" />
    <style>
    .loading-overlay {
                                    position: fixed;
                                    top: 0;
                                    left: 0;
                                    width: 100%;
                                    height: 100%;
                                    background-color: rgba(0, 0, 0, 0.5); /* Ubah nilai alpha (0.5) sesuai kebutuhan */
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    z-index: 9999;
                                    opacity: 0;
                                    visibility: hidden;
                                    transition: opacity 0.3s ease, visibility 0.3s ease;
                                }

                                .loading-overlay.active {
                                    opacity: 1;
                                    visibility: visible;
                                }

                                .loading-box {
                                background-color: #fff;
                                padding: 20px;
                                border-radius: 5px;
                                text-align: center;
                                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                            }

                            .loading-spinner {
                                width: 40px;
                                height: 40px;
                                margin-bottom: 10px;
                                border: 4px solid #f3f3f3;
                                border-top: 4px solid #3498db;
                                border-radius: 50%;
                                animation: spin 2s linear infinite;
                            }

                                @keyframes spin {
                                    0% { transform: rotate(0deg); }
                                    100% { transform: rotate(360deg); }
                                }
    </style>
</head>

<body class="vertical  light  ">
    <div class="wrapper">
        