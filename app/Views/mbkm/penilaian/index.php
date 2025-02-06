<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('mbkm/mbkm_partial/dashboard/top_menu'); ?>
<?php if(has_permission('admin')) : ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
<?php elseif(has_permission('dosen') || has_permission('koor-mbkm')) : ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/side_menu') ?>
<?php elseif(has_permission('mitra')) : ?>
<?= $this->include('mitra/mitra_partial/dashboard/side_menu'); ?>
<?php endif; ?>


<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Penilaian UTS dan UAS Mahasiswa MBKM</h2>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-md-6">
                        <div class="card shadow text-center mb-4">
                            <div class="card-body p-5">
                                <span class="circle circle-md bg-primary-light">
                                    <i class="fe fe-edit-2 fe-24 text-white"></i>
                                </span>
                                <h3 class="h4 mt-4 mb-1 text-black">Penilaian UTS</h3>
                                <p class="text-black mb-4">Penilaian UTS mahasiswa MBKM</p>
                                <a href=<?=base_url("mbkm/penilaian/uts")?>
                                    class="btn btn-lg bg-primary-light text-white">Pilih<i
                                        class="fe fe-arrow-right fe-16 ml-2"></i></a>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .col-md-->
                    <div class="col-md-6">
                        <div class="card shadow text-center mb-4">
                            <div class="card-body p-5">
                                <span class="circle circle-md bg-primary-light">
                                    <i class="fe fe-edit-2 fe-24 text-white"></i>
                                </span>
                                <h3 class="h4 mt-4 mb-1 text-black">Penilaian UAS</h3>
                                <p class="text-black mb-4">Penilaian UAS mahasiswa MBKM</p>
                                <a href=<?=base_url("mbkm/penilaian/uas")?>
                                    class="btn btn-lg bg-primary-light text-white">Pilih<i
                                        class="fe fe-arrow-right fe-16 ml-2"></i></a>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .col-md-->
                    <?php if(has_permission('dosen') || has_permission('koor-mbkm')) : ?>
                    <div class="col-md-6">
                        <div class="card shadow text-center mb-4">
                            <div class="card-body p-5">
                                <span class="circle circle-md bg-primary-light">
                                    <i class="fe fe-edit-2 fe-24 text-white"></i>
                                </span>
                                <h3 class="h4 mt-4 mb-1 text-black">Nilai Akhir</h3>
                                <p class="text-black mb-4">Nilai hasil dari perhitungan nilai UTS dan UAS</p>
                                <a href=<?=base_url("mbkm/penilaian/akhir")?>
                                    class="btn btn-lg bg-primary-light text-white">Pilih<i
                                        class="fe fe-arrow-right fe-16 ml-2"></i></a>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .col-md-->
                    <?php endif; ?>
                </div>
                <!-- .col-12 -->
            </div>
            <!-- .row -->
        </div>
        <!-- .container-fluid -->
</main>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>