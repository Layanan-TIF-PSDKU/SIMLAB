<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('kmm/kmm_partial/dashboard/top_menu'); ?>
<?php if(has_permission('admin')): ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
<?php else: ?>
<?= $this->include('kmm/kmm_partial/dashboard/side_menu'); ?>
<?php endif; ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="mt-2 page-title">Halaman Detail KMM</h2>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <?php if(has_permission('admin')): ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <?php else: ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('kmm') ?>">Dashboard</a></li>
                            <?php endif; ?>
                            <li class="breadcrumb-item active">KMM</a></li>
                            <li class="breadcrumb-item active">Detail KMM</li>
                        </ol>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5>Nama Mahasiswa</h5>
                                <p><?= $kmm->nm_mhs ?></p>
                                <h5>Nama Dosen Pembimbing</h5>
                                <p><?= $kmm->nm_staf ?></p>
                                <h5>Instansi Yang Dituju</h5>
                                <p><?= $kmm->nama_instansi ?></p>
                                <h5>Pelaksanaan KMM</h5>
                                <p><?= date("d F Y", strtotime($kmm->tgl_mulai)) .' - '.date("d F Y", strtotime($kmm->tgl_selesai)) ?>
                                </p>
                                <h5>Status</h5>
                                <?php if($kmm->status_lolos == 'pending'){ ?>
                                <p class="badge badge-warning text-uppercase font-weight-bolder">proses seleksi</p>
                                <?php } else if ($kmm->status_lolos == 'lolos') {?>
                                <p class="badge badge-success text-uppercase font-weight-bolder">
                                    <?= $kmm->status_lolos ?></p>
                                <?php } else { ?>
                                <p class="badge badge-danger text-uppercase font-weight-bolder">
                                    <?= $kmm->status_lolos ?></p>
                                <?php }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5>Proposal KMM</h5>
                                <p>
                                    <?php if($kmm->proposal == null) : ?>
                                    <span class="badge badge-primary text-uppercase">belum diupload</span>
                                    <?php else : ?>
                                    <a href="<?= base_url('kmm/kmm/download-proposal/' . $kmm->id_kmm); ?>">Download</a>
                                    <?php endif; ?>
                                </p>
                                <h5>Surat Pengantar KMM</h5>
                                <p>
                                    <?php if($kmm->surat_pengantar == null) : ?>
                                    <span class="badge badge-primary text-uppercase">belum diupload</span>
                                    <?php else : ?>
                                    <a
                                        href="<?= base_url('kmm/kmm/download-surat-pengantar/' . $kmm->id_kmm); ?>">Download</a>
                                    <?php endif; ?>
                                </p>
                                <?php if($kmm->status_lolos == 'lolos'): ?>
                                <h5>LoA</h5>
                                <p>
                                    <?php if($kmm->loa == null) : ?>
                                    <span class="badge badge-primary text-uppercase">belum diupload</span>
                                    <?php else : ?>
                                    <a href="<?= base_url('kmm/kmm/download-loa/' . $kmm->id_kmm); ?>">Download</a>
                                    <?php endif; ?>
                                </p>
                                <h5>Logbook KMM</h5>
                                <p>
                                    <?php if($kmm->logbook == null) : ?>
                                    <span class="badge badge-primary text-uppercase">belum diupload</span>
                                    <?php else : ?>
                                    <a href="<?= base_url('kmm/kmm/download/' . $kmm->id_kmm); ?>">Download</a>
                                    <?php endif; ?>
                                </p>
                                <h5>Laporan Akhir</h5>
                                <p>
                                    <?php if($kmm->laporan_akhir == null) : ?>
                                    <span class="badge badge-primary text-uppercase">belum diupload</span>
                                    <?php else : ?>
                                    <a href="<?= base_url('kmm/lap-akhir/download/' . $kmm->id_kmm); ?>">Download</a>
                                    <?php endif; ?>
                                </p>
                                <h5>Judul KMM</h5>
                                <p><?= ($kmm->judul_kmm == null ? '<span class="badge badge-primary text-uppercase">belum ada</span>' : $kmm->judul_kmm); ?>
                                </p>
                                <h5>Pelaksanaan Seminar KMM</h5>
                                <p><?= ($kmm->tgl_seminar == null ? '<span class="badge badge-primary text-uppercase">belum ada</span>' : (date("d F Y", strtotime($kmm->tgl_seminar)))); ?>
                                </p>
                                <?php elseif($kmm->status_lolos == 'tidak lolos'): ?>
                                <h5>Bukti Tidak Lolos KMM</h5>
                                <p>
                                    <?php if($kmm->bukti_gagal == null) : ?>
                                    <span class="badge badge-primary text-uppercase">belum diupload</span>
                                    <?php else : ?>
                                    <a
                                        href="<?= base_url('kmm/kmm/download-bukti-gagal/' . $kmm->id_kmm); ?>">Download</a>
                                    <?php endif; ?>
                                </p>
                                <?php else: ?>
                                <?php endif; ?>
                                <a class="btn btn-sm btn-warning float-right"
                                    href="<?= base_url('kmm/kmm') ?>">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end section -->
            </div>
            <!-- .col-12 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container-fluid -->
</main>

<?= $this->include('master_partial/dashboard/footer'); ?>