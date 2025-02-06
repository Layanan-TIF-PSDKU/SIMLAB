<?php
echo $this->include('simta/simta_partial/dashboard/header');
echo $this->include('simta/simta_partial/dashboard/top_menu');
if (has_permission('admin')):
    echo $this->include('master_partial/dashboard/side_menu');
else:
    echo $this->include('simta/simta_partial/dashboard/side_menu');
endif;
?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="mt-2 page-title">Halaman Detail Pengajuan Judul Tugas Akhir</h2>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Detail Pengajuan Judul Tugas Akhir</li>
                            </ol>
                        </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Detail Pengajuan Judul Tugas Akhir</li>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row my-3">
                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <th>Nama Mahasiswa</th>
                                            <td><?php foreach($mahasiswa as $mhs) {
                                                echo ($pengajuanjudul->id_mhs == $mhs->id_mhs) ? $mhs->nama : ''; } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>NIM Mahasiswa</th>
                                            <td><?php foreach($mahasiswa as $mhs) {
                                                echo ($pengajuanjudul->id_mhs == $mhs->id_mhs) ? $mhs->nim  : ''; } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Kelas</th>
                                            <td><?php foreach($mahasiswa as $mhs) {
                                                echo ($pengajuanjudul->id_mhs == $mhs->id_mhs) ? $mhs->kelas : ''; } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Angkatan</th>
                                            <td><?php foreach($mahasiswa as $mhs) {
                                                echo ($pengajuanjudul->id_mhs == $mhs->id_mhs) ? $mhs->th_masuk : ''; } ?>
                                            </td>
                                        </tr>
                                        <tr>    
                                            <th>Nama Dosen Pembimbing</th>
                                            <td><?php foreach($staf as $s) {
                                                echo ($pengajuanjudul->id_staf == $s->id_staf) ? $s->nama : ''; } ?>
                                            </td>
                                        </tr> 
                                        <tr>
                                            <th>Nama Judul Tugas Akhir 1</th>
                                            <td><?=$pengajuanjudul->nama_judul1?></td>
                                        </tr>
                                        <tr>
                                            <th>Deskripsi Sistem 1</th>
                                            <td><?=$pengajuanjudul->deskripsi_sistem1?></td>
                                        </tr>
                                        <tr>
                                            <th>Nama Judul Tugas Akhir 2</th>
                                            <td><?=$pengajuanjudul->nama_judul2?></td>
                                        </tr>
                                        <tr>
                                            <th>Deskripsi Sistem 2</th>
                                            <td><?=$pengajuanjudul->deskripsi_sistem2?></td>
                                        </tr>
                                        </tr>
                                            <th>Nama Judul Tugas Akhir 3</th>
                                            <td><?=$pengajuanjudul->nama_judul3?></td>
                                        </tr>
                                        <tr>
                                            <th>Deskripsi Sistem 3</th>
                                            <td><?=$pengajuanjudul->deskripsi_sistem3?></td>
                                        </tr>
                                        <tr>
                                            <th>Catatan</th>
                                            <td><?=$pengajuanjudul->catatan?></td>
                                        </tr>
                                        <tr>
                                            <th>Status Hasil</th>
                                            <td><?=$pengajuanjudul->status_pj?></td>
                                        </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Small table -->
                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table datatables" id="dataTable-1">
                                        <!-- konten tabel -->
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Nama Dosen</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($rekomendasi as $r) :
                                            ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?=$r->nama_rekomendasi?></td>
                                                <td>
                                                    <?php foreach($staf as $s) {
                                                        echo ($r->id_staf == $s->id_staf) ? $s->nama : ''; } ?>
                                                </td>
                                            </tr>
                                            <?php endforeach?>
                                        </tbody>
                                    </table>
                                    <?php if(has_permission('admin') || has_permission('koor-simta')) : ?>
                                        <a href="<?=base_url('simta/pengajuanjudul/editstatus/'. $pengajuanjudul->id_pengajuanjudul);?>" class="btn btn-primary">Input Hasil</a>
                                        <a href="<?=base_url('simta/pengajuanjudul/editpembimbing/' . $pengajuanjudul->id_pengajuanjudul);?>" class="btn btn-info">Tambah Dosen Pembimbing</a>
                                    <?php endif; ?>
                                    <a href="<?=base_url('simta/pengajuanjudul');?>" class="btn btn-warning">Kembali</a>
                                </div> <!-- end section -->
                            </div> <!-- .col-12 -->
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</main>

<?php echo $this->include('simta/simta_partial/dashboard/footer'); ?>

