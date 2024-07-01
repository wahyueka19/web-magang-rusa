        <!-- CONTENT -->
        <main>
            <h2>Artikel</h2>
            <form class="form-inline pt-1" action="<?= site_url('cms/account/' . $username . '/artikel') ?>" method="post">
                <div class="d-flex flex-column w-100 " style="gap:1em;">
                    <div>
                        <input class="form-control mr-2 mb-0" type="text" name="cari" id="cari" value="<?= $cari ?>" placeholder="Cari artikel">
                        <script>
                            $("#cari").autocomplete({
                                source: function(request, response) {
                                    $.ajax({
                                        url: '<?= site_url("cms/autoComplete/artikel") ?>',
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
                            <option value="<?php $filter == "Ditinjau" ? print "Ditinjau" : print "Ditinjau" ?>" <?php $filter == "Ditinjau" ? print "selected" : '' ?>>Ditinjau</option>
                            <option value="<?php $filter == "Disetujui" ? print "Disetujui" : print "Disetujui" ?>" <?php $filter == "Disetujui" ? print "selected" : '' ?>>Disetujui</option>
                            <option value="<?php $filter == "Ditolak" ? print "Ditolak" : print "Ditolak" ?>" <?php $filter == "Ditolak" ? print "selected" : '' ?>>Ditolak</option>
                        </select>
                        <button type="submit" name="submit" class="btn btn-outline-primary mb-0">
                            <i class="fas fa-search mr-2"></i>Cari
                        </button>
                    </div>
                    <div class="d-flex mb-0" style="gap:1em;">
                        <?php if ($tipeAkun == 'User') : ?>
                            <a href="<?= site_url('cms/account/' . $username . '/buatArtikel') ?>" class="btn btn-success">
                                <i class="fa-solid fa-file-circle-plus mr-2"></i>Buat Artikel
                            </a>
                        <?php endif; ?>
                        <a href="<?= site_url('home/artikel') ?>" class="btn btn-warning"><i class="fas fa-globe mr-2"></i>Lihat Web</a>
                        <a href="<?= site_url('cms/pdf') ?>" target="_blank" class="btn btn-danger"><i class="fas fa-file-pdf mr-2"></i>Export pdf</a>
                    </div>
                </div>
            </form>
            <table class="table table-hover table-striped table-bordered text-center mt-3">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="align-middle">No</th>
                        <th scope="col" class="align-middle">Judul Artikel</th>
                        <th scope="col" class="align-middle">Status</th>
                        <th scope="col" class="align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($artikel)) : ?>
                        <tr>
                            <td colspan="4">
                                <div class="alert alert-danger text-center" role="alert">
                                    Artikel tidak ditemukan
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php
                    foreach ($artikel as $row) :
                    ?>
                        <tr>
                            <th scope="row" class="align-middle"><?= ++$start; ?></th>
                            <td class="align-middle"><?= $row['judul']; ?></td>
                            <?php
                            $status = $row['status'];
                            if ($status == "Ditinjau") {
                                $text = "text-info";
                            } else if ($status == "Disetujui") {
                                $text = "text-success";
                            } else if ($status == "Ditolak") {
                                $text = "text-danger";
                            }
                            echo "<td class='$text align-middle'>$status</td>";
                            ?>
                            <td class="align-middle">
                                <?php if ($uri5) : ?>
                                    <a class="btn btn-primary" style="font-size: 13px;" href="<?= site_url("cms/account/" . $username . '/artikel/' . $uri5 . '/') ?><?= $row['id_artikel']; ?>">Tinjau</a>
                                <?php else : ?>
                                    <a class="btn btn-primary" style="font-size: 13px;" href="<?= site_url("cms/account/" . $username . '/artikel/') ?><?= $row['id_artikel']; ?>">Tinjau</a>
                                <?php endif ?>
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
                        <div class="toast-body text-white">
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