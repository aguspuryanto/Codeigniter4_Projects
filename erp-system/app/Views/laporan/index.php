<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Keuangan</h1>
        <div>
            <a href="<?= base_url('laporan/print?start_date=' . $start_date . '&end_date=' . $end_date . '&jenis=' . $jenis) ?>" 
               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" target="_blank">
                <i class="fas fa-print fa-sm text-white-50"></i> Cetak Laporan
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('laporan') ?>" method="get" class="row">
                <div class="col-md-3 mb-3">
                    <label for="start_date">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" 
                           value="<?= $start_date ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="end_date">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" 
                           value="<?= $end_date ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="jenis">Jenis Transaksi</label>
                    <select class="form-control" id="jenis" name="jenis">
                        <option value="semua" <?= $jenis == 'semua' ? 'selected' : '' ?>>Semua</option>
                        <option value="penjualan" <?= $jenis == 'penjualan' ? 'selected' : '' ?>>Penjualan</option>
                        <option value="pengeluaran" <?= $jenis == 'pengeluaran' ? 'selected' : '' ?>>Pengeluaran</option>
                        <option value="hutang" <?= $jenis == 'hutang' ? 'selected' : '' ?>>Hutang</option>
                        <option value="piutang" <?= $jenis == 'piutang' ? 'selected' : '' ?>>Piutang</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
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
                                Rp <?= number_format($total_penjualan, 0, ',', '.') ?>
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
                                Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?>
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
                                Rp <?= number_format($total_hutang, 0, ',', '.') ?>
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
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Piutang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp <?= number_format($total_piutang, 0, ',', '.') ?>
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

    <!-- Charts Row -->
    <div class="row">
        <!-- Penjualan & Pengeluaran Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Penjualan & Pengeluaran</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="salesExpenseChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hutang & Piutang Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Hutang & Piutang</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="debtReceivableChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Details -->
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
                        <?php foreach ($transaksi as $t): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($t['tanggal'])) ?></td>
                                <td><?= $t['jenis'] ?></td>
                                <td><?= $t['keterangan'] ?></td>
                                <td class="<?= $t['tipe'] == 'masuk' ? 'text-success' : 'text-danger' ?>">
                                    <?= $t['tipe'] == 'masuk' ? '+' : '-' ?> 
                                    Rp <?= number_format($t['jumlah'], 0, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Sales & Expense Chart
var ctx = document.getElementById('salesExpenseChart').getContext('2d');
var salesExpenseChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($grafik_penjualan['labels']) ?>,
        datasets: [{
            label: 'Penjualan',
            data: <?= json_encode($grafik_penjualan['data']) ?>,
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78, 115, 223, 0.05)',
            tension: 0.3
        }, {
            label: 'Pengeluaran',
            data: <?= json_encode($grafik_pengeluaran['data']) ?>,
            borderColor: '#e74a3b',
            backgroundColor: 'rgba(231, 74, 59, 0.05)',
            tension: 0.3
        }]
    },
    options: {
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': Rp ' + 
                               context.parsed.y.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }
                }
            }
        }
    }
});

// Debt & Receivable Chart
var ctx2 = document.getElementById('debtReceivableChart').getContext('2d');
var debtReceivableChart = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: <?= json_encode($grafik_hutang_piutang['labels']) ?>,
        datasets: [{
            label: 'Hutang',
            data: <?= json_encode($grafik_hutang_piutang['hutang']) ?>,
            backgroundColor: '#f6c23e',
            borderColor: '#f6c23e',
            borderWidth: 1
        }, {
            label: 'Piutang',
            data: <?= json_encode($grafik_hutang_piutang['piutang']) ?>,
            backgroundColor: '#1cc88a',
            borderColor: '#1cc88a',
            borderWidth: 1
        }]
    },
    options: {
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': Rp ' + 
                               context.parsed.y.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }
                }
            }
        }
    }
});
</script>
<?= $this->endSection(); ?> 