<?php echo $this->include('simta/simta_partial/dashboard/header');?>
<?php echo $this->include('simta/simta_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')) : ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
<?php echo $this->include('simta/simta_partial/dashboard/side_menu') ?>
<?php endif; ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Form Tambah Data Pengajuan Judul Tugas Akhir</h2>
                <div class="row my-4">
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title"></strong>
                            </div>
                            <div class="card-body">
                            <?php $validation = \Config\Services::validation();?>
                            <form method="POST" enctype="multipart/form-data" 
                            action="<?=base_url("simta/penilaianakhir/hasilakhir/" . $penilaianakhir->id_hasilakhir)?>">
                            <?=csrf_field(); ?>
                                <div class="form-group mb-3">
                                    <label for="address-wpalaceholder">Nilai Ujian Proposal</label>
                                    <input type="number" id="address-wpalaceholder" name="nilai_ujianproposal"
                                    class="form-control" placeholder="Silahkan Masukkan Nilai Ujian Proposal" value="<?=$nilai_ujianproposal?>" />
                                    <!-- Error Validation -->
                                    <?php if ($validation->getError('nilai_ujianproposal')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('nilai_ujianproposal');?>
                                        </div>
                                     <?php }?>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address-wpalaceholder">Nilai Seminar Hasil</label>
                                    <input type="number" id="address-wpalaceholder" name="nilai_seminarhasil"
                                    class="form-control" placeholder="Silahkan Masukkan Nilai Seminar Hasil" value="<?=$nilai_seminarhasil?>" />
                                    <!-- Error Validation -->
                                    <?php if ($validation->getError('nilai_seminarhasil')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('nilai_seminarhasil');?>
                                        </div>
                                    <?php }?>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address-wpalaceholder">Nilai Ujian Tugas Akhir</label>
                                    <input type="number" id="address-wpalaceholder" name="nilai_ujianta"
                                    class="form-control" placeholder="Silahkan Masukkan Nilai Ujian TA" value="<?=$nilai_ujianta?>"/>
                                    <!-- Error Validation -->
                                    <?php if ($validation->getError('nilai_ujianta')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('nilai_ujianta');?>
                                        </div>
                                    <?php }?>
                                </div>
                                <button class="btn btn-primary" type="submit">Tambah</button>
                                <a href="<?=base_url('simta/penilaianakhir');?>" class="btn btn-warning">Kembali</a>
                            </form>
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
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>