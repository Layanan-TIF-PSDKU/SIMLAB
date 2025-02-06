<?php echo $this->include('sipema/sipema_partial/dashboard/header');?>
<?php echo $this->include('sipema/sipema_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')) : ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
<?php echo $this->include('sipema/sipema_partial/dashboard/side_menu') ?>
<?php endif; ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Halaman Pengelolaan Data Nilai</h2>
                    </div>
                    <?php if(has_permission('admin')) : ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Sipema</a></li>
                                <li class="breadcrumb-item active">Nilai</li>
                            </ol>
                        </div>
                    <?php else : ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('sipema') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Nilai</li>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col-md-12">
                    <div class="card shadow mb-4">
                    <div class="card-header">
                    <strong class="card-title">Pencarian Data Nilai Mahasiswa</strong>
                    </div>
                    <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label>Nama Mahasiswa <span class="text-danger"></span></label>
                                <select class="form-control select2 required" name="id_mhs_filter" id="id_mhs_filter">
                                    <option value="">Pilih Nama Mahasiswa</option>
                                    <?php foreach($mahasiswa as $m): ?>
                                        <option value="<?= $m->id_mhs ?>"><?= $m->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label>Nama Mata Kuliah</label>
                                <select class="form-control select2" name="id_mata_kuliah_filter" id="id_mata_kuliah_filter">
                                <option value="">Pilih Nama Mata Kuliah</option>
                                <?php foreach($mata_kuliah as $mk): ?>
                                        <option value="<?= $mk->id_mata_kuliah ?>"><?= $mk->nama_mata_kuliah ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div> <!-- /.col -->
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label>Nilai UTS dan UAS</label>
                                <select class="form-control select2" name="nilai_uts_uas_filter" id="nilai_uts_uas_filter">
                                        <option value="">Pilih Range Nilai UTS dan UAS</option>
                                        <option value="1">90 - 100</option>
                                        <option value="2">85 - 89.9</option>
                                        <option value="3">80 - 84.9</option>
                                        <option value="4">75 - 79.9</option>
                                        <option value="5">70 - 74.9</option>
                                        <option value="6">65 - 69.9</option>
                                        <option value="7">60 - 64.9</option>
                                        <option value="8">55 - 59.9</option>
                                        <option value="9">50 - 54.9</option>
                                        <option value="10">0 - 49.9</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <button id="prosesNilaiFilter" class="btn btn-primary">Proses</button>
                    <button id="resetNilaiFilter" class="btn btn-danger">Reset</button>
                    </div>
                    </div> <!-- / .card -->
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <?php if(has_permission('pimpinan')) : ?>
                                <?php else : ?>
                                <a href="<?= base_url('sipema/nilai/tambah_mahasiswa'); ?>" class="btn btn-primary mb-3">Tambah</a>
                                <!-- <a href="#" class="btn btn-success mb-3" data-toggle="modal" data-target="#importnilai"><i class="fe fe-file fe-16"></i>&nbspImport Excel</a> -->
                                <?php endif; ?>
                                <div class="table-responsive">
                                <table class="table datatables" id="dataTableNilai">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="d-none">No</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Nama Mata Kuliah</th>
                                            <th>Nilai UTS</th>
                                            <th>Nilai UAS</th>
                                            <?php if(has_permission('pimpinan')) : ?>
                                            <?php else : ?>
                                            <th>Action</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($DetailNilaiMataKuliahMahasiswa as $dnmkm): ?>
                                        <tr>
                                            <td style="visibility: hidden;"><?= $dnmkm->nama_mahasiswa ?></td>
                                            <td class="d-none"><?= $dnmkm->id_mhs ?> </td>
                                            <td><?= $dnmkm->nama_mata_kuliah ?></td>
                                            <td><?= $dnmkm->nilai_uts ?></td>
                                            <td><?= $dnmkm->nilai_uas ?></td>
                                            <?php if(has_permission('pimpinan')) : ?>
                                            <?php else : ?> 
                                                <td>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="<?= base_url("sipema/nilai/edit_nilai_mata_kuliah/$dnmkm->id_mhs/$dnmkm->id_mata_kuliah"); ?>"><i class="fe fe-edit fe-16"></i> Edit</a>
                                                    <form method="POST" action="<?= base_url("sipema/nilai/hapus_nilai_mata_kuliah/$dnmkm->id_mhs"); ?>">
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <input name="id_mata_kuliah" type="hidden" value="<?= $dnmkm->id_mata_kuliah ?>">
                                                        <button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title='Delete'><i class="fe fe-delete fe-16"></i> Delete</button>
                                                        <!-- <a class="btn dropdown-item" style="color:black" onclick="deletedatanilai()">Hapus</a> -->
                                                    </form>
                                                </div>
                                            </td>
                                            <?php endif; ?>
                                        </tr>
                                        <?php endforeach ?>
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
 <!-- Modal -->
 <div class="modal fade" id="importnilai" tabindex="-1" role="dialog"
        aria-labelledby="verticalModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="verticalModalTitle">Import Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form method="post" action="<?php echo base_url('sipema/nilai/import'); ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="file">File Excel</label>
                    <input type="file" name="file" id="file" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Import</button>
            </form>
          </div>
        </div>
      </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#dataTable-1').DataTable();
  });                         
</script>
</main>
</main>
<?php echo $this->include('sipema/sipema_partial/dashboard/footer');?>