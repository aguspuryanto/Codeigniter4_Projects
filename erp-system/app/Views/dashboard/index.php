<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="<?= base_url('laporan') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Laporan
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Penjualan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Penjualan (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($total_penjualan, 0, ',', '.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pengeluaran Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Pengeluaran (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Hutang Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Hutang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($hutang_piutang_model->getTotalHutang(), 0, ',', '.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Piutang Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Piutang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($hutang_piutang_model->getTotalPiutang(), 0, ',', '.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Penjualan & Pengeluaran</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="salesExpenseChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Ringkasan Keuangan</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="financialSummaryChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Penjualan
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Pengeluaran
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Piutang
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Hutang
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Stok Menipis -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Produk Stok Menipis</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produk_menipis as $produk): ?>
                                <tr>
                                    <td><?= $produk['nama_produk'] ?></td>
                                    <td><?= $produk['stok'] ?></td>
                                    <td>
                                        <a href="<?= base_url('produk/edit/' . $produk['id']) ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hutang Piutang Jatuh Tempo -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Hutang & Piutang Jatuh Tempo</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Jenis</th>
                                    <th>Nominal</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hutang_jatuh_tempo as $hutang): ?>
                                <tr>
                                    <td>Hutang</td>
                                    <td>Rp <?= number_format($hutang['nominal'], 0, ',', '.') ?></td>
                                    <td><?= date('d/m/Y', strtotime($hutang['tanggal'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('hutang-piutang/edit/' . $hutang['id']) ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php foreach ($piutang_jatuh_tempo as $piutang): ?>
                                <tr>
                                    <td>Piutang</td>
                                    <td>Rp <?= number_format($piutang['nominal'], 0, ',', '.') ?></td>
                                    <td><?= date('d/m/Y', strtotime($piutang['tanggal'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('hutang-piutang/edit/' . $piutang['id']) ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Scripts -->
<script>
// Sales & Expense Chart
var ctx = document.getElementById("salesExpenseChart");
var salesExpenseChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: "Penjualan",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: <?= json_encode(array_column($grafik_penjualan, 'total')) ?>,
        },
        {
            label: "Pengeluaran",
            lineTension: 0.3,
            backgroundColor: "rgba(231, 74, 59, 0.05)",
            borderColor: "rgba(231, 74, 59, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(231, 74, 59, 1)",
            pointBorderColor: "rgba(231, 74, 59, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(231, 74, 59, 1)",
            pointHoverBorderColor: "rgba(231, 74, 59, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: <?= json_encode(array_column($grafik_pengeluaran, 'total')) ?>,
        }],
    },
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
        },
        scales: {
            xAxes: [{
                time: {
                    unit: 'date'
                },
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxTicksLimit: 7
                }
            }],
            yAxes: [{
                ticks: {
                    maxTicksLimit: 5,
                    padding: 10,
                    callback: function(value, index, values) {
                        return 'Rp ' + number_format(value);
                    }
                },
                gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }],
        },
        legend: {
            display: true
        },
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': Rp ' + number_format(tooltipItem.yLabel);
                }
            }
        }
    }
});

// Financial Summary Chart
var ctx2 = document.getElementById("financialSummaryChart");
var financialSummaryChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ["Penjualan", "Pengeluaran", "Piutang", "Hutang"],
        datasets: [{
            data: [
                <?= $total_penjualan ?>,
                <?= $total_pengeluaran ?>,
                <?= $hutang_piutang_model->getTotalPiutang() ?>,
                <?= $hutang_piutang_model->getTotalHutang() ?>
            ],
            backgroundColor: ['#4e73df', '#e74a3b', '#1cc88a', '#f6c23e'],
            hoverBackgroundColor: ['#2e59d9', '#e02d1b', '#17a673', '#f4b619'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': Rp ' + number_format(tooltipItem.yLabel);
                }
            }
        },
        legend: {
            display: false
        },
        cutoutPercentage: 80,
    },
});

// Helper function for number formatting
function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
</script>
<?= $this->endSection() ?> 