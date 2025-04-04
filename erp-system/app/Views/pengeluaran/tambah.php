<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Tambah Pengeluaran</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Pengeluaran</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('pengeluaran/save') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control <?= ($validation->hasError('tanggal')) ? 'is-invalid' : '' ?>" id="tanggal" name="tanggal" value="<?= old('tanggal') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('tanggal') ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select class="form-control <?= ($validation->hasError('kategori')) ? 'is-invalid' : '' ?>" id="kategori" name="kategori">
                                <option value="">Pilih Kategori</option>
                                <option value="Operasional" <?= (old('kategori') == 'Operasional') ? 'selected' : '' ?>>Operasional</option>
                                <option value="Gaji" <?= (old('kategori') == 'Gaji') ? 'selected' : '' ?>>Gaji</option>
                                <option value="Utilitas" <?= (old('kategori') == 'Utilitas') ? 'selected' : '' ?>>Utilitas</option>
                                <option value="Pemeliharaan" <?= (old('kategori') == 'Pemeliharaan') ? 'selected' : '' ?>>Pemeliharaan</option>
                                <option value="Lainnya" <?= (old('kategori') == 'Lainnya') ? 'selected' : '' ?>>Lainnya</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('kategori') ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control <?= ($validation->hasError('keterangan')) ? 'is-invalid' : '' ?>" id="keterangan" name="keterangan" rows="3"><?= old('keterangan') ?></textarea>
                            <div class="invalid-feedback">
                                <?= $validation->getError('keterangan') ?>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nominal">Nominal</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" class="form-control <?= ($validation->hasError('nominal')) ? 'is-invalid' : '' ?>" id="nominal" name="nominal" value="<?= old('nominal') ?>" min="0">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('nominal') ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?= base_url('pengeluaran') ?>" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 