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
                        <?php
                            if(has_permission('admin') || has_permission('dosen')) {
                                echo '<h2 class="mt-2 page-title">Halaman Pengelolaan Pengajuan Judul Tugas Akhir</h2>';
                            } else {
                                echo '<h2 class="mt-2 page-title">Halaman Pendaftaran Pengajuan Judul Tugas Akhir</h2>';
                            }
                        ?>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Pengelolaan Pengajuan Judul</li>
                            </ol>
                        </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Pendaftaran Pengajuan Judul</li>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row my-3">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <?php if(has_permission('mahasiswa') && !has_permission('admin') && !has_permission('dosen') && !has_permission('koor-simta')) : ?>
                                    <a href="<?=base_url('simta/pengajuanjudul/tambah');?>" class="btn btn-primary mb-3">Tambah</a>
                                <?php endif; ?>
                                <div class="table-responsive">
                                    <table class="table datatables" id="dataTable-1">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')) : ?>
                                                <th>Nama Mahasiswa</th>
                                                <?php endif; ?>
                                                <?php if(has_permission('admin') || has_permission('mahasiswa') || has_permission('koor-simta')) : ?>
                                                <th>Nama Dosen Pembimbing</th>
                                                <?php endif; ?>
                                                <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')) : ?>
                                                <th>NIM</th>
                                                <?php endif; ?>
                                                <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')) : ?>
                                                <th>Kelas</th>
                                                <?php endif; ?>
                                                <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')) : ?>
                                                <th>Angkatan</th>
                                                <?php endif; ?>
                                                <th>Hasil</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (has_permission('admin') || has_permission('koor-simta')):
                                            $no = 1;
                                            foreach ($pengajuanjudul as $pj1) :
                                            ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td>
                                                    <?php foreach($mahasiswa as $mhs) {
                                                        echo ($pj1->id_mhs == $mhs->id_mhs) ? $mhs->nama : ''; 
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php foreach($staf as $s) {
                                                        echo ($pj1->id_staf == $s->id_staf) ? $s->nama : ''; 
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php foreach($mahasiswa as $mhs) {
                                                        echo ($pj1->id_mhs == $mhs->id_mhs) ? $mhs->nim : ''; 
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php foreach($mahasiswa as $mhs) {
                                                        echo ($pj1->id_mhs == $mhs->id_mhs) ? $mhs->kelas : ''; 
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php foreach($mahasiswa as $mhs) {
                                                        echo ($pj1->id_mhs == $mhs->id_mhs) ? $mhs->th_masuk : ''; 
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php if ($pj1->status_pj == 'DIAJUKAN'): ?>
                                                        <span class="badge badge-info">DIAJUKAN</span>
                                                    <?php else: ?>
                                                    <?php if ($pj1->status_pj == 'DISETUJUI PILIHAN 1') {?>
                                                        <span class="badge badge-success"><?=$pj1->status_pj?></span>
                                                    <?php } else if ($pj1->status_pj == 'DISETUJUI PILIHAN 2') {?>
                                                        <span class="badge badge-success"><?=$pj1->status_pj?></span>
                                                    <?php } else if ($pj1->status_pj == 'DISETUJUI PILIHAN 3') {?>
                                                        <span class="badge badge-success"><?=$pj1->status_pj?></span>
                                                    <?php } else {?>
                                                    <?php } if ($pj1->status_pj == 'DITOLAK') {?>
                                                        <span class="badge badge-danger"><?=$pj1->status_pj?></span>
                                                    <?php }?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("simta/pengajuanjudul/detail/$pj1->id_pengajuanjudul");?>">Detail</a>  
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; elseif (has_permission('mahasiswa')):
                                            $no = 1;
                                            foreach ($pengajuanjudul2 as $pj2) :
                                            ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td>
                                                    <?php foreach($staf as $s) {
                                                        echo ($pj2->id_staf == $s->id_staf) ? $s->nama : ''; 
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php if ($pj2->status_pj == 'DIAJUKAN'): ?>
                                                        <span class="badge badge-info">DIAJUKAN</span>
                                                    <?php else: ?>
                                                    <?php if ($pj2->status_pj == 'DISETUJUI PILIHAN 1') {?>
                                                        <span class="badge badge-success"><?=$pj2->status_pj?></span>
                                                    <?php } else if ($pj2->status_pj == 'DISETUJUI PILIHAN 2') {?>
                                                        <span class="badge badge-success"><?=$pj2->status_pj?></span>
                                                    <?php } else if ($pj2->status_pj == 'DISETUJUI PILIHAN 3') {?>
                                                        <span class="badge badge-success"><?=$pj2->status_pj?></span>
                                                    <?php } else {?>
                                                    <?php } if ($pj2->status_pj == 'DITOLAK') {?>
                                                        <span class="badge badge-danger"><?=$pj2->status_pj?></span>
                                                    <?php }?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="<?= base_url("simta/pengajuanbimbingan/tambah/$pj2->id_pengajuanjudul"); ?>">Tambah Pengajuan Bimbingan</a>         
                                                        <a class="dropdown-item" href="<?= base_url("simta/ujianproposal/tambah/$pj2->id_pengajuanjudul"); ?>">Tambah Ujian Proposal</a>
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("simta/pengajuanjudul/tambahrekomendasi/$pj2->id_pengajuanjudul");?>">Tambah
                                                            Rekomendasi Dosen</a>
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("simta/pengajuanjudul/detail/$pj2->id_pengajuanjudul");?>">Detail</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; elseif (has_permission('dosen')):
                                            $no = 1;
                                            foreach ($pengajuanjudul3 as $pj3) :
                                            ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td>
                                                    <?php foreach($mahasiswa as $mhs) {
                                                        echo ($pj3->id_mhs == $mhs->id_mhs) ? $mhs->nama : ''; 
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php foreach($mahasiswa as $mhs) {
                                                        echo ($pj3->id_mhs == $mhs->id_mhs) ? $mhs->nim : ''; 
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php foreach($mahasiswa as $mhs) {
                                                        echo ($pj3->id_mhs == $mhs->id_mhs) ? $mhs->kelas : ''; 
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php foreach($mahasiswa as $mhs) {
                                                        echo ($pj3->id_mhs == $mhs->id_mhs) ? $mhs->th_masuk : ''; 
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php if ($pj3->status_pj == 'DIAJUKAN'): ?>
                                                        <span class="badge badge-info">DIAJUKAN</span>
                                                    <?php else: ?>
                                                    <?php if ($pj3->status_pj == 'DISETUJUI PILIHAN 1') {?>
                                                        <span class="badge badge-success"><?=$pj3->status_pj?></span>
                                                    <?php } else if ($pj3->status_pj == 'DISETUJUI PILIHAN 2') {?>
                                                        <span class="badge badge-success"><?=$pj3->status_pj?></span>
                                                    <?php } else if ($pj3->status_pj == 'DISETUJUI PILIHAN 3') {?>
                                                        <span class="badge badge-success"><?=$pj3->status_pj?></span>
                                                    <?php } else {?>
                                                    <?php } if ($pj3->status_pj == 'DITOLAK') {?>
                                                        <span class="badge badge-danger"><?=$pj3->status_pj?></span>
                                                    <?php }?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("simta/pengajuanjudul/detail/$pj3->id_pengajuanjudul");?>">Detail</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; else :
                                            $no = 1;
                                            foreach ($pengajuanjudul4 as $k) {
                                            ?>
                                            <tr>

                                            </tr>
                                            <?php } endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- simple table -->
                </div>
                <!-- end section -->
            </div>
            <!-- .col-12 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container-fluid -->
</main>

<?php echo $this->include('simta/simta_partial/dashboard/footer'); ?>