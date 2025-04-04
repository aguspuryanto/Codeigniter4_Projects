<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Hutang/Piutang</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= base_url('hutang-piutang/save'); ?>" method="post">
                <?= csrf_field(); ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <select class="form-control <?= ($validation->hasError('jenis')) ? 'is-invalid' : ''; ?>" 
                                    id="jenis" name="jenis" required>
                                <option value="">Pilih Jenis</option>
                                <option value="hutang" <?= (old('jenis') == 'hutang') ? 'selected' : ''; ?>>Hutang</option>
                                <option value="piutang" <?= (old('jenis') == 'piutang') ? 'selected' : ''; ?>>Piutang</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('jenis'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control <?= ($validation->hasError('tanggal')) ? 'is-invalid' : ''; ?>" 
                                id="tanggal" name="tanggal" value="<?= old('tanggal', date('Y-m-d')); ?>" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('tanggal'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" 
                           id="nama" name="nama" value="<?= old('nama'); ?>" required>
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama'); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" class="form-control <?= ($validation->hasError('jumlah')) ? 'is-invalid' : ''; ?>" 
                                    id="jumlah" name="jumlah" value="<?= old('jumlah'); ?>" required min="0">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('jumlah'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jatuh_tempo">Jatuh Tempo</label>
                            <input type="date" class="form-control <?= ($validation->hasError('jatuh_tempo')) ? 'is-invalid' : ''; ?>" 
                                id="jatuh_tempo" name="jatuh_tempo" value="<?= old('jatuh_tempo'); ?>" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('jatuh_tempo'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="keterangan">Keterangan</label>
                    <textarea class="form-control <?= ($validation->hasError('keterangan')) ? 'is-invalid' : ''; ?>" 
                              id="keterangan" name="keterangan" rows="3"><?= old('keterangan'); ?></textarea>
                    <div class="invalid-feedback">
                        <?= $validation->getError('keterangan'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= base_url('hutang-piutang'); ?>" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?> 