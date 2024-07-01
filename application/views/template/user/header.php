<!DOCTYPE html>
<html lang="en">

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
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <!-- bootstrap 4.6.2 -->
    <link rel="stylesheet" href="<?= base_url("assets/plugin/bootstrap@4.6.2/css/bootstrap.min.css"); ?>">
    <script src="<?= base_url("assets/plugin/bootstrap@4.6.2/js/bootstrap.min.js"); ?>"></script>
    <!-- ionicon -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- summernote 0.8.20 -->
    <link rel="stylesheet" href="<?= base_url("assets/plugin/summernote@0.8.20/dist/summernote-bs4.min.css"); ?>">
    <script src="<?= base_url("assets/plugin/summernote@0.8.20/dist/summernote-bs4.min.js"); ?>"></script>
    <!-- fontawesome 6.4.0 -->
    <link rel="stylesheet" href="<?= base_url("assets/plugin/fontawesome@6.4.0/css/all.min.css"); ?>">
    <!-- bs-custom-file-input 1.3.2 -->
    <script src="<?= base_url('assets/plugin/bs-custom-file-input@1.3.2/bs-custom-file-input.min.js') ?>"></script>
    <!-- chart.js 4.2.1 -->
    <script src="<?= base_url('assets/plugin/chart.js@4.2.1/chart.umd.js') ?>"></script>
    <!-- custom -->
    <link rel="stylesheet" href="<?= base_url("assets/css/admin/style.css") ?>" type="text/css">
    <script src="<?= base_url('assets/js/admin/sidebar.js') ?>"></script>
    <script src="<?= base_url('assets/js/cekyt.js') ?>"></script>
    <!-- icon-->
    <link rel="shortcut icon" href=" <?= base_url() ?>" type="image/x-icon">
    <title>RUSA - Bermain Sambil Belajar</title>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <aside id="sidebar">
            <div class="sidebar-header d-flex align-items-center">
                <?php
                $char =  $username;
                $first = strtoupper(mb_substr(strval($char), 0, 1));
                ?>
                <img src="https://placehold.co/500x500?text=<?= $first ?>" width="50" height="50" alt="" class="rounded-circle">
                <h5 class="ml-3 pt-2"><?= $username ?></h5>
            </div>
            <ul class="list-unstyled components px-2">
                <?php if ($tipeAkun == "User") : ?>
                    <li class="<?= $this->uri->segment(4) == "dashboard" || $this->uri->segment(4) == "" ? "$aktif" : "" ?>">
                        <a href="<?= site_url('cms/account/' . $char) ?>/<?= 'dashboard' ?>" class="">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                    </li>
                <?php endif ?>
                <?php if ($tipeAkun == "Admin") : ?>
                    <li class="<?= $this->uri->segment(4) == "artikel" || $this->uri->segment(4) == "" ? "$aktif" : "" ?>">
                        <a href="<?= site_url('cms/account/' . $char) ?>/<?= 'artikel' ?>">
                            <i class="fas fa-newspaper"></i>
                            Artikel
                        </a>
                    </li>
                <?php endif ?>
                <?php if ($tipeAkun == "User") : ?>
                    <li class="<?= $this->uri->segment(4) == "artikel" ? "$aktif" : "" ?>">
                        <a href="<?= site_url('cms/account/' . $char) ?>/<?= 'artikel' ?>">
                            <i class="fas fa-newspaper"></i>
                            Artikel
                        </a>
                    </li>
                <?php endif ?>

                <?php if ($tipeAkun == "Admin") : ?>
                    <li class="<?= $this->uri->segment(4) == "daftarAkun" ? "$aktif" : "" ?>">
                        <a href="<?= site_url('cms/account/' . $char) ?>/<?= 'daftarAkun' ?>" role="button">
                            <i class="fas fa-user"></i>
                            Akun
                        </a>
                    </li>
                <?php endif ?>
                <?php if ($tipeAkun == "Super Admin") : ?>
                    <li class="<?= $this->uri->segment(2) == "" ? "$aktif" : "" ?>">
                        <a href="<?= site_url('admin') ?>" role="button">
                            <i class="fas fa-palette"></i>
                            Tema
                        </a>
                    </li>
                <?php endif ?>
                <li>
                    <a data-toggle="modal" data-target="#logout" role="button">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                    <div class="modal fade" id="logout" tabindex="-1" aria-labelledby="logoutLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-dark" id="logoutLabel">Konfirmasi Logout</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= site_url('auth/logout') ?>" method="post">
                                    <div class="modal-body text-dark">
                                        Apakah Anda ingin Logout?
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-danger  w-25" data-dismiss="modal">Tidak</button>
                                        <button type="submit" class="btn btn-success w-25">Ya</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </aside>
        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light fixed-top">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-hum">
                        <i class="fas fa-align-justify"></i>
                    </button>
                    <div class="m-auto">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item" style="color: lightslategray;">
                                RUSA - Bermain Sambil Belajar
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>