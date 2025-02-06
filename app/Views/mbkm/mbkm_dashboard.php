<?php echo $this->include('mbkm/mbkm_partial/dashboard/header'); ?>
<?php if (has_permission('admin')): ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php elseif(has_permission('dosen') || has_permission('mahasiswa') || has_permission('koor-mbkm')): ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/side_menu') ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/top_menu'); ?>
<?php elseif(has_permission('mitra')) : ?>
<?= $this->include('mitra/mitra_partial/dashboard/top_menu'); ?>
<?= $this->include('mitra/mitra_partial/dashboard/side_menu'); ?>
<?php endif;?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row align-items-center mb-2">
                    <div class="col mb-4 mt-2">
                        <h3 class="h3 page-title">Selamat Datang di SIM MBKM,
                            <?= user()->username; ?> &#128522 </h3>
                        <div class="file-container border-top">
                            <div class="mt-3 mb-4">
                                <div class="file-container ">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <div class="card-title font-weight-bolder text-center">Alur Kegiatan
                                                MBKM</div>
                                            <ol>
                                                <li style="list:no-style;">Mahasiswa mengajukan kegiatan MBKM</li>
                                                <li style="list:no-style;">Dosen melakukan validasi ajuan kegiatan
                                                    MBKM
                                                </li>
                                                <li style="list:no-style;">Mahasiswa melanjutkan proses pendaftaran
                                                    jika ajuan telah disetujui</li>
                                                <li style="list:no-style;">Mahasiswa mengunduh berkas surat yang
                                                    telah diupload oleh admin</li>
                                                <li style="list:no-style;">Proses seleksi oleh masing - masing
                                                    mitra/instansi (bila ada)
                                                </li>
                                                <li style="list:no-style;">Apabila mahasiswa lolos pada semua
                                                    kegiatan yang didaftar, maka wajib memilih satu kegiatan</li>
                                                <li style="list:no-style;">Update mitra/instansi</li>
                                                <li style="list:no-style;">Upload LoA/bukti lolos</li>
                                                <li style="list:no-style;">Mengisi monitoring selama kegiatan</li>
                                                <li style="list:no-style;">Membuat Laporan Akhir</li>
                                            </ol>
                                        </div> <!-- .card-body -->
                                    </div> <!-- .card -->
                                </div> <!-- .card -->
                            </div> <!-- .card -->

                        </div>
                        <div class="file-container border-top">
                            <div class="mt-3">
                                <?php if(has_permission('dosen') || has_permission('mahasiswa')|| has_permission('koor-mbkm')) : ?>
                                <h5 class="mb-2">
                                    <div class="circle circle-sm bg-info-light">
                                        <span class="fe fe-info fe-16 text-white"> </span>
                                    </div> Informasi MBKM
                                </h5>

                                <p>Pengumuman/Informasi terkait MBKM Kampus Madiun</p>
                                <div class="row my-4">
                                    <?php foreach ($berkasInfo as $b) : ?>

                                    <div class="col-md-3">
                                        <!-- BERKAS -->

                                        <div class="card shadow text-center mb-4">
                                            <div class="card-body file">
                                                <div class="circle circle-md bg-primary-light">
                                                    <span class="fe fe-folder fe-24 text-white"></span>
                                                </div>
                                                <div class="card-text my-2">
                                                    <strong class="card-title my-0"><?= $b->nama_berkas ?></strong>
                                                </div>
                                                <a class="button mb-0 my-1"
                                                    href="<?=base_url("download-berkas/$b->id_berkas");?>">
                                                    <span class="btn mb-2 btn-outline-primary">Download</span>
                                                </a>
                                            </div> <!-- .card-body -->
                                        </div> <!-- .card -->

                                    </div> <!-- .col -->
                                    <?php endforeach ?>
                                </div> <!-- .col -->
                            </div> <!-- .col -->
                            <?php endif; ?>

                        </div> <!-- .col -->
                        <div class="file-container border-top">
                            <div class="mt-3">
                                <?php if(has_permission('dosen') || has_permission('mahasiswa')|| has_permission('koor-mbkm')) : ?>
                                <h5 class="mb-2">Berkas Pendaftaran MBKM</h5>
                                <p>Unduh berkas-berkas yang diperlukan untuk mendaftar kegiatan MBKM dibawah ini</p>
                                <div class="row my-4">
                                    <?php foreach ($berkasPendaftaran as $b) : ?>

                                    <div class="col-md-3">
                                        <!-- BERKAS -->

                                        <div class="card shadow text-center mb-4">
                                            <div class="card-body file">
                                                <div class="circle circle-md bg-primary-light">
                                                    <span class="fe fe-folder fe-24 text-white"></span>
                                                </div>
                                                <div class="card-text my-2">
                                                    <strong class="card-title my-0"><?= $b->nama_berkas ?></strong>
                                                </div>
                                                <a class="button mb-0 my-1"
                                                    href="<?=base_url("download-berkas/$b->id_berkas");?>">
                                                    <span class="btn mb-2 btn-outline-primary">Download</span>
                                                </a>
                                            </div> <!-- .card-body -->
                                        </div> <!-- .card -->

                                    </div> <!-- .col -->
                                    <?php endforeach ?>
                                </div> <!-- .col -->
                            </div> <!-- .col -->
                            <?php endif; ?>

                        </div> <!-- .col -->
                    </div>
                </div>
                <!-- .card-body -->
            </div>
            <!-- .card -->
        </div>
        <!-- .card -->
    </div>
    <!-- .col -->
    </div>




    </div>
    <!-- / .card-body -->
    </div>
    </div>
    <!-- / .card -->

    <!-- Striped rows -->
    </div>
    <!-- .row-->
    </div>
    <!-- .col-12 -->
    </div>
    <!-- .row -->
    </div>
    <!-- .container-fluid -->


</main>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer');?>