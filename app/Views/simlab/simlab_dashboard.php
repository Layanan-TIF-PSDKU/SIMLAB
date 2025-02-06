<?php echo $this->include('simlab/simlab_partial/dashboard/header');?>
<?php echo $this->include('simlab/simlab_partial/dashboard/top_menu');?>
<?php echo $this->include('simlab/simlab_partial/dashboard/side_menu');?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- <h2 class="page-title">Form Layout</h2> -->
                <!-- <div class="row align-items-center mb-2"> -->
                <!-- <div class="col">
                        <h2 class="h5 page-title">Welcome!</h2>
                    </div> -->

                <!-- </div> -->
                <!-- <div class="card shadow mb-4">
                                   <div class="card-body">
                  </div>
                </div> -->
                <!-- </div> -->

                <div class="card shadow mb-4">
                    <div class="card-body text-center">
                        <a href="#!" class="avatar avatar-xl">
                            <img src="<?= base_url('../assets/assets/images/logouns.png') ?>" alt="">
                            <!-- <img src="./assets/avatars/face-4.jpg" alt="..." class="avatar-img rounded-circle"> -->
                        </a>
                        <p><span class="badge badge-pill badge-info">SIMLAB</span></p>
                        <div class="card-text my-2">
                            <strong class="h5 card-title">Selamat Datang, <?= user()->username; ?></strong>
                            <br>
                            <h6 class="text-muted"><strong>Sistem Informasi Manajemen Laboratorium D3 Teknik Informatika
                                    Universitas Sebelas Maret</strong></h6>
                        </div>
                        <div class="row align-items-center justify-content-center">
                            <div class="col-mb-4n">
                                <a href="<?=base_url('simlab/pengajuan-peminjaman/alat-laboratorium');?>"
                                    class="btn btn-sm btn-outline-info">Form Peminjaman Alat Laboratorium</a>
                                <a href="<?=base_url('simlab/pengajuan-peminjaman/ruang-laboratorium');?>"
                                    class="btn btn-sm btn-outline-info">Form Peminjaman Ruang Laboratorium</a>
                            </div>
                        </div>
                    </div> <!-- ./card-text -->
                </div> <!-- /.card -->

                <!-- <?php if (has_permission('laboran')):?>
<div class="alert alert-primary">
  Role : Laboran
</div>
  <?php endif;?> -->

            </div>
            <!-- .col-12 -->
        </div>
        <!-- .row -->
    </div>


</main>
<?php echo $this->include('simlab/simlab_partial/dashboard/footer');?>