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
                <h2 class="page-title">Form Edit Tips Karir</h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-10">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url('tracer/tips_karir/update/' . $tips_karir->id_tips_karir) ?>">
                                    <div class="form-group mb-9">
                                        <label for="address-wpalaceholder">Judul</label>
                                        <input type="text" id="address-wpalaceholder" name="judul" class="form-control" placeholder="Masukkan Pertanyaan" value="<?= $tips_karir->judul ?>" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('judul')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('judul'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-9">
                                        <label for="example-textarea">Deskripsi</label>
                                        <textarea class="form-control" id="example-textarea" name="deskripsi" placeholder="Masukan Deskripsi"><?= $tips_karir->deskripsi ?></textarea>
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('deskripsi')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('deskripsi'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary" type="submit">Edit</button>
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
<script src="//cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'deskripsi' );
</script>
<?php echo $this->include('sipema/sipema_partial/dashboard/footer');?>