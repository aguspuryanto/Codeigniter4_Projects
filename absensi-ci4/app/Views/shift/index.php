<?= $this->extend('templates/index') ?>

<?= $this->section('pageBody') ?>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        
        <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        
        <!-- <a href="<?= base_url('/admin/shift/create') ?>" class="btn btn-primary mb-3">Tambah Shift Baru</a> -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- nama_shift, jam_mulai, jam_selesai -->
                        <form action="<?= base_url('/shift/store') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="nama_shift">Nama Shift</label>
                                        <input type="text" class="form-control" id="nama_shift" name="nama_shift" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="jam_mulai">Jam Mulai</label>
                                                <input type="text" class="form-control" id="jam_mulai" name="jam_mulai" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="jam_selesai">Jam Selesai</label>
                                                <input type="text" class="form-control" id="jam_selesai" name="jam_selesai" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 mt-4">
                                    <button type="submit" class="btn btn-primary">Tambah Shift</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <strong>Data Shift</strong>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Shift</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th class="text-center" style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($shifts as $shift): ?>
                                <tr>
                                    <td><?= $shift['nama_shift'] ?></td>
                                    <td><?= date('H:i', strtotime($shift['jam_mulai'])) ?></td>
                                    <td><?= date('H:i', strtotime($shift['jam_selesai'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('/shift/edit/' . $shift['id']) ?>" class="btn btn-warning">Edit</a>
                                        <a href="<?= base_url('/shift/delete/' . $shift['id']) ?>" class="btn btn-danger">Hapus</a>
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
</div>
<?= $this->endSection() ?>