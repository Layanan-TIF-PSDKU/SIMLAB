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
                            <li class="breadcrumb-item active">Penggunaan Ruang Laboratorium</li>
                        </ol>
                    </div>
                </div>

                <!-- <h2 class="mb-2 page-title"><?=$title?></h2> -->
                <a href="<?=base_url('simlab/pengajuan-peminjaman/ruang-laboratorium/');?>"
                    class="btn  btn-outline-info btn-icon-split mb-3 mt-1">
                        <span class="fe fe-plus-circle"></span>&nbsp; Ajukan Peminjaman</a>
                <div class="row mb-2">
                    <!-- Small table -->
                    <div class="col-md-6">
                        <div class="card shadow text-center mb-4">
                            <div class="card-body p-5">
                                <span class="circle circle-md bg-primary-light">
                                    <i class="fe fe-calendar fe-24 text-white"></i>
                                </span>
                                <h3 class="h5 mt-4 text-black">Jadwal Praktikum</h3>
                                <p class="text-black mb-4">Data Penggunaan Ruang untuk Jadwal Mata Kuliah Praktikum</p>
                                <a href="<?=base_url('simlab/penggunaan-ruang-laboratorium/pilih-ruang/praktikum/')?>"
                                    class="btn bg-primary-light text-white">Pilih<i
                                        class="fe fe-arrow-right fe-16 ml-2"></i></a>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .col-md-->
                    <!--  -->
                    <div class="col-md-6">
                        <div class="card shadow text-center mb-4">
                            <div class="card-body p-5">
                                <span class="circle circle-md bg-primary-light">
                                    <i class="fe fe-calendar fe-24 text-white"></i>
                                </span>
                                <h3 class="h5 mt-4 text-black">Data Peminjaman Ruang</h3>
                                <p class="text-black mb-4">Data Penggunaan Ruang Diluar Jadwal Mata Kuliah Praktikum</p>
                                <a href="<?=base_url('simlab/penggunaan-ruang-laboratorium/pilih-ruang/peminjaman/')?>"
                                    class="btn bg-primary-light text-white">Pilih<i
                                        class="fe fe-arrow-right fe-16 ml-2"></i></a>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .col-md-->


                </div> <!-- end section -->
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->

</main>

<?=$this->include('simlab/simlab_partial/dashboard/footer')?>