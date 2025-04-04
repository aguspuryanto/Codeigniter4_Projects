<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Penjualan</h1>
        <a href="<?= base_url('penjualan/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Penjualan
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

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Penjualan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($penjualan as $p) : ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= date('d/m/Y', strtotime($p['tanggal'])) ?></td>
                                <td><?= $p['nama_produk'] ?></td>
                                <td><?= $p['jumlah'] ?></td>
                                <td>Rp <?= number_format($p['harga_satuan'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($p['total'], 0, ',', '.') ?></td>
                                <td>
                                    <a href="<?= base_url('penjualan/edit/' . $p['id']) ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?= base_url('penjualan/delete/' . $p['id']) ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- DataTables JavaScript -->
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();
});
</script>
<?= $this->endSection() ?> 