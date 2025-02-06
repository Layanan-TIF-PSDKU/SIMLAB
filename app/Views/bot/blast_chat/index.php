<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php echo $this->include('master_partial/dashboard/side_menu'); ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Blast Chat</h2>
                    </div>
                    <?php if(has_permission('admin')) : ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a
                                    href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                            </li>
                            <li class="breadcrumb-item active"><small>Blast Chat</small></li>
                        </ol>
                    </div>
                    <?php endif;?>
                </div>
                <div class="row my-4">
                <div class="col-md-6">
                  <div class="card shadow text-center mb-4">
                    <div class="card-body p-5">
                      <span class="circle circle-md bg-primary-light">
                        <i class="fe fe-mail fe-24 text-white"></i>
                      </span>
                      <h3 class="h4 mt-4 mb-1 text-black">Kirim Email</h3>
                      <p class="text-black mb-4">Kirim Pesan Melalui Email Customize Text Atau Format HTML</p>
                      <a href=<?=base_url("bot/blast_chat/kirim_email")?> class="btn btn-lg bg-primary-light text-white">Pilih<i class="fe fe-arrow-right fe-16 ml-2"></i></a>
                    </div> <!-- .card-body -->
                  </div> <!-- .card -->
                </div> <!-- .col-md-->
                <div class="col-md-6">
                  <div class="card shadow text-center mb-4">
                    <div class="card-body p-5">
                      <span class="circle circle-md bg-primary-light">
                        <i class="fe fe-message-circle fe-24 text-white"></i>
                      </span>
                      <h3 class="h4 mt-4 mb-1 text-black">Kirim Pesan Multiplatform</h3>
                      <p class="text-black mb-4">Kirim Pesan Ke Staff/Mahasiswa Sesuai Platform Yang Dibutuhkan </p>
                      <a href=<?=base_url("bot/blast_chat/instan/pilih_penerima")?> class="btn btn-lg bg-primary-light text-white">Pilih<i class="fe fe-arrow-right fe-16 ml-2"></i></a>
                    </div> <!-- .card-body -->
                  </div> <!-- .card -->
                </div> <!-- .col-md-->
                <div class="col-md-6">
                  <div class="card shadow text-center mb-4">
                    <div class="card-body p-5">
                      <span class="circle circle-md bg-primary-light">
                        <i class="fe fe-calendar fe-24 text-white"></i>
                      </span>
                      <h3 class="h4 mt-4 mb-1 text-black">Kirim Pesan Multiplatform (Terjadwal)</h3>
                      <p class="text-black mb-4">Kirim Pesan Ke Staff/Mahasiswa Sesuai Platform Dan Waktu Pengiriman Yang Terjadwal </p>
                      <a href=<?=base_url("bot/blast_chat/terjadwal/pilih_penerima")?> class="btn btn-lg bg-primary-light text-white">Pilih<i class="fe fe-arrow-right fe-16 ml-2"></i></a>
                    </div> <!-- .card-body -->
                  </div> <!-- .card -->
                </div> <!-- .col-md-->
                <div class="col-md-6">
                  <div class="card shadow text-center mb-4">
                    <div class="card-body p-5">
                      <span class="circle circle-md bg-primary-light">
                        <i class="fe fe-radio fe-24 text-white"></i>
                      </span>
                      <h3 class="h4 mt-4 mb-1 text-black">Kirim Pesan Multiplatform (Broadcast)</h3>
                      <p class="text-black mb-4">Kirim Pesan Ke Semua Staff/Mahasiswa Sesuai Platform Yang Dipilih </p>
                      <a href=<?=base_url("bot/blast_chat/broadcast")?> class="btn btn-lg bg-primary-light text-white">Pilih<i class="fe fe-arrow-right fe-16 ml-2"></i></a>
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
<?php echo $this->include('bot/bot_partial/dashboard/footer'); ?>