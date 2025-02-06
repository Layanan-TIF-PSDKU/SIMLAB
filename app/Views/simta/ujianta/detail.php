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
                        <h2 class="mt-2 page-title">Halaman Detail Ujian Tugas Akhir</h2>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Detail Ujian Tugas Akhir</li>
                            </ol>
                        </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Detail Ujian Tugas Akhir</li>
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
                                        <?php foreach($ujianta as $ujita) : ?>
                                            <tr>
                                                <th>Nama Mahasiswa</th>
                                                <td>
                                                    <?php 
                                                    // foreach($mahasiswa as $mhs) {
                                                    //     echo ($ujianproposal->id_mhs == $mhs->id_mhs) ? $mhs->nama : '';
                                                    // }
                                                    echo $ujita->nama_mhs;
                                                ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>NIM Mahasiswa</th>
                                                <td>
                                                    <?php 
                                                    // foreach($mahasiswa as $mhs) {
                                                    //     echo ($ujianproposal->id_mhs == $mhs->id_mhs) ? $mhs->nama : '';
                                                    // }
                                                    echo $ujita->nim;
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
                                                    echo $ujita->kelas;
                                                ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Angkatan</th>
                                                <td>
                                                    <?php 
                                                    // foreach($mahasiswa as $mhs) {
                                                    //     echo ($ujianproposal->id_mhs == $mhs->id_mhs) ? $mhs->nama : '';
                                                    // }
                                                    echo $ujita->th_masuk;
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
                                                    echo $ujita->nama;
                                                    ?>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <th>Nama Judul Tugas Akhir</th>
                                                <td>
                                                    <?= $ujita->nama_judul ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Abstrak</th>
                                                <td>
                                                    <?= $ujita->abstrak ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Jadwal Ujian</th>
                                                <td>
                                                    <?= date('d M Y', round($ujita->tanggal/1000)) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Ruangan Ujian</th>
                                                <td>
                                                    <?= $ujita->ruangan ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Waktu Ujian</th>
                                                <td>
                                                    <?= date('H:i', round($ujita->jam_mulai/1000)) ?> WIB
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Jam Selesai</th>
                                                <td>
                                                    <?= date('H:i', round($ujita->jam_selesai/1000)) ?> WIB
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Status Ajuan</th>
                                                <td>
                                                    <?= $ujita->status_ajuan ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Status Hasil</th>
                                                <td>
                                                    <?= $ujita->status_ut ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Nilai</th>
                                                <td>
                                                    <?= $ujita->nilai_totalujian ?>
                                                </td>
                                            </tr>
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
                                    <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Nama Dosen</th>
                                                <?php if(has_permission('admin') || has_permission('koor-simta')) : ?>
                                                <th>Nilai</th>
                                                <?php endif; ?>
                                                <th>Catatan</th>
                                                <th>Status</th>
                                                <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                                                <th>Action</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($penguji as $pup) :
                                        ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?=$pup->nama_penguji?></td>
                                                <td>
                                                    <?php echo $pup->nama;  ?>
                                                </td>
                                                <?php if(has_permission('admin') || has_permission('koor-simta')) : ?>
                                                <td><?=$pup->nilai_ujianta?></td>
                                                <?php endif; ?>
                                                <td><?=$pup->catatan?></td>
                                                <td><?=$pup->status_ut?></td>
                                                <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                                                    <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <?php if(has_permission('admin') || has_permission('koor-simta')) :?>
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("simta/ujianta/editpengujiujianta/$pup->id_penguji_ujianta");?>">
                                                            Edit</a>
                                                        <?php endif; ?>
                                                    <?php if(has_permission('dosen')) :?>
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("simta/ujianta/editstatus/$pup->id_penguji_ujianta");?>">
                                                            Penilaian</a>
                                                            <?php endif; ?>
                                                    </div>
                                                </td><?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach?>
                                        </tbody>
                                        <div class="col-md-6">
                                            <div class="card shadow">
                                                <div class="card-body">
                                                    <?php foreach($ujianta as $ujita) : ?>
                                                        <h5>Proposal Tugas Akhir</h5>
                                                            <p>Harap membawa Laporan 4 Eksemplar sebelum ujian.</p>
                                                        <p>
                                                            <?php if($ujita->proposalakhir == null) : ?>
                                                                <span class="badge badge-primary text-uppercase">belum diupload</span>
                                                                <?php else : ?>
                                                                    <a href="<?= base_url('simta/ujianta/download_proposalakhir/' . $ujita->id_ujianta); ?>">Download</a>
                                                            <?php endif; ?>
                                                        </p>
                                                        <h5>Berita Acara KMM</h5>
                                                        <p>
                                                            <?php if($ujita->berita_acarakmm == null) : ?>
                                                                <span class="badge badge-primary text-uppercase">belum diupload</span>
                                                                <?php else : ?>
                                                                    <a href="<?= base_url('simta/ujianta/download_berita_acarakmm/' . $ujita->id_ujianta); ?>">Download</a>
                                                            <?php endif; ?>
                                                        </p>
                                                        <h5>KRS</h5>
                                                        <p>
                                                            <?php if($ujita->krs == null) : ?>
                                                                <span class="badge badge-primary text-uppercase">belum diupload</span>
                                                                <?php else : ?>
                                                                    <a href="<?= base_url('simta/ujianta/download_krs/' . $ujita->id_ujianta); ?>">Download</a>
                                                            <?php endif; ?>
                                                        </p>
                                                        <h5>Transkrip Nilai</h5>
                                                        <p>
                                                            <?php if($ujita->transkrip_nilai == null) : ?>
                                                                <span class="badge badge-primary text-uppercase">belum diupload</span>
                                                                <?php else : ?>
                                                                    <a href="<?= base_url('simta/ujianta/download_transkripnilai/' . $ujita->id_ujianta); ?>">Download</a>
                                                            <?php endif; ?>
                                                        </p>
                                                        <h5>Rekomendasi Dosen Pembimbing</h5>
                                                        <p>
                                                            <?php if($ujita->rekomendasi_dospem == null) : ?>
                                                                <span class="badge badge-primary text-uppercase">belum diupload</span>
                                                                <?php else : ?>
                                                                    <a href="<?= base_url('simta/ujianta/download_rekomendasi_dospem/' . $ujita->id_ujianta); ?>">Download</a>
                                                            <?php endif; ?>
                                                        </p>
                                                        <h5>Revisi Proposal</h5>
                                                        <p>
                                                            <?php if($ujita->revisi_proposal == null) : ?>
                                                                <span class="badge badge-primary text-uppercase">belum diupload</span>
                                                            <?php else : ?>
                                                                <a href="<?= base_url('simproposal/ujianta/download_revisi_proposal/' . $ujita->id_ujianta); ?>">Download</a>
                                                            <?php endif; ?>
                                                        </p>
                                                    <?php endforeach?>
                                                </div>
                                            </div>
                                        </div>
                                    </table>
                                </div>
                                <?php if(has_permission('admin') || has_permission('koor-simta')) : ?>
                                    <a href="<?=base_url('simta/penilaianakhir/editsidang/' . $ujita->id_ujianproposal );?>" class="btn btn-primary">Input Nilai</a>
                                <?php endif; ?>
                                    <a href="<?=base_url('simta/ujianta');?>" class="btn btn-warning">Kembali</a>
                            </div> <!-- end section -->
                        </div> <!-- .col-12 -->
                    </div>
                </div>
            </div>
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</main>

<?php echo $this->include('simta/simta_partial/dashboard/footer'); ?>