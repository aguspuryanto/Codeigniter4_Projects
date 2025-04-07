<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Hutang & Piutang</h1>
        <a href="<?= base_url('hutang/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
        </a>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Chart Row -->
    <div class="row">
        <!-- Total Hutang & Piutang Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Total Hutang & Piutang</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="grafikHutangPiutang" style="height: 400px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ringkasan</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Total Hutang</h6>
                        <p class="text-danger">Rp <?= number_format($grafik_data['total_hutang'], 0, ',', '.'); ?></p>
                    </div>
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Total Piutang</h6>
                        <p class="text-success">Rp <?= number_format($grafik_data['total_piutang'], 0, ',', '.'); ?></p>
                    </div>
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Hutang Lunas</h6>
                        <p class="text-success">Rp <?= number_format($grafik_data['hutang_lunas'], 0, ',', '.'); ?></p>
                    </div>
                    <div>
                        <h6 class="font-weight-bold">Piutang Lunas</h6>
                        <p class="text-success">Rp <?= number_format($grafik_data['piutang_lunas'], 0, ',', '.'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" id="hutang-tab" data-bs-toggle="tab" href="#hutang" role="tab" aria-controls="hutang" aria-selected="true">Hutang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="piutang-tab" data-bs-toggle="tab" href="#piutang" role="tab" aria-controls="piutang" aria-selected="false">Piutang</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <!-- Hutang Tab -->
                <div class="tab-pane fade show active" id="hutang" role="tabpanel" aria-labelledby="hutang-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTableHutang" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Keterangan</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hutang as $h): ?>
                                    <tr>
                                        <td><?= date('d M Y', strtotime($h['tanggal'])); ?></td>
                                        <td><?= date('d M Y', strtotime($h['jatuh_tempo'])); ?></td>
                                        <td><?= $h['keterangan']; ?></td>
                                        <td>Rp <?= number_format($h['nominal'], 0, ',', '.'); ?></td>
                                        <td>
                                            <span class="badge <?= $h['status'] == 'sudah bayar' ? 'bg-success' : 'bg-warning'; ?>">
                                                <?= $h['status'] == 'sudah bayar' ? 'Lunas' : 'Belum Lunas'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('hutang_piutang/edit/' . $h['id']); ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('hutang_piutang/delete/' . $h['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Piutang Tab -->
                <div class="tab-pane fade" id="piutang" role="tabpanel" aria-labelledby="piutang-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTablePiutang" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Keterangan</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($piutang as $p): ?>
                                    <tr>
                                        <td><?= date('d M Y', strtotime($p['tanggal'])); ?></td>
                                        <td><?= date('d M Y', strtotime($p['jatuh_tempo'])); ?></td>
                                        <td><?= $p['keterangan']; ?></td>
                                        <td>Rp <?= number_format($p['nominal'], 0, ',', '.'); ?></td>
                                        <td>
                                            <span class="badge <?= $p['status'] == 'sudah bayar' ? 'bg-success' : 'bg-warning'; ?>">
                                                <?= $p['status'] == 'sudah bayar' ? 'Lunas' : 'Belum Lunas'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('hutang_piutang/edit/' . $p['id']); ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('hutang_piutang/delete/' . $p['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i>
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

<?= $this->endSection() ?> 

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

    // Hutang & Piutang Chart
    var ctx = document.getElementById("grafikHutangPiutang");
    var grafikHutangPiutang = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Hutang', 'Total Piutang', 'Hutang Lunas', 'Piutang Lunas'],
            datasets: [{
                label: 'Jumlah',
                backgroundColor: [
                    'rgba(231, 74, 59, 0.5)',
                    'rgba(28, 200, 138, 0.5)',
                    'rgba(231, 74, 59, 0.2)',
                    'rgba(28, 200, 138, 0.2)'
                ],
                borderColor: [
                    'rgba(231, 74, 59, 1)',
                    'rgba(28, 200, 138, 1)',
                    'rgba(231, 74, 59, 1)',
                    'rgba(28, 200, 138, 1)'
                ],
                borderWidth: 1,
                data: [
                    <?= $grafik_data['total_hutang']; ?>,
                    <?= $grafik_data['total_piutang']; ?>,
                    <?= $grafik_data['hutang_lunas']; ?>,
                    <?= $grafik_data['piutang_lunas']; ?>
                ]
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
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
        $('#dataTableHutang').DataTable({
            "order": [[ 0, "desc" ]]
        });
        
        $('#dataTablePiutang').DataTable({
            "order": [[ 0, "desc" ]]
        });

        // Initialize Bootstrap tabs
        var triggerTabList = [].slice.call(document.querySelectorAll('#myTabContent a'))
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault()
                tabTrigger.show()
            })
        });
    });
</script>
<?= $this->endSection(); ?>