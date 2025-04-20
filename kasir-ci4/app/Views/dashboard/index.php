<?= $this->extend('templates/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <!-- Total Produk -->
    <div class="col-lg-3 col-md-6 col-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-package"></i></span>
                    </div>
                </div>
                <span class="fw-semibold d-block mb-1">Total Produk</span>
                <h3 class="card-title mb-2"><?= number_format($total_products) ?></h3>
            </div>
        </div>
    </div>

    <!-- Total Transaksi -->
    <div class="col-lg-3 col-md-6 col-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-success"><i class="bx bx-receipt"></i></span>
                    </div>
                </div>
                <span class="fw-semibold d-block mb-1">Total Transaksi</span>
                <h3 class="card-title mb-2"><?= number_format($total_transactions) ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Transaksi Terakhir -->
<div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
    <div class="card">
        <h5 class="card-header">Transaksi Terakhir</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No. Transaksi</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Kasir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_transactions as $transaction) : ?>
                            <tr>
                                <td><?= $transaction['invoice'] ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($transaction['created_at'])) ?></td>
                                <td>Rp <?= number_format($transaction['total'], 0, ',', '.') ?></td>
                                <td><?= $transaction['cashier_name'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('page-script') ?>
<script src="<?= base_url('assets/sneat/js/dashboards-analytics.js') ?>"></script>
<?= $this->endSection() ?>

<?= $this->include('templates/footer') ?>