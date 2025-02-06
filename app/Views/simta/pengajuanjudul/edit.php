<?php echo $this->include('simta/simta_partial/dashboard/header'); ?>
<?php echo $this->include('simta/simta_partial/dashboard/top_menu'); ?>
<?php if (has_permission('admin')): ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else: ?>
<?php echo $this->include('simta/simta_partial/dashboard/side_menu') ?>
<?php endif;?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="mt-2 page-title">Halaman Edit Data Pengajuan Judul Tugas Akhir</h2>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Edit Pengajuan Judul</li>
                            </ol>
                        </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Edit Pengajuan Judul</li>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <!-- table -->
                                <form method="POST" action="<?= base_url('simta/pengajuanjudul/update/' . $pengajuanjudul->id_pengajuanjudul); ?>"
                                    enctype="multipart/form-data">
                                    <?= csrf_field(); ?>
                                    <?php if(has_permission('admin') || has_permission('mahasiswa')) : ?>
                                    <div class="form-group mb-3">
                                        <label for="simple-select1">Nama Mahasiswa<span class="text-danger">*</span></label>
                                        <select name="id_mhs"
                                            class="form-control select2 <?= ($validation->hasError('id_mhs')) ? 'is-invalid' : ''; ?>">
                                            <option>Pilih Mahasiswa</option>
                                            <?php foreach ($mahasiswa as $m) : ?>
                                            <option value="<?= $m->id_mhs ?>"
                                                <?= ($pengajuanjudul->id_mhs) == $m->id_mhs ? 'selected' : '' ?>><?= $m->nama ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <?php else: ?>
                                        <input class="form-control" type="hidden" class="form-control" name="id_mhs"
                                        value="<?= $mhs[0]->id_mhs ?>">
                                    <?php endif; ?>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nama Judul 1<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="nama_judul1"
                                            class="form-control" placeholder="Masukkan Nama Bidang"
                                            value="<?= $pengajuanjudul->nama_judul1 ?>" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('nama_judul1')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('nama_judul1'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Deskripsi Sistem 1<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="deskripsi_sistem1"
                                            class="form-control" placeholder="Masukkan Nama Bidang"
                                            value="<?= $pengajuanjudul->deskripsi_sistem1 ?>" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('deskripsi_sistem1')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('deskripsi_sistem1'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nama Judul 2<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="nama_judul2"
                                            class="form-control" placeholder="Masukkan Nama Bidang"
                                            value="<?= $pengajuanjudul->nama_judul2 ?>" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('nama_judul2')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('nama_judul2'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Deskripsi Sistem 2<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="deskripsi_sistem2"
                                            class="form-control" placeholder="Masukkan Nama Bidang"
                                            value="<?= $pengajuanjudul->deskripsi_sistem2 ?>" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('deskripsi_sistem2')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('deskripsi_sistem2'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nama Judul 3<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="nama_judul3"
                                            class="form-control" placeholder="Masukkan Nama Bidang"
                                            value="<?= $pengajuanjudul->nama_judul3 ?>" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('nama_judul3')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('nama_judul3'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Deskripsi Sistem 3<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="deskripsi_sistem3"
                                            class="form-control" placeholder="Masukkan Nama Bidang"
                                            value="<?= $pengajuanjudul->deskripsi_sistem3 ?>" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('deskripsi_sistem3')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('deskripsi_sistem3'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="<?=base_url('simta/pengajuanjudul');?>" class="btn btn-warning">Kembali</a>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- end section -->
            </div>
            <!-- /.col-12 col-lg-10 col-xl-10 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container-fluid -->
</main>
<?php echo $this->include('simta/simta_partial/dashboard/footer'); ?>