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
                        <h2 class="page-title">Form Tambah Pemetaan Mata Kuliah</h2>
                    </div>
                    <?php if(has_permission('admin')) : ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Sipema</a></li>
                                <li class="breadcrumb-item active">Tambah Pemetaan Mata Kuliah</li>
                            </ol>
                        </div>
                    <?php else : ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('sipema') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Tambah Pemetaan Mata Kuliah</li>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url("sipema/pemetaan_mata_kuliah/simpan") ?>">
                                    <div class="form-group mb-3">
                                        <label for="simple-select-3">Nama Sub Bidang</label>
                                        <select class="form-control select2" name="id_sub_bidang" id="simple-select-1" style="max-width: 100%;">
                                            <option value="">Pilih Sub Bidang</option>
                                            <?php foreach($sub_bidang as $sb): ?>
                                            <option value="<?= $sb->id_sub_bidang ?>"><?= $sb->nama_sub_bidang ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                         <!-- Error Validation -->
                                         <?php if ($validation->getError('id_sub_bidang')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('id_sub_bidang'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div id="dynamic-form">
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                            <label for="simple-select-3">Nama Mata Kuliah</label>
                                            <select class="form-control select2" name="id_mata_kuliah[]" required>
                                                <option value="">Pilih Mata Kuliah</option>
                                                <?php foreach($mata_kuliah as $mk): ?>
                                                <option value="<?= $mk->id_mata_kuliah ?>"><?= $mk->nama_mata_kuliah ?></option>
                                                <?php endforeach; ?>
                                            </select>     
                                            </div>
                                            <div class="form-group col-md-4">
                                            <label for="simple-select-3">Jenis Bobot</label>
                                            <select class="form-control select2" name="id_bobot[]" required>
                                                <option value="">Pilih Bobot</option>
                                                <?php foreach($bobot as $b): ?>
                                                <option value="<?= $b->id_bobot ?>"><?= $b->jenis_bobot ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            </div>
                                            <div class="form-group col mt-4">
                                                <button type="button" class="btn btn-primary add-row">Tambah Baris</button>
                                            </div>
                                        </div>
                                    </div>
                                    <button id="tambahButton" class="btn btn-primary" type="submit">
                                        Tambah
                                    </button>
                                    <a href="<?= base_url('sipema/pemetaan_mata_kuliah'); ?>" class="btn btn-warning">Kembali</a>
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
        document.getElementById('tambahButton').addEventListener('click', function() {
            document.getElementById('loadingOverlay').classList.add('active');
        });
    </script>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?= base_url('../assets/js/jquery.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $(".add-row").click(function(e) {
            e.preventDefault();
            $("#dynamic-form").prepend(`<div class="form-row mt-3 append_item">
                                    <div class="form-group col-md-5">
                                            <label for="simple-select-3">Nama Mata Kuliah</label>
                                            <select class="form-control select2" name="id_mata_kuliah[]" required>
                                                <option value="">Pilih Mata Kuliah</option>
                                                <?php foreach($mata_kuliah as $mk): ?>
                                                <option value="<?= $mk->id_mata_kuliah ?>"><?= $mk->nama_mata_kuliah ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                            <label for="simple-select-3">Jenis Bobot</label>
                                            <select class="form-control select2" name="id_bobot[]" required>
                                                <option value="">Pilih Bobot</option>
                                                <?php foreach($bobot as $b): ?>
                                                <option value="<?= $b->id_bobot ?>"><?= $b->jenis_bobot ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            </div>
                                    <div class="form-group col mt-4">
                                        <button class="btn btn-danger remove_item">Hapus Baris</button>
                                    </div>
                                </div>`);
                                $(".select2").select2({
                                    theme: "bootstrap4",
                                });
            let len = $(".append_item").length;
            if (len == 6) {
                Swal.fire({
                    icon: "warning",
                    text: "Data baris input yang dimasukan maximal hanya 6"
                })
                $(".append_item").last().remove();
            }
        });
        $(document).on('click', '.remove_item', function(e) {
            e.preventDefault();
            let row_item = $(this).parent().parent();
            $(row_item).remove();
        });
    });
</script>
<?php echo $this->include('sipema/sipema_partial/dashboard/footer');?>