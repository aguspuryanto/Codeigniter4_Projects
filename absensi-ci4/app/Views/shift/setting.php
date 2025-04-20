<?php
// echo json_encode($data_pegawai); exit;
$daysInMonth = date('t'); // Returns number of days in current month
// echo $daysInMonth;
?>

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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <form id="formSettingShift" action="<?= base_url('shift/setting/store') ?>" method="post">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Nama Pegawai</th>
                                        <th colspan="<?= $daysInMonth ?>" class="text-left">Bulan <?= date('F Y') ?></th>
                                    </tr>
                                    <tr>
                                        <?php for ($i = 1; $i <= $daysInMonth; $i++): ?>
                                            <th>Tanggal <?= $i ?></th>
                                        <?php endfor; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data_pegawai['pegawai'] as $pegawai): ?>
                                    <tr>
                                        <td><?= $pegawai->nama; ?></td>
                                        <?php for ($i = 1; $i <= $daysInMonth; $i++): ?>
                                        <td>
                                            <?php 
                                            $currentDate = date('Y-m-d', strtotime(date('Y-m-01') . ' + ' . ($i - 1) . ' days'));
                                            $selectedShift = '';
                                            // echo $currentDate . '<br>';
                                            // echo $pegawai->id . '<br>';
                                            
                                            // Find matching schedule for this employee and date
                                            foreach ($employee_schedule as $schedule) {
                                                // echo json_encode($schedule);
                                                if ($schedule['tgl_shift'] == $currentDate && $schedule['id_pegawai'] == $pegawai->id && $schedule['id_shift'] != '') {
                                                    $selectedShift = $schedule['id_shift'];
                                                    break;
                                                }
                                            }
                                            ?>
                                            <input type="hidden" name="tgl_shift[]" value="<?= $currentDate ?>">
                                            <input type="hidden" name="id_pegawai[]" value="<?= $pegawai->id ?>">
                                            <select name="id_shift[]" class="form-select" style="width: 150px;">
                                                <option value="">Pilih Shift</option>
                                                <?php foreach ($shifts as $shift): ?>
                                                    <option value="<?= $shift['id'] ?>" <?= $selectedShift == $shift['id'] ? 'selected' : '' ?>>
                                                        <?= $shift['nama_shift'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <?php endfor; ?>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            </form>
                        </div>                        
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="btnSimpan">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('#btnSimpan').click(function() {
            var url = $('#formSettingShift').attr('action');
            var formData = $('#formSettingShift').serialize();
            console.log(formData);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                    if (response.status === 'success') {
                        alert(response.message);
                    } else {
                        alert('Gagal menyimpan jadwal');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>

