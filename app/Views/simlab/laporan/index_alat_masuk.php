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
                    <div class="col-md-12 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">Laporan Alat Laboratorium Masuk</strong>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="tanggal_awal"><strong>Dari</strong></label>
                                            <input class="form-control" id="tanggal_awal" type="date"
                                                name="tanggal_awal">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="tanggal_akhir"><strong>Ke</strong></label>
                                            <input class="form-control" id="tanggal_akhir" type="date"
                                                name="tanggal_akhir">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="id_ruang"><strong>Ruang Laboratorium</strong></label>
                                            <select class="form-control select2" name="id_ruang" id="id_ruang">
                                                <option value="">Pilih Ruang Laboratorium</option>
                                                <?php foreach ($ruanglab as $rlab): ?>
                                                <option value="<?=$rlab->id_ruang?>"><?=$rlab->nama_ruang?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button id="filter" class="btn btn-primary">Filter</button>
                                <button disabled id="download" class="btn btn-info" href="#">Download</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">Laporan Alat Laboratorium Masuk</strong>
                            </div>

                            <div class="card-body">
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori</th>
                                            <th>Nama Alat Laboratorium</th>
                                            <th>Nomor Inventaris</th>
                                            <th>Letak/Ruang</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Jumlah Masuk</th>
                                            <th>Satuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;?>
                                        <?php foreach ($alatlab as $alatlab): ?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$alatlab->nama_kategori?></td>
                                            <td><?=$alatlab->nama_alat?></td>
                                            <td><?php if ($alatlab->nama_kategori == 'Peralatan'): ?>
                                                <?=$alatlab->no_inventaris?>
                                                <?php elseif ($alatlab->nama_kategori == 'Barang Habis Pakai'): ?>
                                                -
                                                <?php endif;?>
                                            </td>
                                            <td><?=$alatlab->nama_ruang?></td>
                                            <td><?=$alatlab->tanggal_masuk?></td>
                                            <td><?=$alatlab->jumlah_masuk?></td>
                                            <td><?=$alatlab->satuan?></td>
                                        </tr>
                                        <?php endforeach?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div> <!-- simple table -->
    </div> <!-- end section -->
    </div> <!-- .col-12 -->
    </div> <!-- .row -->
    </div> <!-- .container-fluid -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Tambahkan library Dompdf -->
    <script>
    $(document).ready(function() {
        $('#filter').on('click', function(event) {
            event.preventDefault();
            var id_ruang = $('#id_ruang').val();
            var tanggal_awal = $('#tanggal_awal').val();
            var tanggal_akhir = $('#tanggal_akhir').val();
            if (tanggal_awal == '' || tanggal_akhir == '' || id_ruang == '') {
                Swal.fire('Error', 'Isi Semua Kolom Untuk Melakukan Filter Data Alat Masuk', 'error');
            }
            $.ajax({
                url: "<?=base_url('simlab/laporan/filter-alat-masuk');?>" + "/" + id_ruang +
                    "/" + tanggal_awal + "/" + tanggal_akhir,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('button#download').prop('disabled', false)
                    var data_awal = data;
                    $('#dataTable-1').DataTable().clear().destroy();
                    $.each(data, function(i, item) {
                        $('#dataTable-1 tbody').append(
                            '<tr><td >' + ((i++) + 1) + '</td><td>' + item
                            .nama_kategori + '</td><td>' + item
                            .nama_alat + '</td><td>' + item.no_inventaris +
                            '</td><td>' + item.nama_ruang + '</td><td>' +
                            item.tanggal_masuk + '</td><td>' + item
                            .jumlah_masuk + '</td><td>' + item.satuan +
                            '</td></tr>');
                    });
                    $('#dataTable-1').DataTable({
                        columnDefs: [{
                            targets: [0, 1, 2, 3, 4],
                            orderable: true,
                        }],
                    });

                },
            });
        });

        $('#download').on('click', function(event) {
            event.preventDefault();
            var id_ruang = $('#id_ruang').val();
            var tanggal_awal = $('#tanggal_awal').val();
            var tanggal_akhir = $('#tanggal_akhir').val();

            if (tanggal_awal == '' || tanggal_akhir == '' || id_ruang == '') {
                Swal.fire('Error', 'Isi Semua Kolom Untuk Melakukan Filter Data Alat Masuk',
                    'error');
            } else {
                var url = "<?=base_url('simlab/laporan/alat-masuk/download-pdf/');?>" + "/" +
                    id_ruang +
                    "/" + tanggal_awal + "/" + tanggal_akhir;

                $.ajax({
                    url: url,
                    method: 'get',
                    success: function() {
                        window.open(url);
                    },
                    error: function() {
                        Swal.fire('Error',
                            'Data yang difilter tidak ada, tidak bisa melakukan download.',
                            'error');
                    }
                });
            }
        });
    });
    </script>

</main>

<?=$this->include('simlab/simlab_partial/dashboard/footer')?>