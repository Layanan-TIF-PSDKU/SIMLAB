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
                            if(has_permission('admin') || has_permission('dosen')) {
                                echo '<h2 class="mt-2 page-title">Halaman Pengelolaan Ujian Proposal</h2>';
                            } else {
                                echo '<h2 class="mt-2 page-title">Halaman Pendaftaran Ujian Proposal</h2>';
                            }
                        ?>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">SIMTA</a></li>
                            <li class="breadcrumb-item active">Pengelolaan Ujian Proposal</li>
                        </ol>
                    </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">SIMTA</a></li>
                            <li class="breadcrumb-item active">Pendaftaran Ujian Proposal</li>
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

                                <?php if(has_permission('mahasiswa') && !has_permission('admin') && !has_permission('dosen')) : ?>
                                <a href="<?=base_url('simta/ujianproposal/tambah');?>"
                                    class="btn btn-primary mb-3">Tambah</a>
                                <?php endif; ?>
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <?php if(has_permission('admin') || has_permission('dosen')) : ?>
                                            <th>Nama Mahasiswa</th>
                                            <?php endif; ?>
                                            <?php if(has_permission('admin') || has_permission('mahasiswa')) : ?>
                                            <th>Nama Dosen Pembimbng</th>
                                            <?php endif; ?>
                                            <?php if(has_permission('admin') || has_permission('dosen')): ?>
                                            <th>NIM</th>
                                            <?php endif; ?>
                                            <?php if(has_permission('admin') || has_permission('dosen')): ?>
                                            <th>Kelas</th>
                                            <?php endif; ?>
                                            <th>Nama Judul</th>
                                            <th>Hasil</th>
                                            <th>Status Pengajuan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (has_permission('admin')):
                                            $no = 1;
                                            foreach ($ujianproposal as $up1) :
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <?php foreach($mahasiswa as $mhs) {
                                                    echo ($up1->id_mhs == $mhs->id_mhs) ? $mhs->nama : ''; } ?>
                                            </td>
                                            <td>
                                                <?php foreach($staf as $s) {
                                                    echo ($up1->id_staf == $s->id_staf) ? $s->nama : ''; } ?>
                                            </td>
                                            <td>
                                                <?php foreach($mahasiswa as $mhs) {
                                                    echo ($up1->id_mhs == $mhs->id_mhs) ? $mhs->nim : ''; } ?>
                                            </td>
                                            <td>
                                                <?php foreach($mahasiswa as $mhs) {
                                                    echo ($up1->id_mhs == $mhs->id_mhs) ? $mhs->kelas : ''; } ?>
                                            </td>

                                            <td><?=$up1->nama_judul?></td>
                                            <td>
                                                <?php if ($up1->status_up == 'diajukan'): ?>
                                                <span class="badge badge-warning"><?=$up1->status_up?></span>
                                                <?php else: ?>
                                                <?php if ($up1->status_up == 'lulus') {?>
                                                <span class="badge badge-success"><?=$up1->status_up?></span>
                                                <?php } else if ($up1->status_up == 'lulus dengan revisi') {?>
                                                <span class="badge badge-info"><?=$up1->status_up?></span>
                                                <?php } else {?>
                                                <?php } if ($up1->status_up == 'gagal') {?>
                                                <span class="badge badge-danger"><?=$up1->status_up?></span>
                                                <?php }?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($up1->status_ajuan == 'pending'): ?>
                                                <span class="badge badge-warning">PENDING</span>
                                                <?php else: ?>
                                                <?php if ($up1->status_ajuan == 'diterima') {?>
                                                <span class="badge badge-success"><?=$up1->status_ajuan?></span>
                                                <?php } else {?>
                                                <?php } if ($up1->status_ajuan == 'ditolak') {?>
                                                <span class="badge badge-danger"><?=$up1->status_ajuan?></span>
                                                <?php }?>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="<?=base_url("simta/ujianproposal/edit/$up1->id_ujianproposal");?>">
                                                        Pengaturan Jadwal</a>
                                                    <a class="dropdown-item"
                                                        href="<?=base_url("simta/ujianproposal/tambahpengujiujianproposal/$up1->id_ujianproposal");?>">
                                                        Tambah Dosen Penguji</a>
                                                    <a class="dropdown-item"
                                                        href="<?=base_url("simta/ujianproposal/editstatus/$up1->id_penguji_ujianproposal");?>">
                                                        Penilaian</a>
                                                    <a class="dropdown-item"
                                                        href="<?=base_url("simta/ujianproposal/detail/$up1->id_ujianproposal");?>">Detail</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; elseif (has_permission('mahasiswa')):
                                            $no = 1;
                                            foreach ($ujianproposal2 as $up2) :
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <?php foreach($staf as $s) {
                                                    echo ($up2->id_staf == $s->id_staf) ? $s->nama : ''; } ?>
                                            </td>
                                            <td><?=$up2->nama_judul?></td>
                                            <td>
                                                <?php if ($up2->status_up == 'diajukan'): ?>
                                                <span class="badge badge-primary"><?=$up2->status_up?></span>
                                                <?php else: ?>
                                                <?php if ($up2->status_up == 'lulus') {?>
                                                <span class="badge badge-success"><?=$up2->status_up?></span>
                                                <?php } else if ($up2->status_up == 'lulus dengan revisi') {?>
                                                <span class="badge badge-info"><?=$up2->status_up?></span>
                                                <?php } else {?>
                                                <?php } if ($up2->status_up == 'gagal') {?>
                                                <span class="badge badge-danger"><?=$up2->status_up?></span>
                                                <?php }?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($up2->status_ajuan == 'pending'): ?>
                                                <span class="badge badge-warning">PENDING</span>
                                                <?php else: ?>
                                                <?php if ($up2->status_ajuan == 'diterima') {?>
                                                <span class="badge badge-success"><?=$up2->status_ajuan?></span>
                                                <?php } else {?>
                                                <?php } if ($up2->status_ajuan == 'ditolak') {?>
                                                <span class="badge badge-danger"><?=$up2->status_ajuan?></span>
                                                <?php }?>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <?php foreach ($ujianproposal as $up2) {
                                                        $tanggal_ujian = date('d F Y',($up2->tanggal/1000));
                                                        $tanggal = strtotime($tanggal_ujian);
                                                        helper(['date']);
                                                        $t = now('Asia/Jakarta');
                                                        $time = date('d F Y', $t);
                                                        $tanggal_sekarang = strtotime($time);
                                                        // var_dump($tanggal);
                                                        // var_dump($tanggal_sekarang);
                                                        if ($up2->status_up == 'lulus dengan revisi' && $tanggal < $tanggal_sekarang) { ?>
                                                    <a class="dropdown-item"
                                                        href="<?= base_url("simta/ujianproposal/revisi/$up2->id_ujianproposal"); ?>">Revisi</a>
                                                    <?php }
                                                        } ?>
                                                    <a class="dropdown-item"
                                                        href="<?=base_url("simta/ujianproposal/detail/$up2->id_ujianproposal");?>">Detail</a>
                                                </div>
                                            </td>

                                        </tr>
                                        <?php endforeach; elseif (has_permission('dosen')):
                                            $no = 1;
                                            foreach ($ujianproposal3 as $up3) :
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <?php foreach($mahasiswa as $mhs) {
                                                    echo ($up3->id_mhs == $mhs->id_mhs) ? $mhs->nama : ''; } ?>
                                            </td>
                                            <td>
                                                <?php foreach($mahasiswa as $mhs) {
                                                    echo ($up3->id_mhs == $mhs->id_mhs) ? $mhs->nim : ''; } ?>
                                            </td>
                                            <td>
                                                <?php foreach($mahasiswa as $mhs) {
                                                    echo ($up3->id_mhs == $mhs->id_mhs) ? $mhs->kelas : ''; } ?>
                                            </td>
                                            <td><?=$up3->nama_judul?></td>
                                            <td>
                                                <?php if ($up3->status_up == ''): ?>
                                                <span class="badge badge-info">DIAJUKAN</span>
                                                <?php else: ?>
                                                <?php if ($up3->status_up == 'LULUS') {?>
                                                <span class="badge badge-success"><?=$up3->status_up?></span>
                                                <?php } else if ($up3->status_up == 'LULUS DENGAN REVISI') {?>
                                                <span class="badge badge-warning"><?=$up3->status_up?></span>
                                                <?php } else {?>
                                                <?php } if ($up3->status_up == 'GAGAL') {?>
                                                <span class="badge badge-danger"><?=$up3->status_up?></span>
                                                <?php }?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($up3->proposalawal == ''): ?>
                                                <span class="badge badge-danger">Belum upload</span>
                                                <?php else: ?>
                                                <a class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                    href="<?=base_url("simta/ujianproposal/download_proposalawal/$up3->id_ujianproposal");?>">
                                                    <span class="fe fe-download-cloud fe-16 align-middle"></span>
                                                </a>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="<?=base_url("simta/ujianproposal/editstatus/$up3->id_ujianproposal");?>">Penilaian</a>
                                                    <a class="dropdown-item"
                                                        href="<?=base_url("simta/ujianproposal/detail/$up3->id_ujianproposal");?>">Detail</a>
                                                </div>
                                            </td>

                                        </tr>
                                        <?php endforeach; else :
                                            $no = 1;
                                            foreach ($ujianproposal4 as $k) {
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