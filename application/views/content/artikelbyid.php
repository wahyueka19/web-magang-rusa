    <main class="bg-light full_height align-items-center">
        <!-- d-flex flex-column-reverse flex-lg-row -->
        <section class="fixer">
            <?php
            if ($count > 4) :
            ?>
                <div class="container d-flex flex-column-reverse flex-lg-row" style="gap:0.5em;">
                    <!-- LAYOUT KIRI -->
                    <section class="card col-12 col-lg-4 mb-3 mx-lg-0 border h-fit-content my-lg-3 mt-3 mt-lg-0">
                        <div class="container mt-4">
                            <form class="d-flex" action="<?= site_url('home/artikel') ?>" method="post">
                                <input class="form-control mr-2" type="text" name="cari" id="cari" value="<?= isset($_SESSION['cari']) ? $_SESSION['cari'] : "" ?>" placeholder="Cari artikel">
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
                                                <h6><a class="card-title dark" href="<?= site_url('home/detailartikel/') . $row['id_artikel']; ?>"><?= $row['judul']; ?></a></h6>
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
            else :
                ?>
                    <div class="container d-flex flex-column-reverse align-items-center" style="gap:0.5em;">
                    <?php
                endif;
                    ?>
                    <!-- LAYOUT KANAN -->
                    <?php
                    foreach ($artikel as $row) :
                    ?>
                        <section class="d-flex flex-column mt-3 col-12 col-lg-8 w-100" style="gap:0.5em;">
                            <!-- ARTIKEL -->
                            <?php if (empty($artikel)) : ?>
                                <div class="mt-3 mb-n3 container">
                                    <div class="alert card alert-danger text-center" role="alert">
                                        Artikel tidak ditemukan
                                    </div>
                                </div>
                            <?php endif; ?>
                            <span class="d-flex flex-column mt-lg-0 h-fit-content">
                                <!-- ARTIKEL -->
                                <article class="card mb-3 px-2">
                                    <img class="card-img-top mt-1 img-fluid img-artikel" src="<?= base_url("images/") . $row['id_artikel'] . "/" . $row['isi_gambar'] ?>" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $row['judul']; ?></h5>
                                        <p class="card-text mt-n2"><small class="text-muted"><?= date('d M Y h:i', strtotime($row['tgl_post'])); ?> oleh <?= $row['Nama']; ?></small></p>
                                        <div class="card-text">
                                            <?php
                                            $dta = $row['isi_artikel'];
                                            $tmp = preg_match_all('/<img([\w\W]+?)>/', $dta, $matches);
                                            $i = 0;

                                            if ($tmp > $i && $tmp <= 1) {
                                                foreach ($matches[$tmp] as $d) {
                                                    $prehtml = "<img" . $d;
                                                    $posthtml = "<img id='imgartikel'" . $d;
                                                    $fixer = str_replace($prehtml, $posthtml, $dta);
                                                };
                                                echo $fixer;
                                            } else if ($tmp > $i) {
                                                foreach ($matches as $d) {
                                                    while ($i < $tmp) {
                                                        $prehtml = "<img" . $d[$i];
                                                        $posthtml  = "<img id='imgartikel'" . $d[$i];
                                                        $fixer  = str_replace($prehtml, $posthtml, $dta);
                                                        $i++;
                                                    };
                                                };
                                                echo $fixer;
                                            } else {
                                                echo $dta;
                                            }
                                            ?>
                                            <script>
                                                $path = document.getElementById('imgartikel');
                                                $path.removeAttribute('style')
                                                $path.removeAttribute('class')
                                                $path.setAttribute('class', 'img-fluid w-75 h-75 d-block mx-auto')
                                            </script>
                                        </div>
                                        <?php if (!empty($row['link_video'])) : ?>
                                            <div class="container px-5 pt-2 pb-4">
                                                <div class="embed-responsive embed-responsive-21by9">
                                                    <iframe id="cekyt" class="embed-responsive-item" src="//www.youtube.com/embed/<?= $row['link_video'] ?>" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            </span>
                            <!-- KOMEN -->
                            <section class="card px-4 pt-3 pb-2 h-fit-content mb-lg-3">
                                <?php if (isset($_SESSION) && !isset($_SESSION['tipeAkun'])) : ?>
                                    <div>
                                        <h5>Kolom Komentar</h5>
                                        <hr>
                                    </div>
                                    <div class="form-group px-lg-5 mx-2">
                                        <label for="komentar">Tulis Komentar</label>
                                        <textarea class="form-control" id="komentar" name="komentar" rows="3"></textarea>
                                        <button class="btn btn-primary my-2 float-right" data-toggle="modal" data-target="#login">Kirim</button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="login" tabindex="-1" aria-labelledby="loginLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="loginLabel">Peringatan Login</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="<?= site_url('home/login/') . $row['id_artikel'] ?>">
                                                        <div class="modal-body">
                                                            Login terlebih dahulu sebelum komentar
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Nanti</button>
                                                            <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt mr-2"></i>Login sekarang</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($_SESSION['tipeAkun'])) : ?>
                                    <?php if ($_SESSION['tipeAkun'] == 'User' || $_SESSION['tipeAkun'] == 'Admin' || $_SESSION['tipeAkun'] == 'Super Admin') : ?>
                                        <form action="<?= site_url('home/komen/') . $row['id_artikel'] ?>" method="post" class="mb-3">
                                            <div>
                                                <h5>Kolom Komentar</h5>
                                                <hr>
                                            </div>
                                            <div class="form-group px-lg-5 mx-2">
                                                <label for="komentar">Tulis Komentar</label>
                                                <textarea class="form-control" id="komentar" name="komentar" rows="3" required></textarea>
                                                <button class="btn btn-primary my-2 float-right" type="submit">Kirim</button>
                                            </div>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php foreach ($komen as $k) : ?>
                                    <div class="container">
                                        <div class="container mb-4 px-lg-5 px-2 m-0">
                                            <div class="row flex px-lg-2">
                                                <?php
                                                $char =  $k['Nama'];
                                                $first = strtoupper(mb_substr(strval($char), 0, 1));
                                                ?>
                                                <img class="rounded-circle img-profile" src="https://placehold.co/500x500?text=<?= $first ?>" alt="">
                                                <div class="col">
                                                    <h6><?= $k['Nama'] ?></h6>
                                                    <p class="card-text mt-n2"><small class="text-muted"><?= date('d M Y h:i', strtotime($k['tgl_komen'])); ?></small></p>
                                                </div>
                                                <?php if (isset($_SESSION['tipeAkun'])) : ?>
                                                    <?php if ($_SESSION['username'] == $k['Nama'] || $_SESSION['tipeAkun'] == 'Admin' || $_SESSION['tipeAkun'] == 'Super Admin') : ?>
                                                        <div class="flex-end">
                                                            <a href="<?= site_url('home/deleteKomen/') . $k['id_post'] . "/" . $k['id_komen'] ?>" class="btn btn-danger btn-small"><i class="fas fa-trash"></i></a>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="row ml-4">
                                                <div class="col ml-2 ml-lg-3 mt-2">
                                                    <p class="card-text text-justify"><?= $k['isi_komen'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <hr>
                            </section>
                        <?php endforeach; ?>
                    </div>
        </section>
    </main>