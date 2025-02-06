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
                                <strong class="card-title">Laporan Peminjaman Ruang Laboratorium</strong>
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
                                </div>
                                <button id="filter" class="btn btn-primary">Filter</button>
                                <button disabled id="download" class="btn btn-info" href="#">Download</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">Laporan Peminjaman Ruang Laboratorium</strong>
                            </div>

                            <div class="card-body">
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Peminjam</th>
                                            <th>NIM/NIP</th>
                                            <th>Ruang yang Dipinjam</th>
                                            <th>Keperluan</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Hari/Tanggal Peminjaman</th>
                                            <th>Waktu Peminjaman</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;?>
                                        <?php foreach ($pinjamruang as $pjr): ?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?php if ($pjr->nama_mahasiswa): ?>
                                                <?=$pjr->nama_mahasiswa?>
                                                <?php elseif ($pjr->nama_staff): ?>
                                                <?=$pjr->nama_staff?>
                                                <?php endif;?>
                                            </td>
                                            <td><?php if ($pjr->nim): ?>
                                                <?=$pjr->nim?>
                                                <?php elseif ($pjr->nip): ?>
                                                <?=$pjr->nip?>
                                                <?php endif;?>
                                            </td>
                                            <td><?=$pjr->nama_ruang?></td>
                                            <td><?=$pjr->keperluan?></td>
                                            <td><?=date('d M Y', round($pjr->tanggal_ajuan/1000))?></td>
                                            <td><?=$pjr->hari?>, <br>
                                                <?=date('d M Y', strtotime($pjr->tanggal_pinjam))?></td>
                                            <td><?=$pjr->waktu_mulai?> - <?=$pjr->waktu_selesai?> WIB</td>
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
            var tanggal_awal = $('#tanggal_awal').val();
            var tanggal_akhir = $('#tanggal_akhir').val();
            if (tanggal_awal == '' || tanggal_akhir == '') {
                Swal.fire('Error',
                    'Isi Semua Kolom Untuk Melakukan Filter Data Peminjaman Alat Laboratorium',
                    'error');
            }
            $.ajax({
                url: "<?=base_url('simlab/laporan/filter-peminjaman-ruang');?>" + "/" +
                    tanggal_awal +
                    "/" + tanggal_akhir,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('button#download').prop('disabled', false)
                    var data_awal = data;
                    $('#dataTable-1').DataTable().clear().destroy();
                    $.each(data, function(i, item) {
                        var updated_at = new Date(parseInt(item.updated_at,
                            10));
                        var formattedTanggalPerubahan = updated_at
                            .toLocaleDateString('en-GB', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric'
                            });

                        var nama_peminjam = item.nama_staff ?? item.nama_mahasiswa;
                        var nipnim = item.nip ?? item.nim;
                        $('#dataTable-1 tbody').append(
                            '<tr><td >' + ((i++) + 1) +
                            '</td><td>' + nama_peminjam +
                            '</td><td>' + nipnim +
                            '</td><td>' + item.nama_ruang +
                            '</td><td>' + item.keperluan +
                            '</td><td>' + formatDate(item.tanggal_ajuan) +
                            '</td><td>' + item.hari + ',' + formatDate2(item
                                .tanggal_pinjam) +
                            '</td><td>' + item.waktu_mulai + ' - ' + item
                            .waktu_selesai + ' WIB' +
                            '</td></tr>');
                    });
                    $('#dataTable-1').DataTable({
                        columnDefs: [{
                            targets: [0, 1, 2],
                            orderable: true,
                        }],
                    });
                },
            });
        });

        $('#download').on('click', function(event) {
            event.preventDefault();
            var tanggal_awal = $('#tanggal_awal').val();
            var tanggal_akhir = $('#tanggal_akhir').val();

            if (tanggal_awal == '' || tanggal_akhir == '') {
                Swal.fire('Error',
                    'Isi Semua Kolom Untuk Melakukan Filter Data Peminjaman Ruang Laboratorium',
                    'error');
            } else {
                var url = "<?=base_url('simlab/laporan/peminjaman-ruang/download-pdf/');?>" + "/" +
                    tanggal_awal + "/" + tanggal_akhir;
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

    function formatDate(dateString) {
        var date = new Date(parseInt(dateString, 10));
        return date.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }

    function formatDate2(dateString) {
        var date = new Date(dateString);
        return date.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }
    </script>

</main>

<?=$this->include('simlab/simlab_partial/dashboard/footer')?>