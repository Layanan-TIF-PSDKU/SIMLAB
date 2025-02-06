<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('master_partial/dashboard/top_menu'); ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Edit Data Staf</h2>
                <?php $uri = new \CodeIgniter\HTTP\URI(); $uri = service('uri'); $uri = current_url(true);?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <?php if((string) $uri == 'https://d3ti.myfin.id/staf/user/edit/'. $staf->id_staf) : ?>
                                <form method="POST" action="<?= base_url('staf/user/update/'. $staf->id_staf); ?>">
                                    <?php elseif((string) $uri == 'https://d3ti.myfin.id/staf/edit/'. $staf->id_staf): ?>
                                    <form method="POST" action="<?= base_url('staf/update/'. $staf->id_staf); ?>">
                                        <?php endif; ?>
                                        <input type="hidden" name="id_user" value="<?= $staf->id_user ?>">
                                        <div class="form-group mb-3">
                                            <label>Nama Staf</label>
                                            <input type="text" name="nama" id="nama"
                                                class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>"
                                                placeholder="Masukkan nama"
                                                value="<?= $staf->nama ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('nama'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>Username</label>
                                            <input type="text" name="username" id="username"
                                                class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>"
                                                placeholder="Masukkan Username"
                                                value="<?= $staf->username ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('username'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>Email</label>
                                            <input type="text" name="email" id="email"
                                                class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>"
                                                placeholder="Masukkan Email"
                                                value="<?= $staf->email ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('email'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>NIP</label>
                                            <input type="text" name="nip" id="nip"
                                                class="form-control <?= ($validation->hasError('nip')) ? 'is-invalid' : ''; ?>"
                                                placeholder="Masukkan NIP"
                                                value="<?= $staf->nip ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('nip'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Alamat</label>
                                            <input type="text" name="alamat" id="alamat"
                                                class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>"
                                                placeholder="Masukkan Alamat"
                                                value="<?= $staf->alamat ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('alamat'); ?>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Nomor Telepon</label>
                                                <input type="text" name="no_telp" id="no_telp"
                                                    class="form-control <?= ($validation->hasError('no_telp')) ? 'is-invalid' : ''; ?>"
                                                    placeholder="Masukkan Nomor Telepon"
                                                    value="<?= $staf->no_telp ?>">
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('no_telp'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Jenis</label>
                                                <select
                                                    class="form-control <?= ($validation->hasError('jenis')) ? 'is-invalid' : ''; ?> select2"
                                                    name="jenis" id="simple-select2">
                                                    <option value="">Pilih Jenis</option>
                                                    <option value="Admin"
                                                        <?=$staf->jenis == 'Admin' ? 'selected' : ''?>>
                                                        Admin
                                                    <option value="Dosen"
                                                        <?=$staf->jenis == 'Dosen' ? 'selected' : ''?>>
                                                        Dosen
                                                    <option value="Pimpinan"
                                                        <?=$staf->jenis == 'Pimpinan' ? 'selected' : ''?>>Pimpinan
                                                    </option>
                                                    <option value="Laboran"
                                                        <?=$staf->jenis == 'Laboran' ? 'selected' : ''?>>Laboran
                                                    </option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('jenis'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Status</label>
                                                <select
                                                    class="form-control <?= ($validation->hasError('status')) ? 'is-invalid' : ''; ?> select2"
                                                    name="status" id="simple-select3">
                                                    <option value="">Pilih status</option>
                                                    <option value="1" <?=$staf->status == 1 ? 'selected' : ''?>>Aktif</option>
                                                    <option value="0" <?=$staf->status == 0 ? 'selected' : ''?>>Non-Aktif</option>   
                                                </select>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('status'); ?>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" type="submit">Edit</button>
                                            <?php if((string) $uri == 'https://d3ti.myfin.id/staf/user/edit/' . $staf->id_staf) : ?>
                                            <a href="<?= base_url('users'); ?>" class="btn btn-warning">Kembali</a>
                                            <?php elseif((string) $uri == 'https://d3ti.myfin.id/staf/edit/' . $staf->id_staf) : ?>
                                            <a href="<?= base_url('staf'); ?>" class="btn btn-warning">Kembali</a>
                                            <?php elseif((string) $uri == 'https://d3ti.myfin.id/staf/user/update/' . $staf->id_staf) : ?>
                                            <a href="<?= base_url('users'); ?>" class="btn btn-warning">Kembali</a>
                                            <?php elseif((string) $uri == 'https://d3ti.myfin.id/staf/update/' . $staf->id_staf) : ?>
                                            <a href="<?= base_url('staf'); ?>" class="btn btn-warning">Kembali</a>
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