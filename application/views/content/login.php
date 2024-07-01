        <!-- LAYOUT KANAN -->
        <div class="col-lg-5 bg-light col-md-12 media">
            <div class="container align-self-center px-5 mx-auto">
                <!-- <h1 class="text-center mb-5">Login Here</h1> -->
                <div class="mx-auto pb-4">
                    <a href="<?= base_url() ?>" class="navbar-brand d-flex mx-auto text-dark" style="width:fit-content;">
                        <img src="<?= base_url("assets/img/logorusa1.gif") ?>" width="70" height="70" alt="" class="rounded-circle bg-light p-1" alt="">
                        <p class="font-weight-bolder my-auto ml-2" style="font-size:30px;">Rumah Asa Indonesia</p>
                    </a>
                </div>
                <?= $this->session->flashdata('invalid') ?>
                <?php
                if (isset($idArtikel)) :
                ?>
                    <form action="<?= base_url('index.php/auth/valLogin/' . $idArtikel) ?>" method="post">
                    <?php
                else :
                    ?>
                        <form action="<?= base_url('index.php/auth/valLogin') ?>" method="post">
                        <?php
                    endif;
                        ?>
                        <div class="form-outline mb-3">
                            <input type="email" class="form-control" name="email" placeholder="Email" autofocus role="presentation" autoComplete="off" required />
                        </div>
                        <div class="form-outline mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password" autoComplete="new-password" required />
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mb-3">Masuk</button>
                        </form>
                        <p class="text-center">Belum punya akun? <a href="<?= site_url('home/signup') ?>">Daftar</a></p>
            </div>
        </div>
        </div>
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
            </body>

            </html>