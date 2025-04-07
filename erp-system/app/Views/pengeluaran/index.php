<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengeluaran</h1>
        <a href="<?= base_url('pengeluaran/tambah'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Pengeluaran
        </a>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <!-- Content Row -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Pengeluaran</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="grafikPengeluaran" style="height: 400px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pengeluaran Tertinggi</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <?php foreach ($pengeluaran_tertinggi ?? [] as $index => $output): ?>
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><?= $index + 1 ?>. <?= $output['kategori'] ?> - <?= $output['subkategori'] ?></h6>
                                    <small class="text-muted"><?= date('d M Y', strtotime($output['tanggal'])) ?></small>
                                </div>
                                <p class="mb-1">Total: Rp <?= number_format($output['nominal'], 0, ',', '.') ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pengeluaran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Subkategori</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($pengeluaran): ?>
                        <?php foreach ($pengeluaran as $p): ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($p['tanggal'])); ?></td>
                                <td><?= $p['kategori']; ?></td>
                                <td><?= $p['subkategori']; ?></td>
                                <td>Rp <?= number_format($p['nominal'], 0, ',', '.'); ?></td>
                                <td><?= $p['keterangan']; ?></td>
                                <td>
                                    <a href="<?= base_url('pengeluaran/edit/' . $p['id']); ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('pengeluaran/delete/' . $p['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('styles') ?>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<?= $this->endSection() ?>

<?= $this->section('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    // Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    // Chart.defaults.global.defaultFontColor = '#858796';

    // Pengeluaran Chart
    var ctx = document.getElementById("grafikPengeluaran");
    var grafikPengeluaran = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($grafik_pengeluaran ?? [], 'bulan')); ?>,
            datasets: [{
                label: "Total Pengeluaran",
                backgroundColor: "rgba(231, 74, 59, 0.5)",
                borderColor: "rgba(231, 74, 59, 1)",
                borderWidth: 1,
                data: <?= json_encode(array_column($grafik_pengeluaran ?? [], 'total')); ?>,
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                },
                y: {
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: function(value, index, values) {
                            return 'Rp ' + number_format(value);
                        }
                    },
                    grid: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#858796",
                    titleMarginBottom: 10,
                    titleColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    padding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(context) {
                            var label = context.dataset.label || '';
                            return label + ': Rp ' + number_format(context.parsed.y);
                        }
                    }
                }
            }
        }
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

    // DataTable
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [[ 0, "desc" ]]
        });
    });
</script>
<?= $this->endSection(); ?> 