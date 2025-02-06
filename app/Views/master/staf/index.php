<?php if(in_groups('pimpinan')) : ?>
    <?= $this->include('master_partial/dashboard/header');?>
    <?= $this->include('sipema/sipema_partial/dashboard/top_menu');?>
    <?= $this->include('sipema/sipema_partial/dashboard/side_menu');?>
<?php else: ?>
    <?= $this->include('master_partial/dashboard/header');?>
    <?= $this->include('master_partial/dashboard/top_menu');?>
    <?= $this->include('master_partial/dashboard/side_menu');?>
<?php endif; ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Halaman Pengelolaan Data Staf</h2>
                <?php
                    if(session()->getFlashData('message')){
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashData('message') ?>
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
                                <!-- table -->
                                <?php if(has_permission('pimpinan')) : ?>
                                <?php else : ?>
                                <a href="<?= base_url('staf/tambah') ?>" class="btn btn-primary mb-3">Tambah</a>
                                <?php endif; ?>
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIP</th>
                                            <th>Nomor Telepon</th>
                                            <th>Alamat</th>
                                            <th>Jenis</th>
                                            <?php if(has_permission('pimpinan')) : ?>
                                            <?php else : ?>
                                            <th>Action</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($staf as $stf) {                                        
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $stf->nama; ?></td>
                                            <td><?= $stf->nip; ?></td>
                                            <td><?= $stf->no_telp; ?></td>
                                            <td><?= $stf->alamat; ?></td>
                                            <td><?= $stf->jenis; ?></td>
                                            <?php if(has_permission('pimpinan')) : ?>
                                            <?php else : ?>
                                            <td>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="<?= base_url("staf/edit/".$stf->id_staf); ?>">Edit</a>
                                                    <a class="dropdown-item"
                                                        href="<?= base_url("staf/ubah-password/".$stf->id_staf); ?>">Ubah
                                                        Password</a>
                                                    <form method="POST"
                                                        action="<?= base_url("staf/hapus/".$stf->id_staf); ?>">
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="submit" class="dropdown-item remove-item-btn"
                                                            data-toggle="tooltip" title='Delete'><i
                                                                class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                            Delete</button>
                                                    </form>
                                            </td>
                                            <?php endif; ?>
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