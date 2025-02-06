<?php echo $this->include('master_partial/dashboard/header');?>
<?php echo $this->include('master_partial/dashboard/top_menu');?>
<?php echo $this->include('master_partial/dashboard/side_menu');?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Form Edit Mahasiswa</h2>
                <?php $uri = new \CodeIgniter\HTTP\URI(); $uri = service('uri'); $uri = current_url(true);?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <?php if((string) $uri == 'https://d3ti.myfin.id/mahasiswa/user/edit/' . $mahasiswa->id_mhs) : ?>
                                <form method="POST"
                                    action="<?= base_url('mahasiswa/user/update/' . $mahasiswa->id_mhs); ?>">
                                    <?php elseif((string) $uri == 'https://d3ti.myfin.id/mahasiswa/edit/' . $mahasiswa->id_mhs): ?>
                                    <form method="POST"
                                        action="<?= base_url('mahasiswa/update/'.$mahasiswa->id_mhs); ?>">
                                        <?php endif; ?>
                                        <input type="hidden" name="id_user" value="<?= $mahasiswa->id_user ?>" />
                                        <div class="form-group mb-3">
                                            <label for="address-wpalaceholder">Nama Mahasiswa</label>
                                            <input type="text" id="address-wpalaceholder" name="nama"
                                                class="form-control" placeholder="Masukkan Nama Mahasiswa"
                                                value="<?= $mahasiswa->nama ?>" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('nama')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nama'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="address-wpalaceholder">Username</label>
                                            <input type="text" id="address-wpalaceholder" name="username"
                                                class="form-control" placeholder="Masukkan Username"
                                                value="<?= $mahasiswa->username ?>" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('username')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('username'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="address-wpalaceholder">Email</label>
                                            <input type="text" id="address-wpalaceholder" name="email"
                                                class="form-control" placeholder="Masukkan Email"
                                                value="<?= $mahasiswa->email ?>" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('email')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('email'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="address-wpalaceholder">NIM</label>
                                            <input type="text" id="address-wpalaceholder" name="nim"
                                                class="form-control" placeholder="Masukkan NIM"
                                                value="<?= $mahasiswa->nim ?>" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('nim')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nim'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="address-wpalaceholder">Prodi</label>
                                            <input type="text" id="address-wpalaceholder" name="prodi"
                                                class="form-control" placeholder="Masukkan Prodi"
                                                value="<?= $mahasiswa->prodi ?>" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('prodi')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('prodi'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="address-wpalaceholder">Nomor Telepon</label>
                                            <input type="number" id="address-wpalaceholder" name="no_telp"
                                                class="form-control" placeholder="Masukkan Nomor Telepon"
                                                value="<?= $mahasiswa->no_telp ?>" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('no_telp')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('no_telp'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="address-wpalaceholder">Tahun Masuk</label>
                                            <input type="number" id="address-wpalaceholder" name="th_masuk"
                                                class="form-control" placeholder="Masukkan Tahun Masuk"
                                                value="<?= $mahasiswa->th_masuk ?>" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('th_masuk')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('th_masuk'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="address-wpalaceholder">Tahun Lulus</label>
                                            <input type="number" id="address-wpalaceholder" name="th_lulus"
                                                class="form-control" placeholder="Masukkan Tahun Lulus"
                                                value="<?= $mahasiswa->th_lulus ?>" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('th_lulus')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('th_lulus'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="address-wpalaceholder">Kelas</label>
                                            <input type="text" id="address-wpalaceholder" name="kelas"
                                                class="form-control" placeholder="Masukkan Kelas"
                                                value="<?= $mahasiswa->kelas ?>" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('kelas')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('kelas'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="simple-select2">Status</label>
                                            <select class="form-control select2" name="status" id="simple-select2">
                                                <option value="">Pilih Status</option>
                                                <option value="1"
                                                    <?= $mahasiswa->status_mahasiswa == '1' ? 'selected' : ''?>>
                                                    Aktif</option>
                                                <option value="0"
                                                    <?= $mahasiswa->status_mahasiswa == '0' ? 'selected' : ''?>>
                                                    Non-Aktif</option>
                                            </select>
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('status')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('status'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <button class="btn btn-primary" type="submit">
                                            Edit
                                        </button>
                                        <?php if((string) $uri == 'https://d3ti.myfin.id/mahasiswa/user/edit/' . $mahasiswa->id_mhs) : ?>
                                        <a href="<?= base_url('users'); ?>" class="btn btn-warning">Kembali</a>
                                        <?php elseif((string) $uri == 'https://d3ti.myfin.id/mahasiswa/edit/' . $mahasiswa->id_mhs) : ?>
                                        <a href="<?= base_url('mahasiswa'); ?>" class="btn btn-warning">Kembali</a>
                                        <?php endif; ?>
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
<?php echo $this->include('master_partial/dashboard/footer');?>