<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('master_partial/dashboard/top_menu'); ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
    <style>
        :root {
        --warna: <?php echo $cms->warna_bg ?>;
        }
    </style>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Halaman Data Informasi Magang</h2>
                <?php
                    if(session()->getFlashData('status')){
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashData('status') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                    }
                    ?>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <a href="<?= base_url('tracer/informasi_magang/tambah'); ?>" class="btn btn-primary mb-3">Tambah</a>
                                <!-- table -->
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Perusahaan</th>
                                            <th>Posisi</th>
                                            <th>Link Perusahaan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($informasi_magang as $im): ?>
                                        <tr>
                                            <td><?=$no++ ?></td>
                                            <td><?=$im->nama_perusahaan ?></td>
                                            <td><?=$im->posisi_magang ?></td>
                                            <td>
                                                <!-- <img src="<?= base_url("../tracer_assets/magang/$im->poster_magang") ?>" width="100"> -->
                                                <a href="<?=$im->link_pt ?>"><?=$im->link_pt ?></a>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="<?= base_url("tracer/informasi_magang/edit/$im->id_informasi_magang"); ?>">Edit</a>
                                                    <form method="POST"
                                                        action="<?= base_url("tracer/informasi_magang/hapus/$im->id_informasi_magang"); ?>">
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="submit" class="dropdown-item remove-item-btn"
                                                            data-toggle="tooltip" title='Delete'><i
                                                                class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                            Delete</button>
                                                    </form>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- simple table -->
                </div>
                <!-- end section -->
            </div>
            <!-- .col-12 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container-fluid -->
</main>
<?= $this->include('master_partial/dashboard/footer'); ?>