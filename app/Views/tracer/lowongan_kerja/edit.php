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
                <h2 class="page-title">Form Edit Lowongan Kerja</h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-10">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url('tracer/lowongan_kerja/update/' . $lowongan_kerja->id_lowongan_kerja) ?>" enctype="multipart/form-data">
                                    <div class="form-group mb-9">
                                        <label for="address-wpalaceholder">Nama Perusahaan</label>
                                        <input type="text" id="address-wpalaceholder" name="nama_perusahaan" class="form-control" placeholder="Masukkan Nama Perusahaan" value="<?= $lowongan_kerja->nama_perusahaan ?>" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('nama_perusahaan')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nama_perusahaan'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-9">
                                        <label for="address-wpalaceholder">Link Website Perusahaan</label>
                                        <input type="text" id="address-wpalaceholder" name="link_pt" class="form-control" placeholder="Masukkan Link Perusahaan" value="<?= $lowongan_kerja->link_pt ?>" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('link_pt')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('link_pt'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-9">
                                        <label for="address-wpalaceholder">Posisi Lowongan</label>
                                        <input type="text" id="address-wpalaceholder" name="posisi_lowongan" class="form-control" placeholder="Masukkan Posisi Lowongan" value="<?= $lowongan_kerja->posisi_lowongan ?>" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('posisi_lowongan')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('posisi_lowongan'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-9">
                                        <label for="example-textarea">Persyaratan</label>
                                        <textarea class="form-control" id="example-textarea" name="persyaratan"><?= $lowongan_kerja->persyaratan ?></textarea>
                                        <?php if ($validation->getError('persyaratan')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('persyaratan'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-9">
                                        <label for="address-wpalaceholder">Batas Lowongan</label>
                                        <div class="md-form md-outline input-with-post-icon datepicker">
                                            <input placeholder="Masukan Tanggal" name="batas_akhir" type="date" id="example" class="form-control" value="<?= $lowongan_kerja->batas_akhir ?>">
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
                                        <input type="file" class="form-control" name="poster"> -->
                                        <!-- Error Validation -->
                                        <!-- <?php if ($validation->getError('poster')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('poster'); ?>
                                            </div>
                                        <?php } ?>
                                    </div> -->
                                    <div class="text-right">
                                        <button class="btn btn-primary" type="submit">Edit</button>
                                        <a href="<?= base_url('tracer/lowongan_kerja'); ?>" class="btn btn-warning text-light">Kembali</a>
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
    CKEDITOR.replace( 'persyaratan' );
</script>
<?php echo $this->include('sipema/sipema_partial/dashboard/footer');?>