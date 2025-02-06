<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('kmm/kmm_partial/dashboard/top_menu'); ?>
<?php if(has_permission('admin')): ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
<?php else: ?>
<?= $this->include('kmm/kmm_partial/dashboard/side_menu'); ?>
<?php endif; ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-8">
                        <h2 class="mt-2 page-title">Halaman Pengelolaan Indikator Penilaian KMM</h2>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <?php if(has_permission('admin')): ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <?php else: ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('kmm') ?>">Dashboard</a></li>
                            <?php endif; ?>
                            <li class="breadcrumb-item active">KMM</a></li>
                            <li class="breadcrumb-item active">Indikator Penilaian KMM</li>
                        </ol>
                    </div>
                </div>
                <div class="row mt-3">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <a href="<?= base_url('kmm/pertanyaan-penilaian/tambah'); ?>"
                                    class="btn btn-primary mb-3">Tambah</a>
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Indikator Penilaian</th>
                                            <th>Penilai</th>
                                            <th>Nilai Maksimum</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $no = 1;
                                            foreach ($pertanyaan as $p) {
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $p->pertanyaan; ?></td>
                                            <td class="text-center"><?= ucfirst($p->jenis_pertanyaan); ?></td>
                                            <td class="text-center"><?= $p->nilai_maks; ?></td>
                                            <td>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="<?= base_url('kmm/pertanyaan-penilaian/edit/' . $p->id_pertanyaan); ?>">Edit</a>
                                                    <form method="POST"
                                                        action="<?= base_url('kmm/pertanyaan-penilaian/hapus/' . $p->id_pertanyaan); ?>">
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

<?= $this->include('master_partial/dashboard/footer'); ?>