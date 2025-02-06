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
                                <strong class="card-title">Form Input Data Perawatan Alat Laboratorium</strong>
                            </div>
                            <div class="card-body">
                                <!-- table -->
                                <form method="POST" action="<?=base_url("simlab/perawatan-alat/simpan")?>" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                        <label for="id_alat">Alat Laboratorium</label>
                                        <select
                                            class="form-control select2 <?=($validation->hasError('id_alat')) ? 'is-invalid' : ''?>"
                                            name="id_alat" id="id_alat">
                                            <option value="">Pilih Alat Laboratorium</option>
                                            <?php foreach ($alatlab as $atlab): ?>
                                            <option value="<?=$atlab->id_alat?>"<?= set_select('id_alat', $atlab->id_alat); ?>>
                                            <?=$atlab->nama_alat?> (<?=$atlab->no_inventaris?>) - <?=$atlab->nama_ruang?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('id_alat');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="jenis">Jenis Perawatan</label>
                                        <select class="form-control select2 <?=($validation->hasError('jenis')) ? 'is-invalid' : ''?>" name="jenis" id="jenis">
                                        <option value="">Pilih Jenis Perawatan</option>
													<option value="Software"<?= set_select('jenis', 'Software'); ?>>Software</option>
													<option value="Hardware"<?= set_select('jenis', 'Hardware'); ?>>Hardware</option>
                                        </select>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('jenis');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="level">Level Perawatan</label>
                                        <select class="form-control select2 <?=($validation->hasError('level')) ? 'is-invalid' : ''?>" name="level" id="level">
                                        <option value="">Pilih Level Perawatan</option>
													<option value="Ringan" <?= set_select('level', 'Ringan'); ?>>Ringan</option>
													<option value="Sedang" <?= set_select('level', 'Sedang'); ?>>Sedang</option>
													<option value="Fatal" <?= set_select('level', 'Fatal'); ?>>Fatal</option>
                                        </select>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('level');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tanggal">Tanggal Perawatan</label>
                                        <input type="date" id="tanggal" name="tanggal" value="<?=set_value('tanggal')?>"
                                            class="form-control  <?=($validation->hasError('tanggal')) ? 'is-invalid' : ''?>" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('tanggal');?>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">
                                        Tambah
                                    </button>
                                    <a href="<?=base_url('simlab/perawatan-alat');?>" class="btn btn-warning">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div> <!-- simple table -->
                </div> <!-- end section -->
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</main>

<?=$this->include('simlab/simlab_partial/dashboard/footer')?>