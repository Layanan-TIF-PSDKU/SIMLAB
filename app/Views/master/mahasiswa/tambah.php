<?php echo $this->include('master_partial/dashboard/header');?>
<?php echo $this->include('master_partial/dashboard/top_menu');?>
<?php echo $this->include('master_partial/dashboard/side_menu');?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Form Tambah Mahasiswa</h2>
                <?php $uri = new \CodeIgniter\HTTP\URI(); $uri = service('uri'); $uri = current_url(true);?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <?php if((string) $uri == 'https://d3ti.myfin.id/mahasiswa/user/tambah') : ?>
                                    <form method="POST" action="<?= base_url("mahasiswa/user/simpan") ?>">
                                <?php elseif((string) $uri == 'https://d3ti.myfin.id/mahasiswa/tambah'): ?>  
                                    <form method="POST" action="<?= base_url("mahasiswa/simpan") ?>">
                                <?php endif; ?>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nama Mahasiswa</label>
                                        <input type="text" id="address-wpalaceholder" name="nama_mahasiswa" class="form-control" placeholder="Masukkan Nama Mahasiswa" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('nama_mahasiswa')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nama_mahasiswa'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Username</label>
                                        <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan Username" onkeyup="generatePassword()"/>
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('username')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('username'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email" onkeyup="generatePassword()"/>
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('email')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('email'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Password</label>
                                        <input type="text" id="password" name="password" class="form-control" value="d3timadiun123" readonly />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('password')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('password'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">NIM</label>
                                        <input type="text" id="address-wpalaceholder" name="nim" class="form-control" placeholder="Masukkan NIM" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('nim')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nim'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Prodi</label>
                                        <input type="text" id="address-wpalaceholder" name="prodi" class="form-control" placeholder="Masukkan Prodi" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('prodi')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('prodi'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nomor Telepon</label>
                                        <input type="number" id="address-wpalaceholder" name="nomor_telepon" class="form-control" placeholder="Masukkan Nomor Telepon" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('nomor_telepon')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nomor_telepon'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Tahun Masuk</label>
                                        <input type="number" id="address-wpalaceholder" name="tahun_masuk" class="form-control" placeholder="Masukkan Tahun Masuk" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('tahun_masuk')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('tahun_masuk'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Tahun Lulus</label>
                                        <input type="number" id="address-wpalaceholder" name="tahun_lulus" class="form-control" placeholder="Masukkan Tahun Lulus" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('tahun_lulus')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('tahun_lulus'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Kelas</label>
                                        <input type="text" id="address-wpalaceholder" name="kelas" class="form-control" placeholder="Masukkan Kelas" />
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
                                    <a href="<?= base_url('mahasiswa'); ?>" class="btn btn-warning">Kembali</a>
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
<!-- Script that uses bcryptjs -->
<?php echo $this->include('master_partial/dashboard/footer');?>