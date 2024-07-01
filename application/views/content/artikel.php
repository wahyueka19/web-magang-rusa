    <main class="bg-light full_height align-items-center">
        <!-- d-flex flex-column-reverse flex-lg-row -->
        <section class="fixer">
            <div class="container d-flex flex-column-reverse flex-lg-row" style="gap:0.5em;">
                <?php
                if ($count > 4) :
                ?>
                    <!-- LAYOUT KIRI -->
                    <section class="card col-12 col-lg-4 mb-3 mx-lg-0 mt-n1 mt-lg-0 border h-fit-content my-lg-3">
                        <div class="container mt-4">
                            <form class="d-flex" action="<?= site_url('home/artikel') ?>" method="post">
                                <input class="form-control mr-2" type="text" name="cari" id="cari" value="<?= $cari ?>" placeholder="Cari artikel">
                                <script>
                                    $("#cari").autocomplete({
                                        source: function(request, response) {
                                            $.ajax({
                                                url: '<?= site_url("home/autoArtikel") ?>',
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
                                <button type="submit" name="submit" class="btn btn-outline-primary">Cari</button>
                            </form>
                        </div>
                        <hr>
                        <h6 class="container mt-1">Lihat Artikel Lainnya</h6>
                        <div class="container">
                            <article>
                                <ul class="list-unstyled">
                                    <?php
                                    foreach ($suggest as $row) :
                                    ?>
                                        <li class="media my-3">
                                            <img class="mr-3 prev-img-suggest border" src="<?= base_url("images/") . $row['id_artikel'] . "/" . $row['isi_gambar'] ?>" alt="Generic placeholder image">
                                            <div class="media-body">
                                                <h6><a class="card-title dark" href="<?= site_url('home/artikelbyid/') . $row['id_artikel']; ?>"><?= $row['judul']; ?></a></h6>
                                                <span class="text-truncate-container text-break">
                                                    <p style="font-size: 12px;">
                                                        <?php
                                                        $dta = $row['isi_artikel'];
                                                        preg_match('/<p[^>]*>(.*)<\/p>/', $dta, $matches);
                                                        $par = $matches[1];
                                                        $p = strip_tags(str_replace('</p>', '', $par));
                                                        $nobr = strip_tags(str_replace('<br>', ' ', $p));


                                                        $content = preg_replace("/<img[^>]+\>/i", "", $nobr);
                                                        echo $content;
                                                        ?>
                                                    </p>
                                                </span>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </article>
                        </div>
                    </section>
                <?php
                endif;
                ?>
                <?php
                if ($count > 4) :
                ?>
                    <!-- LAYOUT KANAN -->
                    <section class="d-flex flex-column mt-3 col-lg-8 w-100" style="gap:1em;">
                    <?php
                else :
                    ?>
                        <!-- LAYOUT KANAN -->
                        <section class="d-flex flex-column mt-3 w-100" style="gap:1em;">
                        <?php
                    endif;
                        ?>
                        <?php if (empty($artikel)) : ?>
                            <div class="mt-3 mb-n3 container">
                                <div class="alert card alert-danger text-center" role="alert">
                                    Artikel tidak ditemukan
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php
                        foreach ($artikel as $row) :
                        ?>
                            <span class="d-flex flex-column mt-lg-0">
                                <div class="card px-1 col-md-12" id="<?= $row['id_artikel']; ?>">
                                    <div class="d-flex flex-column flex-md-row-reverse">
                                        <div class="col-12 col-md-4 mt-1 mr-md-n1 m-md-0 p-0">
                                            <img class="img-fluid img-artikel-prev card-img-top mh-100" src="<?= base_url("images/") . $row['id_artikel'] . "/" . $row['isi_gambar'] ?>" alt="sans" />
                                        </div>
                                        <div class="row card-body">
                                            <article class="px-3">
                                                <h6 class="card-title"><?= $row['judul']; ?></h6>
                                                <p class="card-text mt-n2" style="font-size: 14px;"><small class="text-muted"><?= date('d M Y h:i', strtotime($row['tgl_post'])); ?> oleh <?= $row['Nama']; ?></small></p>
                                                <span class="text-truncate-container text-break">
                                                    <p style="font-size: 12px;">
                                                        <?php
                                                        $dta = $row['isi_artikel'];

                                                        preg_match('/<p[^>]*>(.*)<\/p>/', $dta, $matches);
                                                        $par = $matches[1];
                                                        $p = strip_tags(str_replace('</p>', '', $par));
                                                        $nobr = strip_tags(str_replace('<br>', ' ', $p));


                                                        $content = preg_replace("/<img[^>]+\>/i", "", $nobr);
                                                        echo $content;
                                                        ?>
                                                    </p>
                                                </span>
                                                <a href="<?= site_url('home/detailartikel/') . $row['id_artikel']; ?>" class="btn btn-outline-primary fs_14 mt-1">Lihat Selengkapnya</a>
                                            </article>
                                        </div>
                                    </div>
                                </div>
                            </span>
                        <?php endforeach; ?>
                        <!-- BUTTON KONTRIBUTOR -->
                        <?php if ($count > 2) : ?>
                            <div class="d-flex flex-column-reverse flex-lg-row justify-content-between">
                            <?php endif; ?>
                            <div class="text-center mb-3 mb-md-0">
                                <?php if (isset($_SESSION['tipe_akun']) && $_SESSION['tipe_akun'] == "User") : ?>
                                    <a class="btn btn-primary" href="<?= site_url('/user/artikel') ?>">Jadilah Kontributor Artikel Kami</a>
                                <?php endif; ?>
                                <?php if (!isset($_SESSION['tipe_akun']) || $_SESSION['tipe_akun'] != "User" && $_SESSION['tipe_akun'] != "Admin" && $_SESSION['tipe_akun'] != "Super Admin") : ?>
                                    <a class="btn btn-primary" href="<?= site_url('login') ?>">Jadilah Kontributor Artikel Kami</a>
                                <?php endif; ?>
                            </div>
                            <!-- PAGINATION -->
                            <?= $this->pagination->create_links();; ?>
                            </div>
                        </section>
            </div>
        </section>
    </main>