<?php echo $this->include('simta/simta_partial/dashboard/header');?>
<?php echo $this->include('simta/simta_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')) : ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
<?php echo $this->include('simta/simta_partial/dashboard/side_menu') ?>
<?php endif; ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <?php
                            if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')) {
                                echo '<h2 class="mt-2 page-title">Halaman Pengelolaan Ujian Tugas Akhir</h2>';
                            } else {
                                echo '<h2 class="mt-2 page-title">Halaman Pendaftaran Ujian Tugas Akhir</h2>';
                            }
                        ?>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">SIMTA</a></li>
                            <li class="breadcrumb-item active">Pengelolaan Ujian Tugas Akhir</li>
                        </ol>
                    </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">SIMTA</a></li>
                            <li class="breadcrumb-item active">Pendaftaran Ujian Tugas Akhir</li>
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
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')) : ?>
                                                <th>Nama Mahasiswa</th>
                                            <?php endif; ?>
                                            <?php if(has_permission('admin') || has_permission('mahasiswa') || has_permission('koor-simta')) : ?>
                                                <th>Nama Dosen Pembimbng</th>
                                            <?php endif; ?>
                                            <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                                                <th>NIM</th>
                                            <?php endif; ?>
                                            <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                                                <th>Kelas</th>
                                            <?php endif; ?>
                                            <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                                                <th>Angkatan</th>
                                            <?php endif; ?>
                                            <th>Nama Judul</th>
                                            <th>Hasil</th>
                                            <th>Status Pengajuan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($ujianta as $ujipro) : ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td>
                                                    <?php
                                                        if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')) { 
                                                            echo $ujipro->nm_mhs;
                                                        } else {
                                                            echo $ujipro->nm_staf;
                                                        }; 
                                                    ?>
                                                </td>
                                                <?php if(has_permission('admin') || has_permission('koor-simta')): ?>
                                                    <td>
                                                        <?= $ujipro->nm_staf; ?>
                                                    </td>
                                                <?php endif; ?>
                                                <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                                                    <td>
                                                        <?= $ujipro->nim; ?>
                                                    </td>
                                                <?php endif; ?>
                                                <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                                                    <td>
                                                        <?= $ujipro->kelas; ?>
                                                    </td>
                                                <?php endif; ?>
                                                <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')) : ?>
                                                    <td>
                                                        <?= $ujipro->th_masuk; ?>
                                                    </td>
                                                <?php endif; ?>
                                                <td><?=$ujipro->nama_judul?></td>
                                                <td>
                                                    <?php if ($ujipro->status_ut == 'diajukan'): ?>
                                                    <span class="badge badge-warning"><?=$ujipro->status_ut?></span>
                                                    <?php else: ?>
                                                    <?php if ($ujipro->status_ut == 'lulus') {?>
                                                    <span class="badge badge-success"><?=$ujipro->status_ut?></span>
                                                    <?php } else if ($ujipro->status_ut == 'lulus dengan revisi') {?>
                                                    <span class="badge badge-info"><?=$ujipro->status_ut?></span> 
                                                    <?php } else {?>
                                                    <?php } if ($ujipro->status_ut == 'gagal') {?>
                                                    <span class="badge badge-danger"><?=$ujipro->status_ut?></span>
                                                    <?php }?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($ujipro->status_ajuan == 'pending'): ?>
                                                    <span class="badge badge-warning">PENDING</span>
                                                    <?php else: ?>
                                                    <?php if ($ujipro->status_ajuan == 'diterima') {?>
                                                    <span class="badge badge-success"><?=$ujipro->status_ajuan?></span>
                                                    <?php } else {?>
                                                    <?php } if ($ujipro->status_ajuan == 'ditolak') {?>
                                                    <span class="badge badge-danger"><?=$ujipro->status_ajuan?></span>
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
                                                        <?php if(has_permission('admin') || has_permission('koor-simta')) :?>
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("simta/ujianta/edit/$ujipro->id_ujianta");?>">
                                                            Pengaturan Jadwal</a>
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("simta/ujianta/tambahpengujiujianta/$ujipro->id_ujianta");?>">
                                                            Tambah Dosen Penguji</a>
                                                        <?php endif; ?>
                                                        <?php if(has_permission('mahasiswa') && !has_permission('admin') && !has_permission('dosen')) : ?>
                                                            <?php foreach ($ujianta as $ujipro) {
                                                        $tanggal_ujian = date('d F Y',($ujipro->tanggal/1000));
                                                        $tanggal = strtotime($tanggal_ujian);
                                                        helper(['date']);
                                                        $t = now('Asia/Jakarta');
                                                        $time = date('d F Y', $t);
                                                        $tanggal_sekarang = strtotime($time);
                                                        // var_dump($tanggal);
                                                        // var_dump($tanggal_sekarang);
                                                        if ($ujipro->status_ut == 'lulus dengan revisi' && $tanggal < $tanggal_sekarang) { ?>
                                                            <a class="dropdown-item" href="<?= base_url("simta/ujianta/revisi/$ujipro->id_ujianta"); ?>">Revisi</a>
                                                            <?php }
                                                        } ?>              
                                                    <?php endif; ?>
                                                    <a class="dropdown-item" href="<?=base_url("simta/ujianta/detail/$ujipro->id_ujianta");?>">Detail</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
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