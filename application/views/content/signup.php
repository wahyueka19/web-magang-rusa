        <!-- LAYOUT KANAN -->
        <div class="col-lg-5 bg-light col-md-12 media">
            <div class="container align-self-center px-5 mx-auto">
                <h1 class="text-center pb-3">Buat Akun</h1>
                <?= $this->session->flashdata('invalid') ?>
                <form action="<?= site_url("auth/signup") ?>" method="post">
                    <div class="col">
                        <div class="form-group">
                            <label for="profil">Profil</label>
                            <input type="text" class="form-control" id="profil" name="username" placeholder="Username" value="<?= set_value('username') ?>" autofocus>
                            <?= form_error('username', '<small class="text-danger">', '</small>') ?>
                            <input type="text" class="form-control mt-3" id="profil" name="tgl_lahir" placeholder="Tanggal Lahir" onfocus="(this.type='date')" onblur="(this.type='text')">
                            <input type="text" class="form-control mt-3" id="profil" name="no_hp" placeholder="No. Handphone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                        </div>
                        <div class="form-group">
                            <label for="akun">Akun</label>
                            <input type="email" class="form-control mt-3" id="akun" name="email" placeholder="Email" value="<?= set_value('email') ?>" role="presentation" autoComplete="off">
                            <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                            <input type="password" class="form-control mt-3" id="akun" name="password" placeholder="Password" value="<?= set_value('password') ?>" autoComplete="new-password">
                            <?= form_error('password', '<small class="text-danger">', '</small>') ?>
                            <input type="password" class="form-control mt-3" id="akun" name="confpassword" placeholder="Konfirmasi Password" value="<?= set_value('confpassword') ?>">
                            <?= form_error('confpassword', '<small class="text-danger">', '</small>') ?>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block mb-3">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
        </main>
        </body>

        </html>