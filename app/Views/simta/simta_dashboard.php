<?php echo $this->include('simta/simta_partial/dashboard/header');?>
<?php echo $this->include('simta/simta_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')) : ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
<?php echo $this->include('simta/simta_partial/dashboard/side_menu') ?>
<?php endif; ?><main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row align-items-center mb-2">
                    <div class="col mb-4 mt-2">
                        <h2 class="h5 page-title">Selamat Datang di SIM TA,
                            <?= user()->username; ?> &#128522 </h2>
                        <div class="file-container border-top">
                            <div class="mt-3">
                            <?php if(has_permission('koor-simta')) :?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card shadow mb-4">
                                        <div class="card-body text-center">
                                            <div class="avatar avatar-lg mt-4">
                                                <a href="">
                                                    <i class="fe fe-folder" style="font-size: 4em;"></i>
                                                </a>
                                            </div>
                                            <div class="card-text my-2">
                                                <strong class="card-title my-0">Berkas</strong>
                                                <p><?= $jumlah_berkas; ?></p>
                                            </div>
                                        </div> <!-- ./card-text -->
                                        <div class="card-footer">
                                            <div class="row align-items-center justify-content-between">
                                                <div class="col-auto">
                                                    <a href="<?= base_url('simta/berkas') ?>">
                                                    <small><span class="bg-success mr-1"></span> Telusuri Selengkapnya 
                                                    <i class="fe fe-chevron-right ml-4"></i></small>
                                                </div>
                                                    </a>
                                            </div>
                                        </div> <!-- /.card-footer -->
                                    </div>
                                </div> <!-- .col -->
                                <div class="col-md-3">
                                    <div class="card shadow mb-4">
                                        <div class="card-body text-center">
                                            <div class="avatar avatar-lg mt-4">
                                                <a href="">
                                                    <i class="fe fe-book" style="font-size: 4em;"></i>
                                                </a>
                                            </div>
                                            <div class="card-text my-2">
                                                <strong class="card-title my-0">Tugas Akhir Terdahulu</strong>
                                                <p><?= $jumlah_taterdahulu; ?></p>
                                            </div>
                                        </div> <!-- ./card-text -->
                                        <div class="card-footer">
                                            <div class="row align-items-center justify-content-between">
                                                <div class="col-auto">
                                                    <a href="<?= base_url('simta/taterdahulu') ?>">
                                                    <small><span class="bg-success mr-1"></span> Telusuri Selengkapnya 
                                                    <i class="fe fe-chevron-right ml-4"></i></small>
                                                </div>
                                                    </a>
                                            </div>
                                        </div> <!-- /.card-footer -->
                                    </div>
                                </div> <!-- .col -->
                                <div class="col-md-3">
                                    <div class="card shadow mb-4">
                                        <div class="card-body text-center">
                                            <div class="avatar avatar-lg mt-4">
                                                <a href="">
                                                    <i class="fe fe-settings" style="font-size: 4em;"></i>
                                                </a>
                                            </div>
                                            <div class="card-text my-2">
                                                <strong class="card-title my-0">Bobot Penilaian</strong>
                                                <p><?= $jumlah_bobotpenilaian; ?></p>
                                            </div>
                                        </div> <!-- ./card-text -->
                                        <div class="card-footer">
                                            <div class="row align-items-center justify-content-between">
                                                <div class="col-auto">
                                                    <a href="<?= base_url('simta/bobotpenilaian') ?>">
                                                    <small><span class="bg-success mr-1"></span> Telusuri Selengkapnya 
                                                    <i class="fe fe-chevron-right ml-4"></i></small>
                                                </div>
                                                    </a>
                                            </div>
                                        </div> <!-- /.card-footer -->
                                    </div>
                                </div> <!-- .col -->
                                <div class="col-md-3">
                                    <div class="card shadow mb-4">
                                        <div class="card-body text-center">
                                            <div class="avatar avatar-lg mt-4">
                                                <a href="">
                                                    <i class="fe fe-clipboard" style="font-size: 4em;"></i>
                                                </a>
                                            </div>
                                            <div class="card-text my-2">
                                                <strong class="card-title my-0">Penilaian Akhir</strong>
                                                <p><?= $jumlah_penilaianakhir; ?></p>
                                            </div>
                                        </div> <!-- ./card-text -->
                                    <div class="card-footer">
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col-auto">
                                                <a href="<?= base_url('simta/penilaianakhir') ?>">
                                                <small><span class="bg-success mr-1"></span> Telusuri Selengkapnya 
                                                <i class="fe fe-chevron-right ml-4"></i></small>
                                            </div>
                                                </a>
                                        </div>
                                    </div> <!-- /.card-footer -->
                                </div>
                            </div> <!-- .col -->
                        </div>
                <!-- .row--><?php endif; ?>
                <?php if(has_permission('dosen')) :?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card shadow mb-4">
                                        <div class="card-body text-center">
                                            <div class="avatar avatar-lg mt-4">
                                                <a href="">
                                                    <i class="fe fe-folder" style="font-size: 4em;"></i>
                                                </a>
                                            </div>
                                            <div class="card-text my-2">
                                                <strong class="card-title my-0">Pengajuan Judul</strong>
                                                <p><?= $jumlah_pengajuanjudul; ?></p>
                                            </div>
                                        </div> <!-- ./card-text -->
                                        <div class="card-footer">
                                            <div class="row align-items-center justify-content-between">
                                                <div class="col-auto">
                                                    <a href="<?= base_url('simta/pengajuanjudul') ?>">
                                                    <small><span class="bg-success mr-1"></span> Telusuri Selengkapnya 
                                                    <i class="fe fe-chevron-right ml-4"></i></small>
                                                </div>
                                                    </a>
                                            </div>
                                        </div> <!-- /.card-footer -->
                                    </div>
                                </div> <!-- .col -->
                                <div class="col-md-3">
                                    <div class="card shadow mb-4">
                                        <div class="card-body text-center">
                                            <div class="avatar avatar-lg mt-4">
                                                <a href="">
                                                    <i class="fe fe-book" style="font-size: 4em;"></i>
                                                </a>
                                            </div>
                                            <div class="card-text my-2">
                                                <strong class="card-title my-0">Ujian Proposal</strong>
                                                <p><?= $jumlah_ujianproposal; ?></p>
                                            </div>
                                        </div> <!-- ./card-text -->
                                        <div class="card-footer">
                                            <div class="row align-items-center justify-content-between">
                                                <div class="col-auto">
                                                    <a href="<?= base_url('simta/ujianproposal') ?>">
                                                    <small><span class="bg-success mr-1"></span> Telusuri Selengkapnya 
                                                    <i class="fe fe-chevron-right ml-4"></i></small>
                                                </div>
                                                    </a>
                                            </div>
                                        </div> <!-- /.card-footer -->
                                    </div>
                                </div> <!-- .col -->
                                <div class="col-md-3">
                                    <div class="card shadow mb-4">
                                        <div class="card-body text-center">
                                            <div class="avatar avatar-lg mt-4">
                                                <a href="">
                                                    <i class="fe fe-settings" style="font-size: 4em;"></i>
                                                </a>
                                            </div>
                                            <div class="card-text my-2">
                                                <strong class="card-title my-0">Seminar Hasil</strong>
                                                <p><?= $jumlah_seminarhasil; ?></p>
                                            </div>
                                        </div> <!-- ./card-text -->
                                        <div class="card-footer">
                                            <div class="row align-items-center justify-content-between">
                                                <div class="col-auto">
                                                    <a href="<?= base_url('simta/seminarhasil') ?>">
                                                    <small><span class="bg-success mr-1"></span> Telusuri Selengkapnya 
                                                    <i class="fe fe-chevron-right ml-4"></i></small>
                                                </div>
                                                    </a>
                                            </div>
                                        </div> <!-- /.card-footer -->
                                    </div>
                                </div> <!-- .col -->
                                <div class="col-md-3">
                                    <div class="card shadow mb-4">
                                        <div class="card-body text-center">
                                            <div class="avatar avatar-lg mt-4">
                                                <a href="">
                                                    <i class="fe fe-clipboard" style="font-size: 4em;"></i>
                                                </a>
                                            </div>
                                            <div class="card-text my-2">
                                                <strong class="card-title my-0">Ujian Tugas Akhir</strong>
                                                <p><?= $jumlah_ujianta; ?></p>
                                            </div>
                                        </div> <!-- ./card-text -->
                                    <div class="card-footer">
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col-auto">
                                                <a href="<?= base_url('simta/ujianta') ?>">
                                                <small><span class="bg-success mr-1"></span> Telusuri Selengkapnya 
                                                <i class="fe fe-chevron-right ml-4"></i></small>
                                            </div>
                                                </a>
                                        </div>
                                    </div> <!-- /.card-footer -->
                                </div>
                            </div> <!-- .col -->
                        </div>
                <!-- .row--><?php endif; ?>
                <?php if(has_permission('mahasiswa')) :?>
                    <div class="row my-3">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <div class="table-responsive">
                                    <table class="table datatables" id="dataTable-1">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Berkas</th>
                                                <th>Kategori</th>
                                                <th>Keterangan</th>
                                                <th>File</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($berkas as $a) : ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?=$a->nama_berkas?></td>
                                                <td><?=$a->kategori?></td>
                                                <td><?=$a->keterangan?></td>
                                                <td>
                                                    <?php if ($a->file_berkas == ''): ?>
                                                    <span class="badge badge-danger">Belum upload</span>
                                                    <?php else: ?>
                                                    <a class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                        href="<?=base_url("simta/berkas/download_berkas/$a->id_berkas");?>">
                                                        <span class="fe fe-download-cloud fe-16 align-middle"></span>
                                                    </a>
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
                                                            href="<?=base_url("simta/berkas/edit/$a->id_berkas");?>">Edit</a>
                                                        <?php if(has_permission('admin')) : ?> 
                                                            <form method="POST" action="<?=base_url("simta/berkas/hapus/$a->id_berkas");?>">
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            <button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title='Delete'>
                                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                            Delete</button>
                                                            </form>
                                                    </div>
                                                </td>
                                                <?php endif; ?>
                                            </tr>
                                            <?php endforeach?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- simple table -->
                </div>
                <!-- .row--><?php endif; ?>
                                </div> <!-- .col -->
                            </div> <!-- .col -->
                        </div> <!-- .col -->
                    </div>
                </div>
                <!-- .card-body -->
            </div>
            <!-- .card -->
        </div>
        <!-- .card -->
    </div>
    <!-- .col -->
    </div>
    </div>
    <!-- / .card-body -->
    </div>
    </div>
    <!-- / .card -->

    <!-- Striped rows -->
    </div>
    <!-- .row-->
    </div>
    <!-- .col-12 -->
    </div>
    <!-- .row -->
    </div>
    <!-- .container-fluid -->


</main>

    
<?php echo $this->include('simta/simta_partial/dashboard/footer');?>