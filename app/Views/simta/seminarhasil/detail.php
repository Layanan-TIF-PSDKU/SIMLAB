<?php echo $this->include('simta/simta_partial/dashboard/header'); ?>
<?php echo $this->include('simta/simta_partial/dashboard/top_menu'); ?>
<?php if (has_permission('admin')): ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else: ?>
<?php echo $this->include('simta/simta_partial/dashboard/side_menu') ?>
<?php endif;?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="mt-2 page-title">Halaman Detail Seminar Hasil Tugas Akhir</h2>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Detail Seminar Hasil</li>
                            </ol>
                        </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Detail Seminar Hasil</li>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row my-3">
                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <tbody>
                                    <table class="table">
                                        <?php foreach($seminarhasil as $semhas) : ?>
                                            <tr>
                                                <th>Nama Mahasiswa</th>
                                                <td>
                                                    <?php 
                                                    // foreach($mahasiswa as $mhs) {
                                                    //     echo ($ujianproposal->id_mhs == $mhs->id_mhs) ? $mhs->nama : '';
                                                    // }
                                                    echo $semhas->nama_mhs;
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>NIM Mahasiswa</th>
                                                <td>
                                                    <?php 
                                                    // foreach($mahasiswa as $mhs) {
                                                    //     echo ($ujianproposal->id_mhs == $mhs->id_mhs) ? $mhs->kelas : '';
                                                    // } 
                                                    echo $semhas->nim;
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Kelas</th>
                                                <td>
                                                    <?php 
                                                    // foreach($mahasiswa as $mhs) {
                                                    //     echo ($ujianproposal->id_mhs == $mhs->id_mhs) ? $mhs->kelas : '';
                                                    // } 
                                                    echo $semhas->kelas;
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Angkatan</th>
                                                <td>
                                                    <?php 
                                                    // foreach($mahasiswa as $mhs) {
                                                    //     echo ($ujianproposal->id_mhs == $mhs->id_mhs) ? $mhs->kelas : '';
                                                    // } 
                                                    echo $semhas->th_masuk;
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>    
                                                <th>Nama Dosen Pembimbing</th>
                                                <td>
                                                    <?php 
                                                    // foreach($staf as $s) {
                                                    //     echo ($ujianproposal->id_staf == $s->id_staf) ? $s->nama : '';
                                                    // } 
                                                    echo $semhas->nama;
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr> 
                                                <th>Nama Judul Tugas Akhir</th>
                                                <td>
                                                    <?=$semhas->nama_judul ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Abstrak</th>
                                                <td>
                                                    <?=$semhas->abstrak ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Jadwal Ujian</th>
                                                <td>
                                                    <?= date('d M Y', round($semhas->jadwal_semhas/1000)) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Ruangan Ujian</th>
                                                <td>
                                                    <?= $semhas->ruang_semhas ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Waktu Ujian</th>
                                                <td>
                                                    <?= date('H:i', round($semhas->jam_mulai/1000)) ?> WIB
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Jam Selesai</th>
                                                <td>
                                                    <?= date('H:i', round($semhas->jam_selesai/1000)) ?> WIB
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Status Ajuan</th>
                                                <td>
                                                    <?= $semhas->status_ajuan ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Status Hasil</th>
                                                <td>
                                                    <?= $semhas->status_sh ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Catatan</th>
                                                <td>
                                                    <?= $semhas->catatan ?>
                                                </td>
                                            </tr>
                                            <?php if(has_permission('admin') || has_permission('koor-simta')) : ?>
                                                <tr>
                                                    <th>Nilai</th>
                                                    <td>
                                                        <?= $semhas->nilai_total ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </table>
                                <tbody>
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
                                        <?php foreach($seminarhasil as $semhas) : ?>
                                            <h5>Laporan Tugas Akhir</h5>
                                            <p>Harap membawa Laporan 2 Eksemplar sebelum ujian.</p>
                                            <p>
                                                <?php if($semhas->proposal_seminarhasil == null) : ?>
                                                    <span class="badge badge-primary text-uppercase">belum diupload</span>
                                                <?php else : ?>
                                                    <a href="<?= base_url('simta/seminarhasil/download_proposal_seminarhasil/' . $semhas->id_seminarhasil); ?>">Download</a>
                                                <?php endif; ?>
                                            </p>
                                            <h5>Revisi Proposal</h5>
                                            <p>
                                                <?php if($semhas->revisi_proposal == null) : ?>
                                                    <span class="badge badge-primary text-uppercase">belum diupload</span>
                                                <?php else : ?>
                                                    <a href="<?= base_url('simta/seminarhasil/download_revisi_proposal/' . $semhas->id_seminarhasil); ?>">Download</a>
                                                <?php endif; ?>
                                             </p>
                                        <?php endforeach?>
                                    </table>
                                </div>
                                <!-- Small table -->
                                <?php if(has_permission('admin') || has_permission('koor-simta')) : ?>
                                    <a href="<?=base_url('simta/penilaianakhir/editsemhas/' . $semhas->id_ujianproposal );?>" class="btn btn-primary">Input Nilai</a>
                                <?php endif; ?>
                                <a href="<?=base_url('simta/seminarhasil');?>" class="btn btn-warning">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</main>

<?php echo $this->include('simta/simta_partial/dashboard/footer'); ?>