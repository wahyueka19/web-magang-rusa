        <!-- CONTENT -->
        <main>
            <div class="d-flex mb-3 back">
                <?php if ($uri6) : ?>
                    <a class="my-auto" href="<?= site_url('cms/account/' . $username . '/artikel/' . $uri5) ?>"><i class="fas fa-circle-chevron-left fa-xl mr-2"></i></a>
                <?php else : ?>
                    <a class="my-auto" href="<?= site_url('cms/account/' . $username . '/artikel') ?>"><i class="fas fa-circle-chevron-left fa-xl mr-2"></i></a>
                <?php endif; ?>
                <h2 class="my-auto">Tinjauan Artikel</h2>
            </div>
            <div class="d-flex flex-column flex-lg-row row">
                <?php
                foreach ($artikel as $row) :
                ?>
                    <section class="d-flex flex-column col-lg-8 mb-3 mb-lg-0 max-crd">
                        <article class="card prev pt-3 ">
                            <img class="card-img-top px-3 img-fluid img-artikel" src="<?= base_url("images/") . $row['id_artikel'] . "/" . $row['isi_gambar'] ?>" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title"><?= $row['judul']; ?></h5>
                                <p class="card-text mt-n2"><small class="text-muted"><?= date('d M Y h:i', strtotime($row['tgl_post'])); ?> oleh <?= $row['Nama'] ?></small></p>
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
                                    <?php if ($tipeAkun == "User") : ?>
                                        <script>
                                            const path = document.querySelectorAll('#imgartikel');
                                            for (let i = 0; i < path.length; i++) {
                                                path[i].removeAttribute('style')
                                                path[i].removeAttribute('class')
                                                path[i].setAttribute('class', 'img-fluid w-75 h-75 d-block mx-auto')
                                            }
                                        </script>
                                    <?php endif; ?>
                                    <?php if ($tipeAkun == "Admin") : ?>
                                        <script>
                                            $path = document.getElementById('imgartikel');
                                            $path.removeAttribute('style')
                                            $path.removeAttribute('class')
                                            $path.setAttribute('class', 'img-fluid w-75 h-75 d-block mx-auto')
                                        </script>
                                    <?php endif; ?>
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
                    </section>
                    <div class="container col-12 col-lg-4 h-fit-content">
                        <section class="card py-4 mb-3 mb-lg-0 px-4 max-crd">
                            <h6>Catatan :</h6>
                            <div>
                                <?php
                                $id = $row['id_artikel'];
                                if ($tipeAkun == 'Admin') : ?>
                                    <form action="<?= site_url("cms/account/$username/statusChange/$id/Ditolak") ?>" method="post">
                                        <div class="form-group">
                                            <textarea id="catatan" name="catatan" placeholder="first placeholder">></textarea>
                                            <script>
                                                $('#catatan').summernote({
                                                    placeholder: 'Masukkan koreksi disini',
                                                    tabsize: 2,
                                                    height: 210,
                                                    toolbar: [
                                                        ['style', ['bold', 'italic', 'underline', 'clear']],
                                                        ['para', ['ul', 'ol', 'paragraph']],
                                                        ['insert', ['link', 'picture']],
                                                        ['view', ['fullscreen']],
                                                    ],
                                                    callbacks: {
                                                        onImageUpload: function(image) {
                                                            uploadImage(image[0]);
                                                        },
                                                        onMediaDelete: function(target) {
                                                            deleteImage(target[0].src);
                                                        }
                                                    },
                                                    codeviewFilter: false,
                                                    codeviewIframeFilter: true,
                                                    disableDragAndDrop: true,
                                                });

                                                function uploadImage(image) {
                                                    var data = new FormData();
                                                    data.append("image", image);
                                                    $.ajax({
                                                        url: "<?= site_url('cms/summernoteUploadImage/') . $row['id_artikel'] ?>",
                                                        cache: false,
                                                        contentType: false,
                                                        processData: false,
                                                        data: data,
                                                        type: "POST",
                                                        success: function(url) {
                                                            $('#catatan').summernote("insertImage", url);
                                                        },
                                                        error: function(data) {
                                                            console.log(data);
                                                        }
                                                    });
                                                }

                                                function deleteImage(src) {
                                                    $.ajax({
                                                        data: {
                                                            src: src
                                                        },
                                                        type: "POST",
                                                        url: "<?= site_url('cms/summernoteDeleteImage') ?>",
                                                        cache: false,
                                                        success: function(response) {
                                                            console.log(response);
                                                        }
                                                    });
                                                }
                                                $('#catatan').summernote('code', `<?= $row['catatan']; ?>`);
                                                $('#catatan').summernote({
                                                    disableDragAndDrop: true
                                                });
                                                $('.note-statusbar').hide();
                                            </script>
                                        </div>
                                        <div class="d-flex justify-content-center flex-column">
                                            <?php
                                            $status = $row['status'];
                                            $pathacc = site_url("cms/account/$username/statusChange/$id/Disetujui");
                                            if ($status == "Ditinjau") {
                                                echo "<a href='$pathacc' class='btn btn-success btn-block'><i class='fas fa-check mr-2'></i>Disetujui</a>";
                                                echo "<button type='submit' class='btn btn-danger btn-block'><i class='fas fa-xmark mr-2'></i>Ditolak</button>";
                                            } else if ($status == "Disetujui") {
                                                echo "<button type='submit' class='btn btn-danger btn-block' name='ditolak'><i class='fas fa-xmark mr-2'></i>Ditolak</button>";
                                            } else if ($status == "Ditolak") {
                                                echo "<a href='$pathacc' class='btn btn-success btn-block' name='disetujui'><i class='fas fa-check mr-2'></i>Disetujui</a>";
                                            }
                                            ?>
                                        </div>
                                    </form>
                                <?php endif ?>
                                <?php if ($tipeAkun == 'User') : ?>
                                    <div class="form-group">
                                        <div style="max-height:330px; min-height:100px; overflow-y:auto;" class="border pt-1 px-2">
                                            <?= $row['catatan']; ?>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center flex-column">
                                        <?php if ($row['status'] != "Disetujui") : ?>
                                            <a href="<?= site_url('cms/account/' . $username . '/sunting/') ?><?= $row['id_artikel']; ?>" class="btn btn-warning btn-block"><i class="fas fa-pen mr-2"></i>Sunting</a>
                                            <a class="btn btn-danger btn-block" data-toggle="modal" data-target="#hapus">
                                                <i class="fas fa-trash mr-2"></i>Hapus
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($row['status'] == "Disetujui") : ?>
                                            <a href="<?= site_url('cms/account/' . $username . '/sunting/') ?><?= $row['id_artikel']; ?>" class="btn btn-warning btn-block disabled"><i class="fas fa-pen mr-2"></i>Sunting</a>
                                            <a class="btn btn-danger btn-block disabled">
                                                <i class="fas fa-trash mr-2"></i>Hapus
                                            </a>
                                        <?php endif; ?>
                                        <div class="modal fade" id="hapus" tabindex="-1" aria-labelledby="hapusLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-dark font-weight-normal" id="hapusLabel"><i class="fa-regular fa-trash-can mr-2"></i>Hapus Artikel</h5>
                                                        <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="<?= site_url('cms/account/' . $username . '/delete/artikel/' . $row["id_artikel"]) ?>" method="post">
                                                        <div class="modal-body text-dark d-flex flex-column text-center">
                                                            <span class="pt-2 pb-4"><i class="fa-regular fa-circle-xmark" style="font-size: 10em; color:#DC3545;"></i></span>
                                                            <span>Apakah anda yakin menghapus <b><?= $row["judul"]; ?></b> ? </span>
                                                        </div>
                                                        <div class="modal-footer justify-content-center">
                                                            <button type="button" class="btn btn-danger  w-25" data-dismiss="modal">Tidak</button>
                                                            <button type="submit" class="btn btn-outline-success w-25">Ya</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </section>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
        </div>