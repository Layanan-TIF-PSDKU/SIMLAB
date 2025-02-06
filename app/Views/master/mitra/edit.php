<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('master_partial/dashboard/top_menu'); ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Edit Data Mitra</h2>
                <?php $uri = new \CodeIgniter\HTTP\URI(); $uri = service('uri'); $uri = current_url(true);?>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <?php if((string) $uri == 'https://d3ti.myfin.id/mitra/user/edit/'. $mitra->id_mitra) : ?>
                                <form method="POST" action="<?= base_url('mitra/user/update/'. $mitra->id_mitra); ?>">
                                    <?php elseif((string) $uri == 'https://d3ti.myfin.id/mitra/edit/'. $mitra->id_mitra): ?>
                                    <form method="POST" action="<?= base_url('mitra/update/'. $mitra->id_mitra); ?>">
                                        <?php endif; ?>
                                        <input type="hidden" name="id_user" value="<?= $mitra->id_user ?>">
                                        <input type="hidden" name="id_mitra" value="<?= $mitra->id_mitra ?>">
                                        <input type="hidden" name="id_mitra_detail"
                                            value="<?= $mitra->id_mitra_detail ?>">
                                        <div class="form-group mb-3">
                                            <label>Username</label>
                                            <input type="text" name="username" id="username"
                                                class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>"
                                                placeholder="Masukkan Username" onkeyup="generatePassword()"
                                                value="<?= $mitra->username ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('username'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Email</label>
                                            <input type="email" name="email" id="email"
                                                class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>"
                                                value="<?= $mitra->email ?>" onkeyup="generatePassword()">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('email'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Nama Instansi</label>
                                            <input type="text" name="nama_instansi" id="address-wpalaceholder"
                                                class="form-control <?= ($validation->hasError('nama_instansi')) ? 'is-invalid' : ''; ?>"
                                                value="<?= $mitra->nama_instansi ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('nama_instansi'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>Nama Pimpinan</label>
                                            <input type="text" name="nama_pimpinan" id="address-wpalaceholder"
                                                class="form-control <?= ($validation->hasError('nama_pimpinan')) ? 'is-invalid' : ''; ?>"
                                                value="<?= $mitra->nama_pimpinan ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('nama_pimpinan'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>Nama Mentor</label>
                                            <input type="text" name="nama_mentor"
                                                class="form-control <?= ($validation->hasError('nama_mentor')) ? 'is-invalid' : ''; ?>"
                                                value="<?= $mitra->nama_mentor ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('nama_mentor'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>Jenis Mitra</label>
                                            <select name="jenis[]"
                                                class="form-control select2 <?= ($validation->hasError('jenis')) ? 'is-invalid' : ''; ?>"
                                                multiple="multiple">
                                                <option value="KMM"
                                                    <?= in_array($mitra->jenis, $jenis) ? 'selected' : null ?>>
                                                    KMM</option>
                                                <option value="MBKM"
                                                    <?= in_array($mitra->jenis, $jenis) ? 'selected' : null ?>>
                                                    MBKM</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('jenis'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>Nomor Telepon</label>
                                            <input type="number" name="no_telp" id="address-wpalaceholder"
                                                class="form-control <?= ($validation->hasError('no_telp')) ? 'is-invalid' : ''; ?>"
                                                value="<?= $mitra->no_telp ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('no_telp'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>Alamat</label>
                                            <textarea
                                                class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>"
                                                id="address-wpalaceholder" rows="4"
                                                name="alamat"><?= $mitra->alamat ?></textarea>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('alamat'); ?>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                        <?php if((string) $uri == 'https://d3ti.myfin.id/mitra/user/edit/'. $mitra->id_mitra) : ?>
                                        <a href="<?= base_url('users'); ?>" class="btn btn-warning">Kembali</a>
                                        <?php elseif((string) $uri == 'https://d3ti.myfin.id/mitra/edit/'. $mitra->id_mitra) : ?>
                                        <a href="<?= base_url('mitra'); ?>" class="btn btn-warning">Kembali</a>
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

<?= $this->include('master_partial/dashboard/footer'); ?>