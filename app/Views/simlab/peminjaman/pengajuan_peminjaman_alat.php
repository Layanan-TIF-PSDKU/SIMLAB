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
                                <strong class="card-title">Form Pengajuan Peminjaman Alat Laboratorium</strong>
                            </div>
                            <div class="card-body">
                                <!-- table -->
                                <form method="POST"
                                    action="<?=base_url("simlab/pengajuan-peminjaman/alat-laboratorium/simpan")?>"
                                    enctype="multipart/form-data">

                                    <?php if (in_groups('mahasiswa')): ?>
                                    <input type="hidden" id="id_mahasiswa" name="id_mahasiswa"
                                        class="form-control <?=($validation->hasError('id_mahasiswa')) ? 'is-invalid' : ''?>"
                                        placeholder="Masukkan Nama" value="<?=$mahasiswa[0]->id_mhs?>" />
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
                                    <input type="hidden" id="id_staff" name="id_staff" class="form-control"
                                        value="<?=$staf[0]->id_staf?>" />
                                    <div class="form-group row">
                                        <label for="id_staff" class="col-sm-3 col-form-label">Nama Peminjam</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="id_staff" name="id_staff" class="form-control "
                                                value="<?=$staf[0]->nama?>" disabled />
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
                                        <label for="keperluan" class="col-sm-3 col-form-label">Keperluan</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="keperluan" name="keperluan"
                                                class="form-control <?=($validation->hasError('keperluan')) ? 'is-invalid' : ''?>"
                                                value="<?=set_value('keperluan')?>" placeholder="Isikan Keperluan" />
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
                                                value="<?=date("d/m/Y")?>" readonly />
                                        </div>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('tanggal_ajuan');?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tanggal_pinjam" class="col-sm-3 col-form-label">Tanggal
                                            Peminjaman</label>
                                        <div class="col-sm-9">
                                            <input type="date" id="tanggal_pinjam" name="tanggal_pinjam"
                                                class="form-control  <?=($validation->hasError('tanggal_pinjam')) ? 'is-invalid' : ''?>"
                                                value="<?=set_value('tanggal_pinjam')?>" />
                                        </div>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('tanggal_pinjam');?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tanggal_kembali" class="col-sm-3 col-form-label">Tanggal
                                            Kembali</label>
                                        <div class="col-sm-9 ">
                                            <input type="date" id="tanggal_kembali" name="tanggal_kembali"
                                                class="form-control <?=($validation->hasError('tanggal_kembali')) ? 'is-invalid' : ''?>"
                                                value="<?=set_value('tanggal_kembali')?>" />
                                        </div>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('tanggal_kembali');?>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="text-center">
                                        <h6>Data Alat Laboratorium</h6>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label for="id_alat">Alat Laboratorium</label>
                                            <select
                                                class="form-control select2 <?=($validation->hasError('id_alat')) ? 'is-invalid' : ''?>"
                                                name="id_alat" id="id_alat">
                                                <option value="">Pilih Alat Laboratorium</option>
                                                <?php foreach ($alatlab as $atlab): ?>
                                                <option value="<?=$atlab->id_alat?>"><?=$atlab->nama_alat?>
                                                    (<?=$atlab->no_inventaris?>) - <?=$atlab->nama_ruang?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <!-- Error Validation -->
                                            <div class="invalid-feedback">
                                                <?=$validation->getError('id_alat');?>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="stok">Stok</label>
                                            <input type="text" id="stok" name="stok" class="form-control"
                                                placeholder="Jumlah stok" value="" disabled />
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="jumlah_pinjam">Jumlah Pinjam</label>
                                            <input type="number" id="jumlah_pinjam" name="jumlah_pinjam" min="1"
                                                class="form-control" placeholder="Masukkan Jumlah Peminjaman"
                                                readonly />
                                        </div>
                                        <div class="form-group col-md-1">
                                            <label for="">&nbsp;</label>
                                            <button disabled type="button" class="btn mb-2 btn-info btn-block"
                                                id="tambah"><i class="fe fe-plus "></i></button>
                                        </div>
                                        <input type="hidden" name="satuan" id="satuan" value="">
                                    </div>

                                    <div class="detailpinjam">
                                        <table class="table " id="detailpinjam-body">
                                            <thead class="thead">
                                                <tr>
                                                    <th>Nama Alat</th>
                                                    <th>Nomor Inventaris</th>
                                                    <th>Ruang Laboratorium</th>
                                                    <th>Jumlah Pinjam</th>
                                                    <th>Satuan</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td id="nama_alat"></td>
                                                    <td id="no_inventaris"></td>
                                                    <td id="nama_ruang"></td>
                                                    <td id="jumlah_pinjam"></td>
                                                    <td id="satuan"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </form>
                                <input type="hidden" name="stok" value="">
                                <button class="btn btn-primary" type="submit">
                                    Tambah
                                </button>
                                <a href="<?=base_url('simlab/alat-laboratorium');?>" class="btn btn-warning">Kembali</a>
                            </div>
                        </div>

                    </div>
                </div> <!-- simple table -->
            </div>
            <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
    </div> <!-- .container-fluid -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#id_alat').change(function() {
            let id_alat = $(this).val();
            $.ajax({
                url: "<?=base_url('simlab/alatlab/getStokByAlat');?>" + "/" + id_alat,
                method: "post",
                dataType: 'json',
                success: function(data) {
                    $('#nama_alat').val(data.nama_alat);
                    $('#stok').val(data.stok)
                    $('#satuan').val(data.satuan)
                    $('#no_inventaris').val(data.no_inventaris)
                    $('#nama_ruang').val(data.nama_ruang)
                    $('#jumlah_pinjam').val(1)
                    $('#jumlah_pinjam').prop('readonly', false)
                    $('button#tambah').prop('disabled', false)

                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                },
            });
        });
    });
    </script>

    <script>
    $(document).on('click', '#tambah', function(e) {
        const namaAlat = $('#nama_alat').val();
        const idAlat = $('#id_alat').val();
        const noInventaris = $('#no_inventaris').val();
        const namaRuang = $('#nama_ruang').val();
        const jumlahPinjam = $('#jumlah_pinjam').val();
        const satuan = $('#satuan').val();

        if (parseInt($('#stok').val()) < parseInt(jumlahPinjam)) {
            Swal.fire('Error', 'Stok tidak tersedia!', 'error');
        } else {
            const newRow = `
            <tr class="row-detailpinjam">
                    <td class="id_alat" hidden><input type="hidden" name="id_alat[]" value="${idAlat}"></td>
                    <td class="nama_alat">${namaAlat}<input type="hidden" value="${namaAlat}"></td>
                    <td class="no_inventaris">${noInventaris}<input type="hidden" name="no_inventaris[]" value="${noInventaris}"></td>
                    <td class="nama_ruang">${namaRuang}<input type="hidden" name="nama_ruang[]" value="${namaRuang}"></td>
                    <td class="jumlah_pinjam">${jumlahPinjam}<input type="hidden" name="jumlah_pinjam[]" value="${jumlahPinjam}"></td>
                    <td class="satuan">${satuan.toUpperCase()}<input type="hidden" name="satuan[]" value="${satuan}"></td>
                    <td class="aksi">
                        <button type="button" class="btn btn-danger btn-sm tombol-hapus" data-nama-barang="${namaAlat}"><i class="fe fe-trash"></i></button>
                    </td>
                </tr>
            `;
            $('#detailpinjam-body').append(newRow);

            reset();
        }
    });

    $(document).on('click', '.tombol-hapus', function(e) {
        $(this).closest('.row-detailpinjam').remove();
    });

    function reset() {
        $('#nama_alat').val('').trigger('change');
        $('#no_inventaris').val('').trigger('change');
        $('#nama_ruang').val('').trigger('change');
        $('#jumlah_pinjam').val('').trigger('change');
        $('#satuan').val('').trigger('change');
        $('button#tambah').prop('disabled', true)
    }
    </script>
</main>


<?=$this->include('simlab/simlab_partial/dashboard/footer')?>