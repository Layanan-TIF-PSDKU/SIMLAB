<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('master_partial/dashboard/top_menu'); ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
    <style>
        :root {
        --warna: <?php echo $cms->warna_bg ?>;
        }
    </style>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Form Tambah FAQ</h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-10">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url("tracer/faq/simpan") ?>">
                                    <div class="form-group mb-9">
                                        <label for="address-wpalaceholder">Pertanyaan</label>
                                        <input type="text" id="address-wpalaceholder" name="pertanyaan" class="form-control" placeholder="Masukkan Pertanyaan" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('pertanyaan')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('pertanyaan'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-9">
                                        <label for="address-wpalaceholder">Jawaban</label>
                                        <input type="text" id="address-wpalaceholder" name="jawaban" class="form-control" placeholder="Masukkan Jawaban" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('jawaban')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('jawaban'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary" type="submit">
                                            Tambah
                                        </button>
                                        <a href="<?= base_url('tracer/faq'); ?>" class="btn btn-warning text-light">Kembali</a>
                                    </div>
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
</main>
<?php echo $this->include('tracer/footer');?>