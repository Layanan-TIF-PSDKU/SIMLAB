<?=$this->include('simlab/simlab_partial/dashboard/header')?>
<?=$this->include('simlab/simlab_partial/dashboard/top_menu')?>
<?=$this->include('simlab/simlab_partial/dashboard/side_menu')?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Halaman <?=$title?></h2>
                <div class="row">
                    <!-- Small table -->
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">Form Tambah Data Alat Laboratorium</strong>
                            </div>
                            <div class="card-body">
                                <!-- table -->
                                <form method="POST" action="<?=base_url("simlab/alat-laboratorium/simpan")?>"
                                    enctype="multipart/form-data">

                                    <div class="form-group mb-3">
                                        <label for="id_kategori">Kategori</label>
                                        <select
                                            class="form-control select2 <?=($validation->hasError('id_kategori')) ? 'is-invalid' : ''?>"
                                            name="id_kategori" id="id_kategori">
                                            <option value="">Pilih Kategori</option>
                                            <?php foreach ($kategori as $ktgr => $kgr): ?>
                                            <option value="<?=$kgr->id_kategori?>"
                                                <?= set_select('id_kategori', $kgr->id_kategori); ?>>
                                                <?=$kgr->nama_kategori?></option>
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
                                            value="<?=set_value('nama_alat')?>" />
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
                                            value="<?=set_value('no_inventaris')?>" />
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
                                            <option value="">Pilih Ruang Laboratorium</option>
                                            <?php foreach ($ruanglab as $rlab ): ?>
                                            <option value="<?=$rlab->id_ruang?>"
                                                <?= set_select('id_ruang', $rlab->id_ruang); ?>><?=$rlab->nama_ruang?>
                                            </option>
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
                                            value="<?=set_value('tanggal_masuk')?>" />
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
                                            placeholder="Masukkan Jumlah Masuk Alat Laboratorium"
                                            value="<?=set_value('jumlah_masuk')?>" min="1" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('jumlah_masuk');?>
                                        </div>
                                    </div>

                                    <input type="hidden" id="stok" name="stok" class="form-control" />

                                    <div class="form-group mb-3">
                                        <label for="satuan">Satuan</label>
                                        <select
                                            class="form-control select2 <?=($validation->hasError('satuan')) ? 'is-invalid' : ''?>"
                                            name="satuan" id="satuan">
                                            <option value="">Pilih Satuan</option>
                                            <option value="Buah" <?= set_select('satuan', 'Buah'); ?>>Buah</option>
                                            <option value="Unit" <?= set_select('satuan', 'Unit'); ?>>Unit</option>
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
                                            <option value="Baik" <?= set_select('kondisi', 'Baik'); ?>>Baik</option>
                                            <option value="Rusak" <?= set_select('kondisi', 'Rusak'); ?>>Rusak</option>
                                        </select>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('kondisi');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="gambar">Gambar Alat Laboratorium</label>
                                        <div class="custom-file ">
                                            <input type="file" required
                                                class="custom-file-input <?=($validation->hasError('gambar')) ? 'is-invalid' : ''?>"
                                                name="gambar" id="inputFile">
                                            <label
                                                class="custom-file-label <?=($validation->hasError('gambar')) ? 'is-invalid' : ''?>"
                                                for="customFile">Choose file</label>
                                            <!-- Error Validation -->
                                            <div class="invalid-feedback">
                                                <?=$validation->getError('gambar');?>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit">
                                        Tambah
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#jumlah_masuk').keyup(function(e) {
            var v = $('#jumlah_masuk').val();
            $('#stok').val(v);
        })
    });

    // $(document).ready(function() {
    //     $('#id_kategori').change(function() {
    //         var kategori = $(this).val();
    //         // var no_inventaris = $('#no_inventaris');
    //         // var jumlah_masuk = $('#jumlah_masuk');

    //         if (kategori === 'Peralatan') {
    //             no_inventaris.prop('readonly', false);
    //             no_inventaris.prop('required', true);
    //             jumlah_masuk.val(1);
    //             jumlah_masuk.prop('readonly', true);
    //         } else if (kategori === 'Barang Habis Pakai') {
    //             no_inventaris.prop('readonly', true);
    //             no_inventaris.prop('required', false);
    //             jumlah_masuk.val('');
    //             jumlah_masuk.prop('readonly', false);
    //         }
    //     });
    // });
    </script>

</main>
<?=$this->include('simlab/simlab_partial/dashboard/footer')?>