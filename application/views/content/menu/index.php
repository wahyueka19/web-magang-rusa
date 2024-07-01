        <!-- CONTENT -->
        <main>
            <h2><?= $judul ?></h2>
            <?php if ($tipeAkun == "User") : ?>
                <div class="row mt-4">
                    <div class="col-lg-3 col-6 mb-4">
                        <div class="bg-info d-flex justify-content-between border-rad shadow" style="overflow: hidden;">
                            <div class="col-8 my-auto pt-4 p-3">
                                <h4 class="text-white">Ditinjau</h4>
                            </div>
                            <div class="col-4 bg-dark d-flex flex-column justify-content-center">
                                <h2 class="text-white text-center m-0"><?= $ditinjau ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mb-4">
                        <div class="bg-success d-flex justify-content-between border-rad shadow" style="overflow: hidden;">
                            <div class="col-8 my-auto pt-4 p-3">
                                <h4 class="text-white">Disetujui</h4>
                            </div>
                            <div class="col-4 bg-dark d-flex flex-column justify-content-center">
                                <h2 class="text-white text-center m-0"><?= $disetujui ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mb-4">
                        <div class="bg-danger d-flex justify-content-between border-rad shadow" style="overflow: hidden;">
                            <div class="col-8 my-auto pt-4 p-3">
                                <h4 class="text-white">Ditolak</h4>
                            </div>
                            <div class="col-4 bg-dark d-flex flex-column justify-content-center">
                                <h2 class="text-white text-center m-0"><?= $ditolak ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mb-4">
                        <div class="bg-warning d-flex justify-content-between border-rad shadow" style="overflow: hidden;">
                            <div class="col-8 my-auto pt-4 p-3">
                                <h4 class="text-dark">Website</h4>
                            </div>
                            <div class="col-4 bg-dark d-flex flex-column justify-content-center">
                                <a href="<?= base_url() ?>" class="text-white d-flex align-items-center justify-content-center ml-n1" style="font-size: 42px;"><i class="fas fa-arrow-circle-right ml-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card p-4 col-12 shadow">
                    <canvas class="my-4 chartjs-render-monitor" id="myChart" width="1948" height="600" style="display: block; width: 974px; height: 411px;"></canvas>
                </div>
                <?php
                //Inisialisasi nilai variabel awal
                $dtj = '';
                $dst = '';
                $dtlk = '';

                $jmldtj = '';
                $jmldst = '';
                $jmldtlk = '';

                $mdtj = '';
                $mdst = '';
                $mdtlk = '';

                foreach ($grafikdtj as $item) {
                    $stat = $item->stat;
                    $dtj .= "'$stat'" . ", ";
                    $jum = $item->count;
                    $jmldtj .= "$jum" . ", ";
                    $month = $item->month_name;
                    $mdtj .= "$month" . ", ";
                }
                foreach ($grafikdst as $item) {
                    $stat = $item->stat;
                    $dst .= "'$stat'" . ", ";
                    $jum = $item->count;
                    $jmldst .= "$jum" . ", ";
                    $month = $item->month_name;
                    $mdst .= "$month" . ", ";
                }
                foreach ($grafikdtlk as $item) {
                    $stat = $item->stat;
                    $dtlk .= "'$stat'" . ", ";
                    $jum = $item->count;
                    $jmldtlk .= "$jum" . ", ";
                    $month = $item->month_name;
                    $mdtlk .= "$month" . ", ";
                }
                ?>
                <script>
                    $(function() {
                        var Canvas = document.getElementById("myChart");

                        var dtj = {
                            label: 'Ditinjau',
                            data: [<?= $jmldtj; ?>],
                            borderColor: 'rgb(52, 58, 64)',
                            backgroundColor: 'rgb(23, 162, 184)',
                        };

                        var dst = {
                            label: 'Disetujui',
                            data: [<?= $jmldst; ?>],
                            borderColor: 'rgb(52, 58, 64)',
                            backgroundColor: 'rgb(40, 167, 69)',
                        };

                        var dtlk = {
                            label: 'Ditolak',
                            data: [<?= $jmldtlk; ?>],
                            borderColor: 'rgb(52, 58, 64)',
                            backgroundColor: 'rgb(220, 53, 69)',
                        };

                        var month = {
                            labels: ["May", "June", "Jul", "August", "Sept", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar", "Apr"],
                            datasets: [dtj, dst, dtlk]
                        };

                        var chartOptions = {
                            scales: {
                                xAxes: [{
                                    barPercentage: 1,
                                    categoryPercentage: 0.6,
                                }],
                                y: {
                                    ticks: {
                                        stepSize: 1
                                    },
                                    beginAtZero: true
                                },
                            }
                        };

                        var barChart = new Chart(Canvas, {
                            type: 'bar',
                            data: month,
                            options: chartOptions
                        });
                    });
                </script>
            <?php endif ?>
            <?php if ($tipeAkun == "Admin") : ?>
                <form class="form-inline pt-1" action="<?= site_url('cms/account/' . $tipeAkun) ?>/<?= "artikel" ?>" method="post">
                    <div class="d-flex flex-column w-100" style="gap:1em;">
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
                                    <a class="btn btn-primary" style="font-size: 13px;" href="<?= site_url("cms/account/" . $username) ?>/<?= $row['id_artikel']; ?>">Tinjau</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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
                <?php endif ?>
        </main>
        </div>