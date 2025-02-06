<?php echo $this->include('mbkm/mbkm_partial/dashboard/header'); ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/top_menu'); ?>
<?php if (has_permission('admin')): ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else: ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/side_menu') ?>
<?php endif;?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Data Berkas Informasi dan Pendaftaran MBKM</h2>
                        <p class="card-text">
                            Data berkas informasi dan pendaftaran MBKM Kampus Madiun
                        </p>
                    </div>

                    <?php if(has_permission('admin')) : ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a
                                    href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                            </li>
                            <li class="breadcrumb-item active"><small>Berkas MBKM</small></li>
                        </ol>
                    </div>
                    <?php elseif(has_permission('dosen')) : ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a href="<?= base_url('mbkm') ?>"><small>Dashboard</small></a>
                            </li>
                            <li class="breadcrumb-item active"><small>Berkas MBKM</small></li>
                        </ol>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <a href="<?=base_url('mbkm/berkas/tambah');?>" class="btn btn-primary mb-3">Tambah</a>
                                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                            role="tab" aria-controls="home" aria-selected="true">Informasi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile"
                                            role="tab" aria-controls="profile" aria-selected="false">Pendaftaran</a>
                                    </li>

                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel"
                                        aria-labelledby="home-tab">
                                        <div class="table-responsive">
                                            <table class="table datatables" id="dataTable-1">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Berkas</th>
                                                        <th>File</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                            $no = 1;
                                            foreach ($berkasInfo as $a) :
                                            ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?=$a->nama_berkas?></td>

                                                        <td>
                                                            <?php if ($a->file_berkas == ''): ?>
                                                            <span class="badge badge-danger">Belum upload</span>
                                                            <?php else: ?>
                                                            <a class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                                href="<?=base_url("mbkm/berkas/download-berkas/$a->id_berkas");?>">
                                                                <span
                                                                    class="fe fe-download-cloud fe-16 align-middle"></span>
                                                            </a>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                                type="button" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                <span class="text-muted sr-only">Action</span>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item"
                                                                    href="<?=base_url("mbkm/berkas/edit/$a->id_berkas");?>">Edit</a>
                                                                <form method="POST"
                                                                    action="<?=base_url("mbkm/berkas/hapus/$a->id_berkas");?>">
                                                                    <input name="_method" type="hidden" value="DELETE">
                                                                    <button type="submit"
                                                                        class="dropdown-item remove-item-btn"
                                                                        data-toggle="tooltip" title='Delete'><i
                                                                            class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                        Delete</button>
                                                                </form>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                    <?php endforeach?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel"
                                        aria-labelledby="profile-tab">
                                        <div class="table-responsive">
                                            <table class="table datatables" id="dataTable-1">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Berkas</th>
                                                        <th>File</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                            $no = 1;
                                            foreach ($berkasPendaftaran as $a) :
                                            ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?=$a->nama_berkas?></td>

                                                        <td>
                                                            <?php if ($a->file_berkas == ''): ?>
                                                            <span class="badge badge-danger">Belum upload</span>
                                                            <?php else: ?>
                                                            <a class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                                href="<?=base_url("mbkm/berkas/download-berkas/$a->id_berkas");?>">
                                                                <span
                                                                    class="fe fe-download-cloud fe-16 align-middle"></span>
                                                            </a>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                                type="button" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                <span class="text-muted sr-only">Action</span>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item"
                                                                    href="<?=base_url("mbkm/berkas/edit/$a->id_berkas");?>">Edit</a>
                                                                <form method="POST"
                                                                    action="<?=base_url("mbkm/berkas/hapus/$a->id_berkas");?>">
                                                                    <input name="_method" type="hidden" value="DELETE">
                                                                    <button type="submit"
                                                                        class="dropdown-item remove-item-btn"
                                                                        data-toggle="tooltip" title='Delete'><i
                                                                            class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                        Delete</button>
                                                                </form>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                    <?php endforeach?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end section -->
            </div>
            <!-- .col-12 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container-fluid -->
</main>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>