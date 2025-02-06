<?=$this->include('simlab/simlab_partial/dashboard/header')?>
<?=$this->include('simlab/simlab_partial/dashboard/top_menu')?>
<?=$this->include('simlab/simlab_partial/dashboard/side_menu')?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Halaman <?=$title?></h2>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">Form Pengajuan Peminjaman Ruang Laboratorium</strong>
                            </div>
                            <div class="card-body">
                                <!-- table -->
                                <form method="POST"
                                    action="<?=base_url("simlab/pengajuan-peminjaman/ruang-laboratorium/simpan")?>"
                                    enctype="multipart/form-data">

                                    <?php if (in_groups('mahasiswa')): ?>
                                    <input type="hidden" id="id_mahasiswa" name="id_mahasiswa"
                                        value="<?=$mahasiswa[0]->id_mhs?>" />
                                    <div class="form-group row">
                                        <label for="id_mahasiswa" class="col-sm-3 col-form-label">Nama Peminjam</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="id_mahasiswa" name="id_mahasiswa"
                                                class="form-control <?=($validation->hasError('id_mahasiswa')) ? 'is-invalid' : ''?>"
                                                placeholder="Masukkan Nama" value="<?=$mahasiswa[0]->nama?>" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="id_mahasiswa" class="col-sm-3 col-form-label">NIM</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="id_mahasiswa" name="id_mahasiswa"
                                                class="form-control <?=($validation->hasError('id_mahasiswa')) ? 'is-invalid' : ''?>"
                                                value="<?=$mahasiswa[0]->nim?>" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="id_mahasiswa" class="col-sm-3 col-form-label">No. Telp</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="id_mahasiswa" name="id_mahasiswa"
                                                class="form-control <?=($validation->hasError('id_mahasiswa')) ? 'is-invalid' : ''?>"
                                                value="<?=$mahasiswa[0]->no_telp?>" disabled />
                                        </div>
                                    </div>
                                    <?php endif;?>

                                    <?php if (in_groups('dosen') || in_groups('laboran')): ?>
                                    <input type="hidden" id="id_staff" name="id_staff" value="<?=$staf[0]->id_staf?>" />
                                    <div class="form-group row">
                                        <label for="id_staff" class="col-sm-3 col-form-label">Nama Peminjam</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="id_staff" name="id_staff"
                                                class="form-control <?=($validation->hasError('id_staff')) ? 'is-invalid' : ''?>"
                                                placeholder="Masukkan Nama" value="<?=$staf[0]->nama?>" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="id_staff" class="col-sm-3 col-form-label">NIP</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="id_staff" name="id_staff" class="form-control"
                                                value="<?=$staf[0]->nip?>" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="id_staff" class="col-sm-3 col-form-label">No. Telp</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="id_staff" name="id_staff" class="form-control"
                                                value="<?=$staf[0]->no_telp?>" disabled />
                                        </div>
                                    </div>
                                    <?php endif;?>

                                    <div class="form-group row">
                                        <label for="id_ruang" class="col-sm-3 col-form-label">Ruang Laboratorium</label>
                                        <div class="col-sm-9">
                                            <select
                                                class="form-control select2 <?=($validation->hasError('id_ruang')) ? 'is-invalid' : ''?>"
                                                name="id_ruang" id="id_ruang">
                                                <option value="">Pilih Ruang Laboratorium</option>
                                                <?php foreach ($ruanglab as $rlab): ?>
                                                <option value="<?=$rlab->id_ruang?>"
                                                    <?=set_select('id_ruang', $rlab->id_ruang);?>>
                                                    <?=$rlab->nama_ruang?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('id_ruang');?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="keperluan" class="col-sm-3 col-form-label">Keperluan</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="keperluan" name="keperluan"
                                                value="<?=set_value('keperluan')?>"
                                                class="form-control <?=($validation->hasError('keperluan')) ? 'is-invalid' : ''?>"
                                                placeholder="Isikan Keperluan" />
                                        </div>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('keperluan');?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tanggal_ajuan" class="col-sm-3 col-form-label">Tanggal
                                            Pengajuan</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="tanggal_ajuan" name="tanggal_ajuan"
                                                class="form-control <?=($validation->hasError('tanggal_ajuan')) ? 'is-invalid' : ''?>"
                                                value="<?=date("Y-m-d")?>" readonly />
                                        </div>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('tanggal_ajuan');?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="hari" class="col-sm-3 col-form-label">Hari</label>
                                        <div class="col-sm-9">
                                            <select
                                                class="form-control select <?=($validation->hasError('hari')) ? 'is-invalid' : ''?>"
                                                name="hari" id="hari">
                                                <option value="">Pilih Hari</option>
                                                <option value="Senin" <?=set_select('hari', 'Senin');?>>Senin</option>
                                                <option value="Selasa" <?=set_select('hari', 'Selasa');?>>Selasa
                                                </option>
                                                <option value="Rabu" <?=set_select('hari', 'Rabu');?>>Rabu</option>
                                                <option value="Kamis" <?=set_select('hari', 'Kamis');?>>Kamis</option>
                                                <option value="Jumat" <?=set_select('hari', 'Jumat');?>>Jumat</option>
                                            </select>
                                        </div>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('hari');?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tanggal_pinjam" class="col-sm-3 col-form-label">Tanggal
                                            Peminjaman</label>
                                        <div class="col-sm-9">
                                            <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" value="<?=set_value('tanggal_pinjam')?>"
                                                class="form-control  <?=($validation->hasError('tanggal_pinjam')) ? 'is-invalid' : ''?>" />
                                        </div>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('tanggal_pinjam');?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="waktu_mulai" class="col-sm-3 col-form-label">Waktu Mulai</label>
                                        <div class="col-sm-9">
                                            <input type="time" id="waktu_mulai" name="waktu_mulai" value="<?=set_value('waktu_mulai')?>"
                                                class="form-control  <?=($validation->hasError('waktu_mulai')) ? 'is-invalid' : ''?>" />
                                        </div>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('waktu_mulai');?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="waktu_selesai" class="col-sm-3 col-form-label">Waktu Selesai</label>
                                        <div class="col-sm-9">
                                            <input type="time" id="waktu_selesai" name="waktu_selesai" value="<?=set_value('waktu_selesai')?>"
                                                class="form-control  <?=($validation->hasError('waktu_selesai')) ? 'is-invalid' : ''?>" />
                                        </div>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('waktu_selesai');?>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit" id="submitBtn">Tambah</button>
                                    </button>
                                    <a href="<?=base_url('simlab/penggunaan-ruang-laboratorium/pilih-kondisi');?>"
                                        class="btn btn-warning">Kembali</a>
                                </form>

                                <script>
                                document.getElementById("submitBtn").addEventListener("click", function(event) {
                                    setTimeout(function() {
                                        window.location.href = "<?= base_url('/simlab') ?>";
                                    }, 500); // Redirect setelah 0.5 detik
                                });
                                </script>
                            </div>
                        </div>
                    </div> <!-- simple table -->
                </div>
                <!-- end section -->
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</main>

<?=$this->include('simlab/simlab_partial/dashboard/footer')?>