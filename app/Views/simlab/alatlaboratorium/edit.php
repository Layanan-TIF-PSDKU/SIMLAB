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
                                <strong class="card-title">Form Edit Data Alat Laboratorium</strong>
                            </div>
                            <div class="card-body">
                                <!-- table -->
                                <form method="POST"
                                    action="<?=base_url("simlab/alat-laboratorium/update/" . $alatlab->id_alat)?>"
                                    enctype="multipart/form-data">
                                    <input type="hidden" id="tanggal_perubahan" name="tanggal_perubahan"
                                        class="form-control" value="<?=date('Y-m-d')?>" />
                                    <div class="form-group mb-3">
                                        <label for="id_kategori">Kategori</label>
                                        <select
                                            class="form-control select2 <?=($validation->hasError('id_kategori')) ? 'is-invalid' : ''?>"
                                            name="id_kategori" id="id_kategori">
                                            <option value="">Pilih Kategori</option>
                                            <?php foreach ($kategori as $ktgr): ?>
                                            <option value="<?=$ktgr->id_kategori?>"
                                                <?= $alatlab->id_kategori == $ktgr->id_kategori ? 'selected' : null ?>>
                                                <?=$ktgr->nama_kategori?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('id_kategori');?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="nama_alat">Nama Alat Laboratorium</label>
                                        <input type="text" id="nama_alat" name="nama_alat"
                                            class="form-control <?=($validation->hasError('nama_alat')) ? 'is-invalid' : ''?>"
                                            placeholder="Masukkan Nama Alat Laboratorium"
                                            value="<?=$alatlab->nama_alat?>" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('nama_alat');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="no_inventaris">Nomor Inventaris Alat Laboratorium (Wajib Diisi Jika
                                            Kategori Peralatan)</label>
                                        <input type="text" id="no_inventaris" name="no_inventaris"
                                            class="form-control <?=($validation->hasError('no_inventaris')) ? 'is-invalid' : ''?>"
                                            placeholder="Masukkan Nomor Inventaris Alat Laboratorium"
                                            value="<?=$alatlab->no_inventaris?>" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('no_inventaris');?>
                                        </div>
                                    </div>


                                    <div class="form-group mb-3">
                                        <label for="id_ruang">Letak</label>
                                        <select
                                            class="form-control select2 <?=($validation->hasError('id_ruang')) ? 'is-invalid' : ''?>"
                                            name="id_ruang" id="id_ruang">
                                            <option value="">Pilih Ruang Laboratorium/option>
                                                <?php foreach ($ruanglab as $rlab): ?>
                                            <option value="<?=$rlab->id_ruang?>"
                                                <?= $alatlab->id_ruang == $rlab->id_ruang ? 'selected' : null ?>>
                                                <?=$rlab->nama_ruang?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('id_ruang');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tanggal_masuk">Tanggal Masuk</label>
                                        <input type="date" id="tanggal_masuk" name="tanggal_masuk"
                                            class="form-control  <?=($validation->hasError('tanggal_masuk')) ? 'is-invalid' : ''?>"
                                            value="<?= $alatlab->tanggal_masuk?>" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('tanggal_masuk');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="jumlah_masuk">Jumlah Masuk (Masukkan "1" Jika Kategori
                                            Peralatan)</label>
                                        <input type="number" id="jumlah_masuk" name="jumlah_masuk"
                                            class="form-control <?=($validation->hasError('jumlah_masuk')) ? 'is-invalid' : ''?>"
                                            placeholder="Masukkan Jumlah" value="<?=$alatlab->jumlah_masuk?>" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('jumlah_masuk');?>
                                        </div>
                                    </div>

                                    <input type="hidden" id="stok" name="stok" class="form-control"
                                        value="<?=$alatlab->stok?>" />

                                    <div class="form-group mb-3">
                                        <label for="satuan">Satuan</label>
                                        <select
                                            class="form-control select2 <?=($validation->hasError('satuan')) ? 'is-invalid' : ''?>"
                                            name="satuan" id="satuan">
                                            <option value="">Pilih Satuan</option>
                                            <option value="Buah" <?=$alatlab->satuan == 'Buah' ? 'selected' : ''?>>Buah
                                            </option>
                                            <option value="Unit" <?=$alatlab->satuan == 'Unit' ? 'selected' : ''?>>Unit
                                            </option>
                                        </select>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('satuan');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="kondisi">Kondisi</label>
                                        <select
                                            class="form-control select2 <?=($validation->hasError('kondisi')) ? 'is-invalid' : ''?>"
                                            name="kondisi" id="kondisi">
                                            <option value="">Pilih Kondisi</option>
                                            <option value="Baik" <?=$alatlab->kondisi == 'Baik' ? 'selected' : ''?>>Baik
                                            </option>
                                            <option value="Rusak" <?=$alatlab->kondisi == 'Rusak' ? 'selected' : ''?>>
                                                Rusak</option>
                                        </select>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('kondisi');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="gambar">Gambar Alat Laboratorium</label>
                                        <div class="col-sm-4">
                                            <img src="<?= base_url("../simlab_assets/alat-laboratorium/$alatlab->gambar") ?>"
                                                style="width:50%; margin-bottom:10px;" class="img-thumbnail">
                                        </div>
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input <?=($validation->hasError('gambar')) ? 'is-invalid' : ''?>"
                                                name="gambar" id="inputFile">
                                            <label
                                                class="custom-file-label <?=($validation->hasError('gambar')) ? 'is-invalid' : ''?>"
                                                for="customFile">Choose file</label>
                                        </div>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('gambar');?>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit">
                                        Edit
                                    </button>
                                    <a href="<?=base_url('simlab/alat-laboratorium');?>"
                                        class="btn btn-warning">Kembali</a>
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

<script type="text/javascript">
$(document).ready(function() {
    $('#jumlah_masuk').keyup(function(e) {
        var v = $('#jumlah_masuk').val();
        $('#stok').val(v);
    })
});
</script>