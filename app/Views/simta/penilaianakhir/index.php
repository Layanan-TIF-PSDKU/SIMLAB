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
                        <h2 class="mt-2 page-title">Halaman Pengelolaan Penilaian Akhir</h2>
                    </div>
                    <?php if (has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</li>
                                <li class="breadcrumb-item active">Pengelolaan Penilaian Akhir</li>
                            </ol>
                        </div>
                    <?php elseif (has_permission('mahasiswa')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</li>
                                <li class="breadcrumb-item active">Pendaftaran Penilaian Akhir</li>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row my-3">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table datatables" id="dataTable-1">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Mahasiswa</th>
                                                <th>Nama Dosen Pembimbing</th>
                                                <th>Nilai Ujian Proposal</th>
                                                <th>Nilai Seminar Hasil</th>
                                                <th>Nilai Ujian TA</th>
                                                <th>Nilai Akhir</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?> 
                                            <?php foreach ($penilaianakhir as $pa): ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td>
                                                        <?php foreach($mahasiswa as $mhs) {
                                                            echo ($pa->id_mhs == $mhs->id_mhs) ? $mhs->nama : ''; } ?>
                                                    </td>
                                                    <td>
                                                        <?php foreach($staf as $s) {
                                                        echo ($pa->id_staf == $s->id_staf) ? $s->nama : ''; } ?>
                                                    </td>
                                                    <td><?= $pa->nilai_ujianproposal ?></td>
                                                    <td><?= $pa->nilai_seminarhasil ?></td>
                                                    <td><?= $pa->nilai_ujianta ?></td>
                                                    <td><?= $pa->hasilakhir ?></td>
                                                    <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="<?= base_url("simta/penilaianakhir/cetak_penilaian/$pa->id_hasilakhir"); ?>">Cetak</a>         
                                                    </div>
                                                </td>
                                                </tr>
                                            <?php endforeach; ?>
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
</main>
<?php echo $this->include('simta/simta_partial/dashboard/footer'); ?>
