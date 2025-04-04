<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengeluaran</h1>
        <a href="<?= base_url('pengeluaran/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Pengeluaran
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
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengeluaran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th>Nominal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($pengeluaran as $p) : ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= date('d/m/Y', strtotime($p['tanggal'])) ?></td>
                                <td><?= $p['kategori'] ?></td>
                                <td><?= $p['keterangan'] ?></td>
                                <td>Rp <?= number_format($p['nominal'], 0, ',', '.') ?></td>
                                <td>
                                    <a href="<?= base_url('pengeluaran/edit/' . $p['id']) ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?= base_url('pengeluaran/delete/' . $p['id']) ?>" method="post" class="d-inline">
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