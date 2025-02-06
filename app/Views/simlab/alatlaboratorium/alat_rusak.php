<?=$this->include('simlab/simlab_partial/dashboard/header')?>
<?=$this->include('simlab/simlab_partial/dashboard/top_menu')?>
<?=$this->include('simlab/simlab_partial/dashboard/side_menu')?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- Small table -->
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Halaman <?=$title?></h2>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a href="<?=base_url('simlab')?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Alat Laboratorium Rusak</li>
                        </ol>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-body">
                        <!-- table -->
                        <table class="table datatables" role="grid" id="dataTable-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Alat</th>
                                    <th>Nomor Inventaris</th>
                                    <th>Gambar</th>
                                    <th>Jumlah</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;?>
                                <?php foreach ($alatlab as $alatlab): ?>
                                <tr>
                                    <td><?=$no++?></td>
                                    <td><?=$alatlab->nama_alat?></td>
                                    <td><?=$alatlab->no_inventaris?></td>
                                    <td><img src="<?=base_url("../simlab_assets/alat-laboratorium/$alatlab->gambar")?>"
                                            style="width:120px; height:120px; object-fit:cover"></td>
                                    <td><?=$alatlab->jumlah_masuk?> <?=$alatlab->satuan?></td>
                                    <td>
                                        <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                            data-target="#detaildataalatlab" data-id="<?=$alatlab->id_alat?>">
                                            <i class="fe fe-alert-circle fe-16"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->

    <!-- Modal Detail ALat Laboratorium Rusak -->
    <div class="modal fade" id="detaildataalatlab" tabindex="-1" aria-labelledby="defaultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="defaultModalLabel">Detail Alat Laboratorium</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="content-wrapper">
                        <div class="card-body">
                            <div class="text-center">
                                <h6 id="nama_alat"></h6>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <div id="gambar" style="margin-top:20px; margin-left:auto; object-fit:cover"></div>
                                </div>
                                <div class="form-group col-md-7">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th>Nomor Inventaris</th>
                                            <td id="no_inventaris"></td>
                                        </tr>
                                        <tr>
                                            <th>Kategori</th>
                                            <td id="nama_kategori"></td>
                                        </tr>
                                        <tr>
                                            <th>Letak</th>
                                            <td id="nama_ruang"></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Perubahan Kondisi</th>
                                            <td id="tanggal_perubahan"></td>
                                        </tr>
                                        <tr>
                                            <th>Jumlah</th>
                                            <td id="jumlah_masuk"></td>
                                        </tr>
                                        <tr>
                                            <th>Satuan</th>
                                            <td id="satuan"></td>
                                        </tr>
                                        <tr>
                                            <th>Kondisi</th>
                                            <td id="kondisi"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn mb-2 btn-warning" data-dismiss="modal">Tutup</button>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                $(document).on('click', 'button[data-target="#detaildataalatlab"]', function() {
                    var id = $(this).attr('data-id');
                    $.ajax({
                        url: "<?=base_url('simlab/alat-laboratorium/detail');?>" + "/" + id,
                        method: "GET",
                        dataType: 'json',
                        success: function(data) {
                            $('#nama_alat').html(data.nama_alat)
                            if (data.nama_kategori === 'Barang Habis Pakai') {
                                $('#no_inventaris').html('-');
                            } else {
                                $('#no_inventaris').html(data.no_inventaris);
                            }
                            $('#nama_kategori').html(data.nama_kategori)
                            $('#nama_ruang').html(data.nama_ruang)
                            $('#tanggal_perubahan').html(data.tanggal_perubahan);
                            $('#jumlah_masuk').html(data.jumlah_masuk)
                            $('#satuan').html(data.satuan)
                            $('#kondisi').html(data.kondisi)
                            $('#gambar').html("<img src='../../simlab_assets/alat-laboratorium/" +
                                data.gambar + "'width='250px' height='250px'>")
                        }
                    });
                });
                </script>


</main>
<?=$this->include('simlab/simlab_partial/dashboard/footer')?>