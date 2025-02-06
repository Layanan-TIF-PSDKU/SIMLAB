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
                <div class="row mb-2">
                    <!-- Small table -->
                    <?php foreach ($dataruanglab as $rglab): ?>
                    <div class="col-md-4">
                        <div class="card shadow text-center mb-4">
                            <div class="card-body p-5">
                                <span class="circle circle-md bg-primary-light">
                                    <i class="fe fe-navigation fe-24 text-white"></i>
                                </span>
                                <h3 class="h5 mt-4 text-black"><?=$rglab->nama_ruang?></h3>
                                <a href="<?=base_url('simlab/penggunaan-ruang-laboratorium/lihat/'. $rglab->id_ruang)?>"
                                    class="btn bg-primary-light text-white">Pilih Ruang<i
                                        class="fe fe-arrow-right fe-16 ml-2"></i></a>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .col-md-->
                    <?php endforeach?>
                </div> <!-- end section -->
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->

</main>

<?=$this->include('simlab/simlab_partial/dashboard/footer')?>