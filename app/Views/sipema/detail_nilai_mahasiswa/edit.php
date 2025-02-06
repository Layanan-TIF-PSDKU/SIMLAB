<?php echo $this->include('sipema/sipema_partial/dashboard/header');?>
<?php echo $this->include('sipema/sipema_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')) : ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
<?php echo $this->include('sipema/sipema_partial/dashboard/side_menu') ?>
<?php endif; ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Form Edit Detail Nilai Mahasiswa</h2>
                    </div>
                    <?php if(has_permission('admin')) : ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Sipema</a></li>
                                <li class="breadcrumb-item active">Edit Detail Nilai Mahasiswa</li>
                            </ol>
                        </div>
                    <?php else : ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('sipema') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit Detail Nilai Mahasiswa</li>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url('sipema/nilai/update_nilai_mata_kuliah/'. $nilai->id_mhs . '/' . $nilai->id_mata_kuliah) ?>">
                                <div class="form-group mb-3">
                                        <label for="simple-select-1">Nama Mata Kuliah</label>
                                        <select class="form-control select2" name="id_mata_kuliah" id="simple-select-1">
                                            <option value="">Pilih Mata Kuliah</option>
                                            <?php foreach($mata_kuliah as $mk): ?>
                                                <option value="<?= $mk->id_mata_kuliah ?>"<?= $nilai->id_mata_kuliah == $mk->id_mata_kuliah ? 'selected' : null ?>><?= $mk->nama_mata_kuliah ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                         <!-- Error Validation -->
                                         <?php if ($validation->getError('id_mata_kuliah')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('id_mata_kuliah'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="simple-select-2">Nama Mahasiswa</label>
                                        <input type="hidden" name="id_mhs" value="<?= $nilai->id_mhs ?>">
                                        <input type="text" class="form-control" value="<?= $nilai->nama_mahasiswa ?>" readonly/>
                                         <!-- Error Validation -->
                                         <?php if ($validation->getError('id_mhs')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('id_mhs'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nilai UTS <span class="text-danger">*</span></label>
                                        <input type="number" id="address-wpalaceholder" name="nilai_uts" class="form-control" placeholder="Masukkan Nilai UTS" value="<?= $nilai->nilai_uts ?>" min="0" max="100"/>
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('nilai_uts')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nilai_uts'); ?>
                                            </div>
                                            <?php } ?>
                                            <div class="text-danger">
                                                <span>*</span> Skala nilai 0-100
                                            </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nilai UAS <span class="text-danger">*</span></label>
                                        <input type="number" id="address-wpalaceholder" name="nilai_uas" class="form-control" placeholder="Masukkan Nilai UAS" value="<?= $nilai->nilai_uas ?>" min="0" max="100"/>
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('nilai_uas')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nilai_uas'); ?>
                                            </div>
                                            <?php } ?>
                                            <div class="text-danger">
                                                <span>*</span> Skala nilai 0-100
                                            </div>
                                    </div>
                                    <button id="editButton" class="btn btn-primary" type="submit">
                                        Edit
                                    </button>
                                    <a href="<?= base_url('sipema/nilai'); ?>" class="btn btn-warning">Kembali</a>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- end section -->
            </div>
            <!-- /.col-12 col-lg-10 col-xl-10 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container-fluid -->
    <script>
        document.getElementById('editButton').addEventListener('click', function() {
        // Mengambil nilai input
        var nilaiUts = parseInt(document.getElementById('address-wpalaceholder').value);
        var nilaiUas = parseInt(document.getElementById('address-wpalaceholder').value);

        // Validasi nilai minimal dan maksimal
        if (nilaiUts < 0 || nilaiUts > 100 || nilaiUas < 0 || nilaiUas > 100) {
            alert('Nilai UTS dan UAS harus berada dalam rentang 0 hingga 100.');
            event.preventDefault(); // Mencegah pengiriman form jika validasi tidak berhasil
        } else {
            document.getElementById('loadingOverlay').classList.add('active');
        }
    });
    </script>
</main>
<?php echo $this->include('sipema/sipema_partial/dashboard/footer');?>