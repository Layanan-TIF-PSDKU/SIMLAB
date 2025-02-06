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
                <h2 class="mb-2 page-title">Halaman Pengelolaan Data Nilai</h2>
                <p class="card-text">
                    
                </p>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <?php if(has_permission('pimpinan')) : ?>
                                <?php else : ?>
                                <a href="<?= base_url('sipema/nilai/tambah'); ?>" class="btn btn-primary mb-3">Tambah</a>
                                <a href="#" class="btn btn-success mb-3" data-toggle="modal" data-target="#importnilai"><i class="fe fe-file fe-16"></i>&nbspImport Excel</a>
                                <?php endif; ?>
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Mata Kuliah</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Nilai UTS</th>
                                            <th>Nilai UAS</th>
                                            <?php if(has_permission('pimpinan')) : ?>
                                            <?php else : ?>
                                            <th>Action</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($NilaiMataKuliahMahasiswa as $nmkm): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $nmkm->nama_mata_kuliah ?></td>
                                            <td><?= $nmkm->nama ?></td> 
                                            <td><?= $nmkm->nilai_uts ?></td> 
                                            <td><?= $nmkm->nilai_uas ?></td>
                                            <?php if(has_permission('pimpinan')) : ?>
                                            <?php else : ?> 
                                            <td>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="<?= base_url("sipema/nilai/edit/$nmkm->id_nilai"); ?>">Edit</a>
                                                    <form method="POST" action="<?= base_url("sipema/nilai/hapus/$nmkm->id_nilai"); ?>">
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title='Delete'><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</button>
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
</main>
<?php echo $this->include('sipema/sipema_partial/dashboard/footer');?>