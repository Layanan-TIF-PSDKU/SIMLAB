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
                                <strong class="card-title">Form Edit Data Jadwal Mata Kuliah Praktikum</strong>
                            </div>
                            <div class="card-body">
                                <!-- table -->
                                <form method="POST"
                                    action="<?=base_url("simlab/penggunaan-ruang-laboratorium/update/" . $jadwal->id_ruang . '/' . $jadwal->id_jadwal)?>"
                                    enctype="multipart/form-data">
                                    <div class="form-group mb-3">
                                        <label for="simple-select-2">Nama Ruang Laboratorium</label>
                                        <input type="hidden" name="id_ruang" value="<?=$jadwal->id_ruang?>">
                                        <input type="text"
                                            class="form-control <?=($validation->hasError('id_ruang')) ? 'is-invalid' : ''?>"
                                            value="<?=$jadwal->nama_ruang?>" readonly />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('id_ruang');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Nama Mata Kuliah</label>
                                        <select
                                            class="form-control select2 <?=($validation->hasError('id_mata_kuliah')) ? 'is-invalid' : ''?>"
                                            name="id_mata_kuliah" id="id_mata_kuliah">
                                            <option value="">Pilih Mata Kuliah</option>
                                            <?php foreach($matakuliah as $mk): ?>
                                            <option value="<?= $mk->id_mata_kuliah ?>"
                                                <?= $jadwal->id_mata_kuliah == $mk->id_mata_kuliah ? 'selected' : null ?>>
                                                <?= $mk->nama_mata_kuliah ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('id_mata_kuliah');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="kelas">Kelas</label>
                                        <select
                                            class="form-control select <?=($validation->hasError('kelas')) ? 'is-invalid' : ''?>"
                                            name="kelas" id="kelas">
                                            <option value="">Pilih Kelas</option>
                                            <option value="D" <?=$jadwal->kelas == 'D' ? 'selected' : ''?>>D</option>
                                            <option value="E" <?=$jadwal->kelas == 'E' ? 'selected' : ''?>>E</option>
                                        </select>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('kelas');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="hari">Hari</label>
                                        <select
                                            class="form-control select <?=($validation->hasError('hari')) ? 'is-invalid' : ''?>"
                                            name="hari" id="hari">
                                            <option value="">Pilih Hari</option>
                                            <option value="Senin" <?=$jadwal->hari == 'Senin' ? 'selected' : ''?>>Senin
                                            </option>
                                            <option value="Selasa" <?=$jadwal->hari == 'Selasa' ? 'selected' : ''?>>
                                                Selasa</option>
                                            <option value="Rabu" <?=$jadwal->hari == 'Rabu' ? 'selected' : ''?>>Rabu
                                            </option>
                                            <option value="Kamis" <?=$jadwal->hari == 'Kamis' ? 'selected' : ''?>>Kamis
                                            </option>
                                            <option value="Jumat" <?=$jadwal->hari == 'Jumat' ? 'selected' : ''?>>Jumat
                                            </option>
                                        </select>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('hari');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tahun_ajaran">Tahun Ajaran</label>
                                        <select name="tahun_ajaran" id="tahun_ajaran"
                                            class="form-control select2<?=($validation->hasError('tahun_ajaran')) ? 'is-invalid' : ''?>">
                                            <option value="">Pilih Tahun Ajaran</option>
                                            <option value=""></option>
                                        </select>
                                        <!-- <input type="text" id="tahun_ajaran" name="tahun_ajaran"
                                            class="form-control  <?=($validation->hasError('tahun_ajaran')) ? 'is-invalid' : ''?>" value="<?=date('Y')?>" readonly/> -->
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('tahun_ajaran');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="semester">Semester</label>
                                        <select
                                            class="form-control select <?=($validation->hasError('semester')) ? 'is-invalid' : ''?>"
                                            name="semester" id="semester">
                                            <option value="">Pilih Semester</option>
                                            <option value="A (Ganjil)"
                                                <?=$jadwal->semester == 'A (Ganjil)' ? 'selected' : ''?>>A (Ganjil)
                                            </option>
                                            <option value="B (Genap)"
                                                <?=$jadwal->semester == 'B (Genap)' ? 'selected' : ''?>>B (Genap)
                                            </option>
                                        </select>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('hari');?>
                                        </div>
                                    </div>


                                    <div class="form-group mb-3">
                                        <label for="waktu_mulai">Waktu Mulai</label>
                                        <input type="time" id="waktu_mulai" name="waktu_mulai"
                                            class="form-control <?=($validation->hasError('waktu_mulai')) ? 'is-invalid' : ''?>"
                                            value="<?=$jadwal->waktu_mulai?>" placeholder="Masukkan Waktu Mulai" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('waktu_mulai');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="waktu_selesai">Waktu Selesai</label>
                                        <input type="time" id="waktu_selesai" name="waktu_selesai"
                                            class="form-control <?=($validation->hasError('waktu_selesai')) ? 'is-invalid' : ''?>"
                                            value="<?=$jadwal->waktu_selesai?>" placeholder="Masukkan Waktu Selesai" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('waktu_selesai');?>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit">
                                        Edit
                                    </button>
                                    <a href="<?=base_url('simlab/penggunaan-ruang-laboratorium/lihat/' . $jadwal->id_ruang);?>"
                                        class="btn btn-warning">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div> <!-- simple table -->
                </div> <!-- end section -->
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->

    <script>
    var select = document.getElementById("tahun_ajaran");
    var currentYear = new Date().getFullYear();

    for (var year = currentYear; year >= 2020; year--) {
        var option = document.createElement("option");
        option.text = year;
        option.value = year;
        if (year == <?= $jadwal->tahun_ajaran; ?>) {
        option.selected = true;
    }
        select.add(option);
    }
   </script>
</main>

<?=$this->include('simlab/simlab_partial/dashboard/footer')?>