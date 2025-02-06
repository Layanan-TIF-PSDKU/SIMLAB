<?=$this->include('simlab/simlab_partial/dashboard/header')?>
<?=$this->include('simlab/simlab_partial/dashboard/top_menu')?>
<?=$this->include('simlab/simlab_partial/dashboard/side_menu')?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- Breadcrumbs -->
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Halaman <?=$title?></h2>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a href="<?=base_url('simlab')?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Laporan</li>
                        </ol>
                    </div>
                </div>
                <!-- Small table -->
                <div class="card shadow">
                    <div class="accordion accordion-boxed" id="accordion2">
                        <div class="card shadow">
                            <div class="card-header" id="headingOne">
                                <a role="button" href="#collapseOne" data-toggle="collapse" data-target="#collapseOne"
                                    aria-expanded="false" aria-controls="collapseOne">
                                    <strong>Laporan Pencatatan</strong>
                                </a>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordion2">
                                <div class="card-body">
                                    <span><a href="<?=base_url('simlab/laporan/alat-masuk/')?>">1. Alat Laboratorium
                                            Masuk</a></span>
                                    <br>
                                    <span><a href="<?=base_url('simlab/laporan/alat-rusak/')?>">2. Alat Laboratorium
                                            Rusak</a></span>
                                    <br>
                                    <span><a href="<?=base_url('simlab/laporan/penghapusan-aset/')?>">3. Penghapusan
                                            Aset</a></span>
                                    <br>
                                    <span><a href="<?=base_url('simlab/laporan/perawatan-alat/')?>">4. Perawatan Alat
                                            Laboratorium</a></span>
                                    <br>
                                    <span><a href="<?=base_url('simlab/laporan/jadwal-praktikum/')?>">5. Penggunaan
                                            Ruang Laboratorium (Praktikum)</a></span>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow">
                            <div class="card-header" id="headingTwo">
                                <a role="button" href="#collapseTwo" data-toggle="collapse" data-target="#collapseTwo"
                                    aria-expanded="false" aria-controls="collapseTwo">
                                    <strong>Laporan Peminjaman</strong>
                                </a>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordion2">
                                <div class="card-body">
                                    <span><a href="<?=base_url('simlab/laporan/peminjaman-alat/')?>">1. Peminjaman Alat Laboratorium</a></span>
                                    <br>
                                    <span><a href="<?=base_url('simlab/laporan/peminjaman-ruang/')?>">2. Peminjaman Ruang Laboratorium</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    </div> <!-- .col-12 -->
    </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</main>

<?=$this->include('simlab/simlab_partial/dashboard/footer')?>