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
                <h2 class="page-title">Form Edit Informasi Magang</h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-10">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url('tracer/informasi_magang/update/' . $informasi_magang->id_informasi_magang) ?>" enctype="multipart/form-data">
                                    <div class="form-group mb-9">
                                        <label for="address-wpalaceholder">Nama Perusahaan</label>
                                        <input type="text" id="address-wpalaceholder" name="nama_perusahaan" class="form-control" placeholder="Masukkan Nama Perusahaan" value="<?= $informasi_magang->nama_perusahaan ?>" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('nama_perusahaan')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nama_perusahaan'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-9">
                                        <label for="address-wpalaceholder">Link Perusahaan</label>
                                        <input type="text" id="address-wpalaceholder" name="link_pt" class="form-control" placeholder="Masukkan Link Perusahaan" value="<?= $informasi_magang->link_pt ?>" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('link_pt')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('link_pt'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-9">
                                        <label for="address-wpalaceholder">Posisi Lowongan</label>
                                        <input type="text" id="address-wpalaceholder" name="posisi_magang" class="form-control" placeholder="Masukkan Posisi Lowongan" value="<?= $informasi_magang->posisi_magang ?>" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('posisi_magang')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('posisi_magang'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-9">
                                        <label for="example-textarea">Persyaratan Magang</label>
                                        <textarea class="form-control" id="example-textarea" name="persyaratan_magang"><?= $informasi_magang->persyaratan_magang ?></textarea>
                                        <?php if ($validation->getError('persyaratan_magang')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('persyaratan_magang'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-9">
                                        <label for="address-wpalaceholder">Batas Lowongan</label>
                                        <div class="md-form md-outline input-with-post-icon datepicker">
                                            <input placeholder="Masukan Tanggal" name="batas_akhir" type="date" id="example" class="form-control" value="<?= $informasi_magang->batas_akhir ?>">
                                        </div>
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('batas_akhir')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('batas_akhir'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <!-- <div class="form-group mb-9">
                                        <label for="customFile">Poster</label>
                                        <input type="file" class="form-control" name="poster_magang"> -->
                                        <!-- Error Validation -->
                                        <!-- <?php if ($validation->getError('poster_magang')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('poster_magang'); ?>
                                            </div>
                                        <?php } ?>
                                    </div> -->
                                    <div class="text-right">
                                        <button class="btn btn-primary" type="submit">Edit</button>
                                        <a href="<?= base_url('tracer/informasi_magang'); ?>" class="btn btn-warning text-light">Kembali</a>
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
    CKEDITOR.replace( 'persyaratan_magang' );
</script>
<?php echo $this->include('sipema/sipema_partial/dashboard/footer');?>