<?php echo $this->include('master_partial/dashboard/header');?>
<?php echo $this->include('master_partial/dashboard/top_menu');?>
<?php echo $this->include('master_partial/dashboard/side_menu');?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Form Tambah Staf</h2>
                <?php $uri = new \CodeIgniter\HTTP\URI(); $uri = service('uri'); $uri = current_url(true);?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <?php if((string) $uri == 'https://d3ti.myfin.id/staf/user/tambah') : ?>
                                <form method="POST" action="<?= base_url("staf/user/tambah/store") ?>">
                                    <?php elseif((string) $uri == 'https://d3ti.myfin.id/staf/tambah'): ?>
                                    <form method="POST" action="<?= base_url("staf/tambah/store") ?>">
                                        <?php endif; ?>
                                        <div class="form-group mb-3">
                                            <label for="address-wpalaceholder">Nama Staf</label>
                                            <input type="text" id="address-wpalaceholder" name="nama"
                                                class="form-control" placeholder="Masukkan Nama Staf" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('nama')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nama'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Username</label>
                                            <input type="text" name="username" id="username" class="form-control"
                                                placeholder="Masukkan Username" onkeyup="generatePassword()" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('username')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('username'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Email</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                placeholder="Masukkan Email" onkeyup="generatePassword()" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('email')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('email'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Password</label>
                                            <input type="text" id="password" name="password" class="form-control"
                                                value="d3timadiun123" readonly />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('password')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('password'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="address-wpalaceholder">NIP</label>
                                            <input type="text" id="address-wpalaceholder" name="nip"
                                                class="form-control" placeholder="Masukkan NIP" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('nip')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nip'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="address-wpalaceholder">Nomor Telepon</label>
                                            <input type="number" id="address-wpalaceholder" name="no_telp"
                                                class="form-control" placeholder="Masukkan Nomor Telepon" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('no_telp')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('no_telp'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="address-wpalaceholder">Alamat</label>
                                            <input type="text" id="address-wpalaceholder" name="alamat"
                                                class="form-control" placeholder="Masukkan Alamat" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('alamat')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('alamat'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="simple-select2">Jenis</label>
                                            <select class="form-control select2" name="jenis" id="simple-select2">
                                                <option value="">Pilih Role User</option>
                                                <option value="Pimpinan">Pimpinan</option>
                                                <option value="Dosen">Dosen</option>
                                                <option value="Laboran">Laboran</option>
                                            </select>
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('jenis')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('jenis'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="simple-select3">Status</label>
                                            <select class="form-control select2" name="status" id="simple-select3">
                                                <option value="">Pilih Status</option>
                                                <option value="1">Aktif</option>
                                                <option value="0">Non-Aktif</option>
                                            </select>
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('status')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('status'); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <button class="btn btn-primary" type="submit">
                                            Tambah
                                        </button>
                                        <a href="<?= base_url('staf'); ?>" class="btn btn-warning">Kembali</a>
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