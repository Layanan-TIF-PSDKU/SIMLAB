<?= $this->include('master_partial/dashboard/header');?>
<?= $this->include('master_partial/dashboard/top_menu');?>
<?= $this->include('master_partial/dashboard/side_menu');?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Halaman Pengelolaan Data Mitra</h2>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <a href="<?= base_url('mitra/tambah') ?>" class="btn btn-primary mb-3">Tambah</a>
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Instansi</th>
                                            <th>Pimpinan</th>
                                            <th>Mentor</th>
                                            <th>Alamat</th>
                                            <th>Nomor Telepon</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($mitra as $mtr) {                                        
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $mtr->nama_instansi; ?></td>
                                            <td><?= $mtr->nama_pimpinan; ?></td>
                                            <td><?= $mtr->nama_mentor; ?></td>
                                            <td><?= $mtr->alamat; ?></td>
                                            <td><?= $mtr->no_telp; ?></td>
                                            <td>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="<?= base_url("mitra/edit/".$mtr->id_mitra); ?>">Edit</a>
                                                    <a class="dropdown-item"
                                                        href="<?= base_url("mitra/ubah-password/".$mtr->id_mitra); ?>">Ubah
                                                        Password</a>
                                                    <form method="POST"
                                                        action="<?= base_url("mitra/hapus/".$mtr->id_mitra); ?>">
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="submit" class="dropdown-item remove-item-btn"
                                                            data-toggle="tooltip" title='Delete'><i
                                                                class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                            Delete</button>
                                                    </form>
                                            </td>
                                        </tr>
                                        <?php } ?>
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
<?= $this->include('master_partial/dashboard/footer');?>