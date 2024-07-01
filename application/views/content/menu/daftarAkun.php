        <!-- CONTENT -->
        <main>
            <h2>Daftar Akun</h2>
            <form class="form-inline pt-1" action="<?= site_url('cms/account/' . $username . '/daftarAkun') ?>" method="post">
                <div class="d-flex flex-column w-100" style="gap:1em;">
                    <div>
                        <input class="form-control mr-2 mb-0" type="text" name="cari" id="cari" value="<?= $cari ?>" placeholder="Cari username">
                        <script>
                            $("#cari").autocomplete({
                                source: function(request, response) {
                                    $.ajax({
                                        url: '<?= site_url("cms/autoComplete/akun") ?>',
                                        type: 'GET',
                                        dataType: "json",
                                        data: {
                                            query: request.term
                                        },
                                        success: function(data) {
                                            response(data);
                                        },
                                        error: function(message) {
                                            response([{
                                                'label': 'Not found!'
                                            }]);
                                        }
                                    });
                                },
                                minLength: 2
                            });
                        </script>
                        <select class="form-control mr-2 mb-0" name="filter">
                            <option value="<?php $filter == "" ? print "" : print "" ?>" <?php $filter == "" ? print "selected" : '' ?>>Semua</option>
                            <option value="<?php $filter == "User" ? print "User" : print "User" ?>" <?php $filter == "User" ? print "selected" : '' ?>>User</option>
                            <option value="<?php $filter == "Admin" ? print "Admin" : print "Admin" ?>" <?php $filter == "Admin" ? print "selected" : '' ?>>Admin</option>
                        </select>
                        <button type="submit" name="submit" class="btn btn-outline-primary mb-0">
                            <i class="fas fa-search mr-2"></i>Cari
                        </button>
                    </div>
                    <div class="d-flex mb-0" style="gap:1em;">
                        <a class="btn btn-success" data-toggle="modal" data-target="#tambahakun">
                            <i class="fa-solid fa-user-plus mr-2"></i>Tambah Akun
                        </a>
                    </div>
                </div>
            </form>

            <div class="modal fade" id="tambahakun" tabindex="-1" aria-labelledby="tambahakunLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-dark font-weight-normal" id="tambahakunLabel"> <i class="fa-regular fa-square-plus mr-2"></i>Tambah</h5>
                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?php echo site_url('cms/account/' . $username . '/save/akun') ?>" method="post">
                            <div class="modal-body text-dark">
                                <div class="form-group">
                                    <label class="text-left w-100 font-weight-bolder">Profil</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text wdth-8" id="basic-addon1">Username</span>
                                        </div>
                                        <input type="text" class="form-control" id="username" placeholder="masukkan username..." name="username" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text wdth-8" id="basic-addon1">Tgl Lahir</span>
                                        </div>
                                        <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" placeholder="masukkan tanggal lahir..." onfocus="(this.type='date')" onblur="(this.type='text')">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text wdth-8" id="basic-addon1">No. Hp</span>
                                        </div>
                                        <input type="text" class="form-control" name="no_hp" placeholder="masukkan nomor..." oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                                    </div>
                                    <label class="text-left w-100 font-weight-bolder">Akun</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text wdth-8" id="basic-addon1">Email</span>
                                        </div>
                                        <input type="email" class="form-control" name="email" placeholder="masukkan email..." required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text wdth-8" id="basic-addon1">Password</span>
                                        </div>
                                        <input type="password" class="form-control" name="password" placeholder="masukkan password" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text wdth-8" id="basic-addon1">Tipe Akun</span>
                                        </div>
                                        <select class="form-control" name="tipe_akun" placeholder="Tipe Akun" required>
                                            <option value="User" selected>User</option>
                                            <option value="Admin">Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-success w-25">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <table class="table table-hover table-striped table-responsive-lg table-bordered text-center mt-3">
                <thead class="thead-dark ">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Username</th>
                        <th scope="col">Password</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($akun)) : ?>
                        <tr>
                            <td colspan="6">
                                <div class="alert alert-danger text-center" role="alert">
                                    Akun tidak ditemukan
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php
                    foreach ($akun as $row) :
                    ?>
                        <tr class="font-weight-normal">
                            <th scope="row" class="align-middle"><?= ++$start; ?></th>
                            <td class="align-middle"><?= $row["Nama"]; ?></td>
                            <td class="align-middle hidetext"><?= $row["Password"]; ?></td>
                            <td class="align-middle"><?= $row["Email"]; ?></td>
                            <td class="align-middle"><?= $row["RoleId"]; ?></td>
                            <td class="">
                                <!-- sunting button -->
                                <a class="btn btn-warning mr-1" style="font-size: 13px;" data-toggle="modal" data-target="#suntingakun<?= $row["PersonKey"] ?>">
                                    Sunting
                                </a>
                                <div class="modal fade" id="suntingakun<?= $row["PersonKey"] ?>" tabindex="-1" aria-labelledby="suntingakunLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-dark font-weight-normal" id="suntingakunLabel"><i class="fa-regular fa-pen-to-square mr-2"></i>Sunting Akun</h5>
                                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="<?php echo site_url("cms/account/$username/update/akun/" . $row["PersonKey"]) ?>" method="post">
                                                <div class="modal-body text-dark">
                                                    <div class="form-group">
                                                        <label class="text-left w-100 font-weight-bolder">Profil</label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text wdth-8" id="basic-addon1">Username</span>
                                                            </div>
                                                            <input type="text" class="form-control" id="username" placeholder="masukkan username..." name="username" value="<?= $row["Nama"]; ?>" required>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text wdth-8" id="basic-addon1">Tgl Lahir</span>
                                                            </div>
                                                            <input type="text" class="form-control" name="tgl_lahir" placeholder="masukkan tanggal lahir..." value="<?= $row["DateofBirth"]; ?>" onfocus="(this.type='date')" onblur="(this.type='text')">
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text wdth-8" id="basic-addon1">No. Hp</span>
                                                            </div>
                                                            <input type="text" class="form-control" name="no_hp" placeholder="masukkan nomor..." value="<?= $row["NoHp"]; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                                                        </div>
                                                        <label class="text-left w-100 font-weight-bolder">Akun</label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text wdth-8" id="basic-addon1">Email</span>
                                                            </div>
                                                            <input type="email" class="form-control" name="email" placeholder="masukkan email..." value="<?= $row["Email"]; ?>" required>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text wdth-8" id="basic-addon1">Password</span>
                                                            </div>
                                                            <input type="password" class="form-control" name="password" placeholder="masukkan password" value="<?= $row["Password"]; ?>" required>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text wdth-8" id="basic-addon1">Tipe Akun</span>
                                                            </div>
                                                            <select class="form-control" name="tipe_akun" placeholder="Tipe Akun" required>
                                                                <option value="<?= $row["RoleId"] ?>" selected hidden><?= $row["RoleId"] ?></option>
                                                                <option value="User">User</option>
                                                                <option value="Admin">Admin</option>
                                                                <option value="Super Admin">Super Admin</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="submit" class="btn btn-warning w-25">Sunting</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- delete button -->
                                <a class="btn btn-danger" style="font-size: 13px;" data-toggle="modal" data-target="#hapus<?= $row["PersonKey"] ?>">
                                    Hapus
                                </a>
                                <div class="modal fade" id="hapus<?= $row["PersonKey"] ?>" tabindex="-1" aria-labelledby="hapusLabel" aria-hidden="true">
                                    <div class="modal-dialog ">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-dark font-weight-normal" id="hapusLabel"><i class="fa-regular fa-trash-can mr-2"></i>Hapus Akun</h5>
                                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="<?= site_url('cms/account/' . $username . '/delete/akun/' . $row["PersonKey"]) ?>" method="post">
                                                <div class="modal-body text-dark d-flex flex-column">
                                                    <span class="pt-2 pb-4"><i class="fa-regular fa-circle-xmark" style="font-size: 10em; color:#DC3545;"></i></span>
                                                    <span>Apakah anda yakin menghapus <strong><?= $row["Nama"]; ?></strong> ? </span>
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="button" class="btn btn-danger  w-25" data-dismiss="modal">Tidak</button>
                                                    <input type="hidden" id="id_akun" name="id_akun" value="<?= $row["PersonKey"]; ?>">
                                                    <button type="submit" class="btn btn-outline-success w-25">Ya</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- PAGINATION -->
            <?= $this->pagination->create_links();; ?>
            <?php if ($this->session->flashdata('toast')) : ?>
                <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 1em; bottom: 0;">
                    <div id="liveToast" class="toast hide <?= $this->session->flashdata('bg-color'); ?>" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
                        <div class="toast-body text-light">
                            <i class="fas fa-check mr-2"></i>
                            <?= $this->session->flashdata('toast'); ?>
                        </div>
                    </div>
                    <script>
                        $('.toast').toast('show');
                    </script>
                <?php endif; ?>
        </main>
        </div>