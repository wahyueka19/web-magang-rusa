<!-- CONTENT -->
<main>
  <h2><?= $judul ?></h2>
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
</main>
</div>