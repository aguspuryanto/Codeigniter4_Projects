<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Keuangan</h1>
        <div>
            <button type="button" class="btn btn-success" onclick="window.print()">
                <i class="fas fa-print"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('laporan'); ?>" method="get">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="<?= $start_date ?? date('Y-m-01'); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end_date">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="<?= $end_date ?? date('Y-m-t'); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="jenis">Jenis Laporan</label>
                            <select class="form-control" id="jenis" name="jenis">
                                <option value="semua" <?= ($jenis ?? '') == 'semua' ? 'selected' : ''; ?>>Semua</option>
                                <option value="penjualan" <?= ($jenis ?? '') == 'penjualan' ? 'selected' : ''; ?>>Penjualan</option>
                                <option value="pengeluaran" <?= ($jenis ?? '') == 'pengeluaran' ? 'selected' : ''; ?>>Pengeluaran</option>
                                <option value="hutang" <?= ($jenis ?? '') == 'hutang' ? 'selected' : ''; ?>>Hutang</option>
                                <option value="piutang" <?= ($jenis ?? '') == 'piutang' ? 'selected' : ''; ?>>Piutang</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <!-- Total Penjualan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Penjualan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp <?= number_format($total_penjualan ?? 0, 0, ',', '.'); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
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
                                Total Pengeluaran</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp <?= number_format($total_pengeluaran ?? 0, 0, ',', '.'); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp <?= number_format($total_hutang ?? 0, 0, ',', '.'); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hand-holding-usd fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Piutang Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Piutang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp <?= number_format($total_piutang ?? 0, 0, ',', '.'); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
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
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Transaksi</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="transaksiChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Distribusi Transaksi</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="distribusiChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Penjualan
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Pengeluaran
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Hutang
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Piutang
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($transaksi) && is_array($transaksi)) : ?>
                            <?php foreach ($transaksi as $t) : ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($t['tanggal'])); ?></td>
                                    <td>
                                        <span class="badge badge-<?= $t['jenis'] == 'penjualan' ? 'primary' : 
                                            ($t['jenis'] == 'pengeluaran' ? 'danger' : 
                                            ($t['jenis'] == 'hutang' ? 'warning' : 'info')); ?>">
                                            <?= ucfirst($t['jenis']); ?>
                                        </span>
                                    </td>
                                    <td><?= $t['keterangan']; ?></td>
                                    <td>Rp <?= number_format($t['jumlah'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    // Transaksi Chart
    var ctx = document.getElementById("transaksiChart");
    var transaksiChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($chart_labels ?? []); ?>,
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
                data: <?= json_encode($chart_penjualan ?? []); ?>,
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
                data: <?= json_encode($chart_pengeluaran ?? []); ?>,
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

    // Distribusi Chart
    var ctx2 = document.getElementById("distribusiChart");
    var distribusiChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ["Penjualan", "Pengeluaran", "Hutang", "Piutang"],
            datasets: [{
                data: [
                    <?= $total_penjualan ?? 0; ?>,
                    <?= $total_pengeluaran ?? 0; ?>,
                    <?= $total_hutang ?? 0; ?>,
                    <?= $total_piutang ?? 0; ?>
                ],
                backgroundColor: ['#4e73df', '#e74a3b', '#f6c23e', '#36b9cc'],
                hoverBackgroundColor: ['#2e59d9', '#e02d1b', '#f4b619', '#2c9faf'],
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
                        var value = chart.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                        return datasetLabel + ': Rp ' + number_format(value);
                    }
                }
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });

    // DataTable
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [[ 0, "desc" ]]
        });
    });

    // Number format helper
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
<?= $this->endSection(); ?> 