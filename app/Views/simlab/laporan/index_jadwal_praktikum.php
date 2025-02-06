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
                                <strong class="card-title">Laporan Penggunaan Ruang untuk Mata Kuliah Praktikum</strong>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="tahun_ajaran"><strong>Tahun Ajaran</strong></label>
                                            <select name="tahun_ajaran" id="tahun_ajaran" class="form-control select2">
                                                <option value="">Pilih Tahun Ajaran</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="semester"><strong>Semester</strong></label>
                                            <select class="form-control" name="semester" id="semester">
                                                <option value="">Pilih Semester</option>
                                                <option value="A (Ganjil)">A (Ganjil)</option>
                                                <option value="B (Genap)">B (Genap)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="id_ruang"><strong>Ruang Laboratorium</strong></label>
                                            <select class="form-control" name="id_ruang" id="id_ruang">
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
                                <strong class="card-title">Laporan Penggunaan Ruang untuk Mata Kuliah Praktikum</strong>
                            </div>

                            <div class="card-body">
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Ruang Laboratorium</th>
                                            <th>Hari</th>
                                            <th>Waktu</th>
                                            <th>Mata Kuliah</th>
                                            <th>Kelas</th>
                                            <th>Tahun Ajaran</th>
                                            <th>Semester</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;?>
                                        <?php foreach ($jadwal as $jw): ?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$jw->nama_ruang?></td>
                                            <td><?=$jw->hari?></td>
                                            <td><?=$jw->waktu_mulai?> - <?=$jw->waktu_selesai?> WIB</td>
                                            <td><?=$jw->nama_mata_kuliah?></td>
                                            <td><?=$jw->kelas?></td>
                                            <td><?=$jw->tahun_ajaran?></td>
                                            <td><?=$jw->semester?></td>
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
    <script>
    $(document).ready(function() {
        $('#filter').on('click', function(event) {
            event.preventDefault();
            var id_ruang = $('#id_ruang').val();
            var tahun_ajaran = $('#tahun_ajaran').val();
            var semester = $('#semester').val();

            if (id_ruang == '' || tahun_ajaran == '' || semester == '') {
                Swal.fire('Error',
                    'Isi Semua Kolom Untuk Melakukan Filter Data Penggunaan Ruang Labboratorium',
                    'error');
            }
            $.ajax({
                url: "<?=base_url('simlab/laporan/filter-jadwal-praktikum');?>" + "/" +
                    id_ruang +
                    "/" + tahun_ajaran + "/" + semester,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('button#download').prop('disabled', false)
                    var data_awal = data;
                    $('#dataTable-1').DataTable().clear().destroy();
                    $.each(data, function(i, item) {
                        $('#dataTable-1 tbody').append(
                            '<tr><td >' + ((i++) + 1) + '</td><td>' + item
                            .nama_ruang + '</td><td>' + item.hari +
                            '</td><td>' + item.waktu_mulai + '-' + item
                            .waktu_selesai + 'WIB' + '</td><td>' +
                            item.nama_mata_kuliah + '</td><td>' + item.kelas +
                            '</td><td>' + item.tahun_ajaran + '</td><td>' + item
                            .semester + '</td></tr>');
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
            var tahun_ajaran = $('#tahun_ajaran').val();
            var semester = $('#semester').val();

            if (id_ruang == '' || tahun_ajaran == '' || semester == '') {
                Swal.fire('Error',
                    'Isi Semua Kolom Untuk Melakukan Filter Data Penggunaan Ruang Labboratorium',
                    'error');
            } else {
                var url = "<?=base_url('simlab/laporan/ruang-praktikum/download-pdf/');?>" + "/" +
                    id_ruang + "/" + tahun_ajaran + "/" + semester;
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
    <script>
    var select = document.getElementById("tahun_ajaran");
    var currentYear = new Date().getFullYear();

    for (var year = currentYear; year >= 2020; year--) {
        var option = document.createElement("option");
        option.text = year;
        option.value = year;
        select.add(option);
    }
    </script>
</main>

<?=$this->include('simlab/simlab_partial/dashboard/footer')?>