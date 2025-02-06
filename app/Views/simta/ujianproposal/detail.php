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
                        <h2 class="mt-2 page-title">Halaman Detail Ujian Proposal Tugas Akhir</h2>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Detail Ujian Proposal</li>
                            </ol>
                        </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Detail Ujian Proposal</li>
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
                                        <?php foreach($ujianproposal as $ujipro) : ?>
                                            <tr>
                                                <th>Nama Mahasiswa</th>
                                                <td>
                                                    <?php 
                                                    // foreach($mahasiswa as $mhs) {
                                                    //     echo ($ujianproposal->id_mhs == $mhs->id_mhs) ? $mhs->nama : '';
                                                    // }

                                                    echo $ujipro->nama_mhs;
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

                                                    echo $ujipro->nim;
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
                                                    echo $ujipro->kelas;
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

                                                    echo $ujipro->th_masuk;
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
                                                    echo $ujipro->nama;
                                                    ?>
                                                </td>
                                            </tr> 
                                                <th>Nama Judul Tugas Akhir</th>
                                                <td>
                                                    <?= $ujipro->nama_judul ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Abstrak</th>
                                                <td>
                                                    <?= $ujipro->abstrak ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Jadwal Ujian</th>
                                                <td>
                                                    <?= date('d M Y', round($ujipro->tanggal/1000)) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Ruangan Ujian</th>
                                                <td>
                                                    <?= $ujipro->ruang_sempro ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Waktu Ujian</th>
                                                <td>
                                                    <?= date('H:i', round($ujipro->jam_mulai/1000)) ?> WIB
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Jam Selesai</th>
                                                <td>
                                                    <?= date('H:i', round($ujipro->jam_selesai/1000)) ?> WIB
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Status Ajuan</th>
                                                <td> 
                                                    <?= $ujipro->status_ajuan ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Status Hasil</th>
                                                <td>
                                                    <?= $ujipro->status_up ?>
                                                </td>
                                            </tr>
                                            <?php if(has_permission('admin') || has_permission('koor-simta')) : ?>
                                                <tr>
                                                    <th>Nilai</th>
                                                    <td>
                                                        <?= $ujipro->nilai_totalujian ?>
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
                                            <td><?=$pup->nilai_ujianproposal?></td>
                                            <?php endif; ?>
                                            <td><?=$pup->catatan?></td>
                                            <td><?=$pup->status_up?></td>
                                            <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                                                <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <?php if(has_permission('admin') || has_permission('koor-simta')) :?>
                                                            <a class="dropdown-item" href="<?=base_url("simta/ujianproposal/editpengujiujianproposal/$pup->id_penguji_ujianproposal");?>">Edit</a>
                                                        <?php endif; ?>
                                                        <?php if(has_permission('dosen')) :?>
                                                        <?php foreach ($ujianproposal as $ujipro) {
                                                            $tanggal_ujian = date('d F Y',($ujipro->tanggal/1000));
                                                            $tanggal = strtotime($tanggal_ujian);
                                                            helper(['date']);
                                                            $t = now('Asia/Jakarta');
                                                            $time = date('d F Y', $t);
                                                            $tanggal_sekarang = strtotime($time);
                                                            // var_dump($tanggal);
                                                            // var_dump($tanggal_sekarang);
                                                            if ($ujipro->$tanggal = $tanggal_sekarang) { ?>
                                                                <a class="dropdown-item" href="<?= base_url("simta/ujianproposal/editstatus/$pup->id_penguji_ujianproposal"); ?>">Penilaian</a>
                                                            <?php }
                                                        } ?>   
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                        <?php endforeach?>
                                    </tbody>
                                    <div class="col-md-6">
                                        <div class="card shadow">
                                            <div class="card-body">
                                                <?php foreach($ujianproposal as $ujipro) : ?>
                                                    <h5>Proposal Tugas Akhir</h5>
                                                    <p>Harap membawa Laporan 3 Eksemplar sebelum ujian.</p>
                                                    <p>
                                                        <?php if($ujipro->proposalawal == null) : ?>
                                                            <span class="badge badge-primary text-uppercase">belum diupload</span>
                                                                <?php else : ?>
                                                                    <a href="<?= base_url('simta/ujianproposal/download_proposalawal/' . $ujipro->id_ujianproposal); ?>">Download</a>
                                                                <?php endif; ?>
                                                    </p>
                                                    <h5>Revisi Proposal</h5>
                                                    <p>
                                                        <?php if($ujipro->revisi_proposal == null) : ?>
                                                            <span class="badge badge-primary text-uppercase">belum diupload</span>
                                                                <?php else : ?>
                                                                    <a href="<?= base_url('simta/ujianproposal/download_revisi_proposal/' . $ujipro->id_ujianproposal); ?>">Download</a>
                                                                <?php endif; ?>
                                                    </p>
                                                <?php endforeach?>
                                            </div>
                                        </div>
                                    </div>
                                </table>
                            </div>
                            <?php if(has_permission('admin') || has_permission('koor-simta')) : ?>
                                <a href="<?=base_url('simta/penilaianakhir/tambah/'  . $ujipro->id_ujianproposal);?>" class="btn btn-primary">Input Nilai</a>
                            <?php endif; ?>
                            <a href="<?=base_url('simta/ujianproposal');?>" class="btn btn-warning">Kembali</a>
                        </div> <!-- end section -->
                        </div> <!-- .col-12 -->
                    </div>
                </div>
            </div>
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</main>

<?php echo $this->include('simta/simta_partial/dashboard/footer'); ?>