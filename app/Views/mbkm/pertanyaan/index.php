<?php echo $this->include('mbkm/mbkm_partial/dashboard/header'); ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/top_menu'); ?>
<?php if (has_permission('admin')): ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else: ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/side_menu') ?>
<?php endif;?><main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Indikator Penilaian</h2>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-md-6">
                        <div class="card shadow text-center mb-4">
                            <div class="card-body p-5">
                                <span class="circle circle-md bg-primary-light">
                                    <i class="fe fe-bookmark fe-24 text-white"></i>
                                </span>
                                <h3 class="h4 mt-4 mb-1 text-black">Data Pembobotan Nilai</h3>
                                <p class="text-black mb-4">Kelola data pembobotan penilaian UTS dan UAS</p>
                                <a href=<?=base_url("mbkm/bobot")?>
                                    class="btn btn-lg bg-primary-light text-white">Pilih<i
                                        class="fe fe-arrow-right fe-16 ml-2"></i></a>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .col-md-->
                    <div class="col-md-6">
                        <div class="card shadow text-center mb-4">
                            <div class="card-body p-5">
                                <span class="circle circle-md bg-primary-light">
                                    <i class="fe fe-file-text fe-24 text-white"></i>
                                </span>
                                <h3 class="h4 mt-4 mb-1 text-black">Data Pertanyaan UTS</h3>
                                <p class="text-black mb-4">Kelola data soal pertanyaan UTS</p>
                                <a href=<?=base_url("mbkm/pertanyaan/uts")?>
                                    class="btn btn-lg bg-primary-light text-white">Pilih<i
                                        class="fe fe-arrow-right fe-16 ml-2"></i></a>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .col-md-->
                    <div class="col-md-6">
                        <div class="card shadow text-center mb-4">
                            <div class="card-body p-5">
                                <span class="circle circle-md bg-primary-light">
                                    <i class="fe fe-file-text fe-24 text-white"></i>
                                </span>
                                <h3 class="h4 mt-4 mb-1 text-black">Data Pertanyaan UAS</h3>
                                <p class="text-black mb-4">Kelola data soal pertanyaan UAS</p>
                                <a href=<?=base_url("mbkm/pertanyaan/uas")?>
                                    class="btn btn-lg bg-primary-light text-white">Pilih<i
                                        class="fe fe-arrow-right fe-16 ml-2"></i></a>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .col-md-->
                </div>
                <!-- .col-12 -->
            </div>
            <!-- .row -->
        </div>
        <!-- .container-fluid -->
</main>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>