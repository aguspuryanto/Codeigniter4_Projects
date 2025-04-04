<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Tambah Penjualan</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Penjualan</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('penjualan/save') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control <?= ($validation->hasError('tanggal')) ? 'is-invalid' : '' ?>" id="tanggal" name="tanggal" value="<?= old('tanggal') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('tanggal') ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="produk_id">Produk</label>
                            <select class="form-control <?= ($validation->hasError('produk_id')) ? 'is-invalid' : '' ?>" id="produk_id" name="produk_id">
                                <option value="">Pilih Produk</option>
                                <?php foreach ($produk as $p) : ?>
                                    <option value="<?= $p['id'] ?>" <?= (old('produk_id') == $p['id']) ? 'selected' : '' ?>>
                                        <?= $p['nama_produk'] ?> - Stok: <?= $p['stok'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('produk_id') ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" class="form-control <?= ($validation->hasError('jumlah')) ? 'is-invalid' : '' ?>" id="jumlah" name="jumlah" value="<?= old('jumlah') ?>" min="1">
                            <div class="invalid-feedback">
                                <?= $validation->getError('jumlah') ?>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="harga_satuan">Harga Satuan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" class="form-control <?= ($validation->hasError('harga_satuan')) ? 'is-invalid' : '' ?>" id="harga_satuan" name="harga_satuan" value="<?= old('harga_satuan') ?>" min="0">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('harga_satuan') ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?= base_url('penjualan') ?>" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for dynamic price calculation -->
<script>
document.getElementById('produk_id').addEventListener('change', function() {
    const produkId = this.value;
    if (produkId) {
        // Get the selected option
        const selectedOption = this.options[this.selectedIndex];
        // Extract price from the option's data attribute or make an AJAX call
        // For now, we'll just set a default price
        document.getElementById('harga_satuan').value = '0';
    }
});
</script>
<?= $this->endSection() ?> 