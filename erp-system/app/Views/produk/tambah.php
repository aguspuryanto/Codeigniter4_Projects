<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Produk</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= base_url('produk/save'); ?>" method="post">
                <?= csrf_field(); ?>
                
                <div class="form-group">
                    <label for="kode">Kode Produk</label>
                    <input type="text" class="form-control <?= ($validation->hasError('kode')) ? 'is-invalid' : ''; ?>" 
                           id="kode" name="kode" value="<?= old('kode'); ?>" required>
                    <div class="invalid-feedback">
                        <?= $validation->getError('kode'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nama">Nama Produk</label>
                    <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" 
                           id="nama" name="nama" value="<?= old('nama'); ?>" required>
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select class="form-control <?= ($validation->hasError('kategori')) ? 'is-invalid' : ''; ?>" 
                            id="kategori" name="kategori" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Makanan" <?= (old('kategori') == 'Makanan') ? 'selected' : ''; ?>>Makanan</option>
                        <option value="Minuman" <?= (old('kategori') == 'Minuman') ? 'selected' : ''; ?>>Minuman</option>
                        <option value="Snack" <?= (old('kategori') == 'Snack') ? 'selected' : ''; ?>>Snack</option>
                        <option value="Lainnya" <?= (old('kategori') == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('kategori'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="harga">Harga</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : ''; ?>" 
                               id="harga" name="harga" value="<?= old('harga'); ?>" required min="0">
                        <div class="invalid-feedback">
                            <?= $validation->getError('harga'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" class="form-control <?= ($validation->hasError('stok')) ? 'is-invalid' : ''; ?>" 
                           id="stok" name="stok" value="<?= old('stok'); ?>" required min="0">
                    <div class="invalid-feedback">
                        <?= $validation->getError('stok'); ?>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="status">Status</label>
                    <select class="form-control <?= ($validation->hasError('status')) ? 'is-invalid' : ''; ?>" 
                            id="status" name="status" required>
                        <option value="aktif" <?= (old('status') == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                        <option value="nonaktif" <?= (old('status') == 'nonaktif') ? 'selected' : ''; ?>>Nonaktif</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('status'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= base_url('produk'); ?>" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?> 