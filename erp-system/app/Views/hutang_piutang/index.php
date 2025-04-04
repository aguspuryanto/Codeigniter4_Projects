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

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="hutang-tab" data-toggle="tab" href="#hutang" role="tab" aria-controls="hutang" aria-selected="true">Hutang</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="piutang-tab" data-toggle="tab" href="#piutang" role="tab" aria-controls="piutang" aria-selected="false">Piutang</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="myTabContent">
        <!-- Hutang Tab -->
        <div class="tab-pane fade show active" id="hutang" role="tabpanel" aria-labelledby="hutang-tab">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTableHutang" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Nominal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($hutang as $h) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= date('d/m/Y', strtotime($h['tanggal'])) ?></td>
                                        <td><?= $h['keterangan'] ?></td>
                                        <td>Rp <?= number_format($h['nominal'], 0, ',', '.') ?></td>
                                        <td>
                                            <?php if ($h['status'] == 'Lunas') : ?>
                                                <span class="badge badge-success">Lunas</span>
                                            <?php else : ?>
                                                <span class="badge badge-warning">Belum Lunas</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('hutang-piutang/edit/' . $h['id']) ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?= base_url('hutang-piutang/delete/' . $h['id']) ?>" method="post" class="d-inline">
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

        <!-- Piutang Tab -->
        <div class="tab-pane fade" id="piutang" role="tabpanel" aria-labelledby="piutang-tab">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTablePiutang" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Nominal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($piutang as $p) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= date('d/m/Y', strtotime($p['tanggal'])) ?></td>
                                        <td><?= $p['keterangan'] ?></td>
                                        <td>Rp <?= number_format($p['nominal'], 0, ',', '.') ?></td>
                                        <td>
                                            <?php if ($p['status'] == 'Lunas') : ?>
                                                <span class="badge badge-success">Lunas</span>
                                            <?php else : ?>
                                                <span class="badge badge-warning">Belum Lunas</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('hutang-piutang/edit/' . $p['id']) ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?= base_url('hutang-piutang/delete/' . $p['id']) ?>" method="post" class="d-inline">
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
    </div>
</div>

<!-- DataTables JavaScript -->
<script>
$(document).ready(function() {
    $('#dataTableHutang').DataTable();
    $('#dataTablePiutang').DataTable();
});
</script>
<?= $this->endSection() ?> 