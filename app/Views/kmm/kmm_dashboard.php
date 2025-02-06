<?php echo $this->include('kmm/kmm_partial/dashboard/header');?>
<?php echo $this->include('kmm/kmm_partial/dashboard/top_menu');?>
<?php echo $this->include('kmm/kmm_partial/dashboard/side_menu') ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <?php if(has_permission('koor-kmm')): ?>
            <div class="col-12">
                <div class="alert alert-info" role="alert"><span class="fe fe-smile fe-16 mr-2"></span><b>Selamat Datang
                        Koordinator KMM di Sistem Informasi Prodi D3 Teknik Informatika Madiun</b></div>
            </div>
            <?php endif; ?>
            <div class="col-12">
                <div class="row align-items-center mb-2">
                    <div class="col mb-4 mt-2">
                        <div class="file-container">
                            <div class="mt-3">
                                <h5>Dashboard</h5>
                                <div class="row my-3">
                                    <div class="col-md-6">
                                        <div class="card shadow text-center">
                                            <div class="card-body">
                                                <div class="card-title font-weight-bolder">Dokumen Pendukung
                                                    Kuliah Magang Mahasiswa (KMM)</div>
                                                <div class="row">
                                                    <?php foreach ($berkas as $b) : ?>
                                                    <div class="col-md-6">
                                                        <div class="card shadow text-center mb-3">
                                                            <div class="card-body">
                                                                <div class="circle circle-sm bg-secondary my-1">
                                                                    <span class="fe fe-folder fe-16 text-white"></span>
                                                                </div>
                                                                <div class="card-text my-2">
                                                                    <strong
                                                                        class="card-title my-0"><?= $b->ket_berkas ?></strong>
                                                                </div>
                                                                <a class="btn btn-sm btn-outline-primary"
                                                                    href="<?=base_url("kmm/berkas/download/" . $b->id_berkas);?>">Download
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endforeach ?>
                                                </div>
                                            </div> <!-- .card-body -->
                                        </div> <!-- .card -->
                                    </div> <!-- .col -->

                                    <div class="col-md-6">
                                        <div class="card shadow">
                                            <div class="card-body">
                                                <div class="card-title font-weight-bolder text-center">Alur Kegiatan
                                                    Kuliah Magang Mahasiswa (KMM)</div>
                                                <ol>
                                                    <li style="list:no-style;">Pengajuan Proposal KMM</li>
                                                    <li style="list:no-style;">Pengajuan Surat Pengantar KMM melalui
                                                        <a href="https://layanan.vokasi.uns.ac.id/"
                                                            target="_blank">layanan.vokasi.uns.ac.id</a>
                                                    </li>
                                                    <li style="list:no-style;">Mendaftar KMM</li>
                                                    <li style="list:no-style;">Proses Seleksi KMM oleh masing -
                                                        masing mitra/instansi (bila
                                                        ada)</li>
                                                    <li style="list:no-style;">Upload LoA</li>
                                                    <li style="list:no-style;">Mengisi Logbook KMM</li>
                                                    <li style="list:no-style;">Membuat Laporan Akhir KMM</li>
                                                    <li style="list:no-style;">Mendaftar Seminar KMM</li>
                                                </ol>
                                            </div> <!-- .card-body -->
                                        </div> <!-- .card -->
                                    </div> <!-- .col -->
                                </div> <!-- .col -->
                            </div> <!-- .col -->
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
    <div class="">
        <h2 class=""> Manual Book</h2>
    </div>



    <i class=" fe fe-book-open fa-2x">
    </i>




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
<?php echo $this->include('kmm/kmm_partial/dashboard/footer');?>