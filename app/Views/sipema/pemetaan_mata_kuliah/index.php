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
                        <h2 class="page-title">Halaman Pemetaan Mata Kuliah</h2>
                    </div>
                    <?php if(has_permission('admin')) : ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Sipema</a></li>
                                <li class="breadcrumb-item active">Pemetaan Mata Kuliah</li>
                            </ol>
                        </div>
                    <?php else : ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('sipema') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Pemetaan Mata Kuliah</li>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col-md-12">
                    <div class="card shadow mb-4">
                    <div class="card-header">
                    <strong class="card-title">Pencarian Data Pemetaan</strong>
                    </div>
                    <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label>Nama Bidang <span class="text-danger"></span></label>
                                <select class="form-control select2 required" name="id_bidang" id="id_bidang_filter_pemetaan">
                                    <option value="">Pilih Bidang</option>
                                    <?php foreach($bidang as $b): ?>
                                    <option value="<?= $b->id_bidang ?>"><?= $b->nama_bidang ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label>Nama Sub Bidang</label>
                                <select class="form-control select2" name="id_sub_bidang" id="id_sub_bidang_filter_pemetaan" disabled>
                                    <option value="">Pilih Sub Bidang</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label>Jenis Bobot dan Nilai</label>
                                <select class="form-control select2" name="jenis_bobot" id="jenis_bobot_filter_pemetaan">
                                        <option value="">Pilih Jenis Bobot dan Nilai </option>
                                        <?php foreach($bobot as $b): ?>
                                            <option value="<?= $b->jenis_bobot ?>"><?= $b->jenis_bobot ?> (<?= $b->nilai_bobot?>)</option>
                                        <?php endforeach; ?>
                                </select>
                            </div>
                        </div> <!-- /.col -->
                        <style>
                            .text-danger{
                            font-style: italic;
                            color: black;
                            }

                            .text-danger::before {
                            content: '*';
                            color: red;
                            display: inline-block;
                            margin-right: 5px;
                            }
                        </style>
                    </div>
                    <button id="prosesFilterPemetaanMataKuliah" class="btn btn-primary">Proses</button>
                    <button id="resetFilterPemetaanMataKuliah" class="btn btn-danger">Reset</button>
                    </div>
                </div> <!-- / .card -->
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <?php if(has_permission('pimpinan')) : ?>
                                <?php else : ?>
                                <a href="<?= base_url('sipema/pemetaan_mata_kuliah/tambah_sub_bidang_pemetaan'); ?>" class="btn btn-primary mb-3">Tambah</a>
                                <?php endif; ?>
                                <div class="table-responsive">
                                <table class="table" id="dataTablePemetaanMataKuliah">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="d-none">No</th>
                                            <th>Sub Bidang</th>
                                            <th>Nama Mata Kuliah</th>
                                            <th>Jenis Bobot</th>
                                            <th>Nilai Bobot</th>
                                            <?php if(has_permission('pimpinan')) : ?>
                                            <?php else : ?>
                                            <th>Action</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($DetailPemetaanMataKuliah as $dpmk) : ?>
                                    <tr>
                                            <td style="visibility: hidden;"><?= $dpmk->nama_sub_bidang ?></td>
                                            <td class="d-none"><?= $dpmk->id_sub_bidang ?> </td>
                                            <td><?= $dpmk->nama_mata_kuliah ?></td>
                                            <td><?= $dpmk->jenis_bobot ?></td>
                                            <td><?= $dpmk->nilai_bobot ?></td>
                                            <?php if(has_permission('pimpinan')) : ?>
                                            <?php else : ?> 
                                            <td>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="<?= base_url("sipema/pemetaan_mata_kuliah/edit_detail_pemetaan_mata_kuliah/$dpmk->id_sub_bidang/$dpmk->id_mata_kuliah"); ?>"><i class="fe fe-edit fe-16"></i> Edit</a>
                                                    <form method="POST" action="<?= base_url("sipema/pemetaan_mata_kuliah/hapus_detail_pemetaan_mata_kuliah/$dpmk->id_sub_bidang"); ?>">
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <input name="id_mata_kuliah" type="hidden" value="<?= $dpmk->id_mata_kuliah ?>">
                                                        <button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title='Delete'><i class="fe fe-delete fe-16"></i> Delete</button>
                                                        <!-- <a class="btn dropdown-item" style="color:black" onclick="deletedatanilai()">Hapus</a> -->
                                                    </form>
                                                </div>
                                            </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
  $(document).ready(function() {
    $('#dataTable-1').DataTable();
  });
  function populateBidang() {
    $('#id_bidang').empty();
    $('#id_bidang').append('<option value="">Pilih Bidang</option>');
    <?php foreach($bidang as $b): ?>
        $('#id_bidang').append('<option value="<?= $b->id_bidang ?>"><?= $b->nama_bidang ?></option>');
    <?php endforeach; ?>
  }
  $(document).ready(function() {
      populateBidang();

      $('#resetPemetaan').click(function() {
          $('#id_bidang').val('');
          $('#id_sub_bidang').prop('disabled', true);
          $('#id_sub_bidang').empty();
          $('#id_sub_bidang').append('<option value="">Pilih Sub Bidang</option>');
          $('#sks_filter').prop('disabled', true);
          $('#sks_filter').empty();
          $('#sks_filter').append('<option value="">Pilih Range Sks</option>');
          $('#nilai_akhir_filter').prop('disabled', true);
          $('#nilai_akhir_filter').empty();
          $('#nilai_akhir_filter').append('<option value="">Pilih Range Nilai Akhir</option>');

          populateBidang();
      });
  });
</script> 
</main>
<?php echo $this->include('sipema/sipema_partial/dashboard/footer');?>