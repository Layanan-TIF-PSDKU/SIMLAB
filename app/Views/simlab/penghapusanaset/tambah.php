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
                                <strong class="card-title">Form Tambah Data Penghapusan Aset</strong>
                            </div>
                            <div class="card-body">
                                <!-- table -->
                                <form method="POST" action="<?=base_url("simlab/penghapusan-aset/simpan")?>"
                                    enctype="multipart/form-data">

                                    <div class="form-group mb-3">
                                        <label for="id_alat">Alat Laboratorium</label>
                                        <select
                                            class="form-control select2 <?=($validation->hasError('id_alat')) ? 'is-invalid' : ''?>"
                                            name="id_alat" id="id_alat">
                                            <option value="">Pilih Alat Laboratorium</option>
                                            <?php foreach ($alatlab as $atlab): ?>
                                            <option value="<?=$atlab->id_alat?>" <?= set_select('id_alat', $atlab->id_alat); ?>><?=$atlab->nama_alat?>
                                                (<?=$atlab->no_inventaris?>) - <?=$atlab->nama_ruang?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('id_alat');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="stok">Stok Ketersediaan Alat Laboratorium</label>
                                        <input type="text" id="stok" name="stok" class="form-control"
                                            placeholder="Jumlah Stok" value="" disabled />
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="jumlah_penghapusan">Jumlah Alat Laboratorium</label>
                                        <input type="number" id="jumlah_penghapusan" name="jumlah_penghapusan"
                                            class="form-control <?=($validation->hasError('jumlah_penghapusan')) ? 'is-invalid' : ''?>"
                                            placeholder="Masukkan Jumlah Alat Laboratorium yang Dihapus/Keluar" value="<?=set_value("jumlah_penghapusan")?>"/>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('jumlah_penghapusan');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tanggal_penghapusan">Tanggal Penghapusan Aset</label>
                                        <input type="date" id="tanggal_penghapusan" name="tanggal_penghapusan"
                                            class="form-control  <?=($validation->hasError('tanggal_penghapusan')) ? 'is-invalid' : ''?>" value="<?=set_value('tanggal_penghapusan')?>" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('tanggal_penghapusan');?>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit">
                                        Tambah
                                    </button>
                                    <a href="<?=base_url('simlab/penghapusan-aset');?>"
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

    <script>
    $(document).ready(function() {
        $('#id_alat').change(function() {
            let id_alat = $(this).val();
            $.ajax({
                url: "<?=base_url('simlab/penghapusan-aset/cek-stok');?>" + "/" + id_alat,
                method: "get",
                dataType: 'json',
                success: function(data) {
                    $('#stok').val(data.stok)
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                },
            });
        });
    });
    </script>
</main>

<?=$this->include('simlab/simlab_partial/dashboard/footer')?>