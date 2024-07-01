<?php

use function PHPSTORM_META\type;
?>
<!DOCTYPE html>
<html lang="en" translate="no">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jquery 3.6.4 -->
    <script src="<?= base_url("assets/plugin/jquery@3.6.4/jquery-3.6.4.min.js"); ?>"></script>
    <!-- jquery ui -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
    <!-- popper -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <!-- bootstrap 4.6.2 -->
    <link rel="stylesheet" href="<?= base_url("assets/plugin/bootstrap@4.6.2/css/bootstrap.min.css"); ?>">
    <script src="<?= base_url("assets/plugin/bootstrap@4.6.2/js/bootstrap.min.js"); ?>"></script>
    <!-- fontawesome 6.4.0 -->
    <link rel="stylesheet" href="<?= base_url("assets/plugin/fontawesome@6.4.0/css/all.min.css"); ?>">
    <!-- custom -->
    <link rel="stylesheet" href="<?= base_url("assets/css/style.css") ?>" type="text/css">
    <script src="<?= base_url('assets/js/admin/theme.js') ?>"></script>
    <!-- icon-->
    <link rel="shortcut icon" href=" <?= base_url() ?>" type="image/x-icon">
    <title>RUSA - <?= $judul ?></title>
</head>

<body>
    <header class="sticky-top">
        <nav class="navbar <?= $color ?> theme navbar-expand-md d-flex justify-content-between n-img" <?= $header ?>>
            <div class="container">
                <div class="w-50">
                    <a href="<?= base_url() ?>" class="navbar-brand d-flex" style="width:fit-content">
                        <img src="<?= base_url("assets/img/logorusa1.gif") ?>" width="50" height="50" alt="" class="rounded-circle bg-white p-1" alt="">
                        <p class="font-weight-bolder my-auto ml-2" style="font-size:20px;">RUSA</p>
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar3">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse w-100" id="collapsingNavbar3">
                    <ul class="navbar-nav w-100 justify-content-center">
                        <li class="nav-item text-center <?= $this->uri->segment(1) == "" ? "$aktif" : "" ?>">
                            <a class="nav-link" href="<?= base_url() ?>"><i class="fas fa-home mr-2 mr-md-0"></i> Home</a>
                        </li>
                        <li class="nav-item text-center <?= $this->uri->segment(1) == "tentang" ? "$aktif" : "" ?>">
                            <a class="nav-link" href="<?= site_url('tentang') ?>"><i class="fas fa-circle-info mr-2 mr-md-0"></i> Tentang</a>
                        </li>
                        <li class="nav-item text-center <?= $this->uri->segment(2) == "artikel" ? "$aktif" : "" ?>">
                            <a class="nav-link" href="<?= site_url('home/artikel') ?>"><i class="fas fa-newspaper mr-2 mr-md-0"></i> Artikel</a>
                        </li>
                        <li class="nav-item text-center <?= $this->uri->segment(1) == "kontak" ? "$aktif" : "" ?>">
                            <a class="nav-link" href="<?= site_url('kontak') ?>"><i class="fas fa-address-book mr-2 mr-md-0"></i> Kontak</a>
                        </li>
                        <?php if (isset($_SESSION['tipeAkun'])) : ?>
                            <li class="nav-item text-center">
                                <?php if ($_SESSION['tipeAkun'] == "User") : ?>
                                    <a class="nav-link" href="<?= site_url('/cms/account/' . $_SESSION['tipeAkun']) ?>"><i class="fas fa-person mr-2 mr-md-0"></i>Profil</a>
                                <?php endif; ?>
                                <?php if ($_SESSION['tipeAkun'] == "Admin") : ?>
                                    <a class="nav-link" href="<?= site_url('/cms/account/' . $_SESSION['tipeAkun']) ?>"><i class="fas fa-person mr-2 mr-md-0"></i>Profil</a>
                                <?php endif; ?>
                                <?php if ($_SESSION['tipeAkun'] == "Super Admin") : ?>
                                    <a class="nav-link" href="<?= site_url('/cms/account/' . $_SESSION['tipeAkun']) ?>"><i class="fas fa-person mr-2 mr-md-0"></i>Profil</a>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>

                    </ul>
                    <ul class="nav navbar-nav ml-auto w-100 justify-content-end">
                        <li class="nav-item text-center">
                            <?php if (isset($_SESSION['tipeAkun'])) : ?>
                                <?php if ($_SESSION['tipeAkun'] == "User" || $_SESSION['tipeAkun'] == "Admin" || $_SESSION['tipeAkun'] == "Super Admin") : ?>
                                    <a class="nav-link" href="<?= site_url('auth/logout') ?>"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if (!isset($_SESSION['tipeAkun'])) : ?>
                                <a class="nav-link" href="<?= site_url('login') ?>"><i class="fas fa-sign-in-alt mr-2"></i>Login</a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>