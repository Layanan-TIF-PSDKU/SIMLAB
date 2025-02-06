<?php echo $this->include('sipema/sipema_partial/dashboard/header');?>
<?php echo $this->include('sipema/sipema_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')) : ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
<?php echo $this->include('sipema/sipema_partial/dashboard/side_menu') ?>
<?php endif; ?>
<main role="main" class="main-content">
    <div class="container-fluid">
    <div class="row mb-2">
                    <div class="col-sm-6">
                      
                    </div>
                    <?php if(has_permission('admin')) : ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Sipema</a></li>
                                <li class="breadcrumb-item active">Hasil Pemetaan Keterampilan</li>
                            </ol>
                        </div>
                    <?php else : ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('sipema') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Hasil Pemetaan Keterampilan</li>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card shadow mb-4">
                <div class="card-header">
                  <strong class="card-title">Pemetaan Keterampilan menggunakan Nilai</strong>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group mb-3">
                          <label>Nama Bidang <span class="text-danger"></span></label>
                          <select class="form-control select2 required" name="id_bidang" id="id_bidang">
                              <option value="">Pilih Bidang</option>
                              <?php foreach($bidang as $b): ?>
                                  <option value="<?= $b->id_bidang ?>"><?= $b->nama_bidang ?></option>
                              <?php endforeach; ?>
                          </select>
                      </div>
                      <div class="form-group mb-3">
                          <label>Nama Sub Bidang</label>
                          <select class="form-control select2" name="id_sub_bidang" id="id_sub_bidang" disabled>
                              <option value="">Pilih Sub Bidang</option>
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
                    <div class="col-md-6">
                    <div class="form-group mb-3">
                          <label>Nilai yang akan ditampilkan</label>
                          <select class="form-control select2" name="nilai_akhir_filter" id="nilai_akhir_filter" disabled>
                                  <option value="">Pilih Range Nilai</option>
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
                      <div class="form-group mb-3">
                          <label>Pencapaian SKS</label>
                          <select class="form-control select2" name="sks_filter" id="sks_filter" disabled>
                                  <option value="">Pilih Range SKS</option>
                                  <option value="1">Kurang dari 7 sks</option>
                                  <option value="2">10 - 20 sks</option>
                                  <option value="3">20 - 30 sks</option>
                                  <option value="4">30 - 40 sks</option>
                                  <option value="5">40 - 50 sks</option>
                                  <option value="6">50 - 60 sks</option>
                                  <option value="7">60 - 70 sks</option>
                                  <option value="8">70 - 80  sks</option>
                                  <option value="9">80 - 90  sks</option>
                                  <option value="10">90 - 105 sks</option>
                                  <option value="11"> Sama dengan 106 sks</option>
                          </select>
                          <span class="text-danger">Disarankan Memilih 106 Sks agar akurasi lebih akurat</span>
                      </div>
                    </div>
                  </div>
                  <button id="prosesPemetaan" class="btn btn-primary">Proses</button>
                  <button id="resetPemetaan" class="btn btn-danger">Reset</button>
                </div>
              </div> <!-- / .card -->
              <div class="card my-4">
                <div class="card-header">
                  <strong>Hasil Pemetaan Keterampilan menggunakan Nilai</strong>
                </div>
                <div class="card-body">
                  <form>
                    <div>
                      <div class="row justify-content-center">
                          <div class="col-12">
                              <div class="row my-4">
                                  <div class="col-md-6 mb-2">
                                      <div class="input-group">
                                      <div class="dropdown">
                                      <div style="display: flex; align-items: center;">
                                        <i class="fe fe-filter fe-4x" style="margin-right: 5px;"></i>
                                        <select style="outline: none;" id="filter" class="dropbtn" style="width: auto;">
                                          <option value="" data-value="">Urutkan: <span class="selected">Semua</span></option>
                                          <option value="1" data-value="1">1 Teratas</option>
                                          <option value="2" data-value="2">2 Teratas</option>
                                          <option value="3" data-value="3">3 Teratas</option>
                                        </select>
                                      </div>
                                      </div>
                                      <style>
                                        .dropbtn {
                                          background-color: #fff;
                                          color: #333;
                                          padding: 12px;
                                          font-size: 16px;
                                          border: none;
                                          cursor: pointer;
                                          display: flex;
                                          align-items: center;
                                        }
                                      /* Style the dropdown content (hidden by default) */
                                      .dropdown-content {
                                        display: none;
                                        position: absolute;
                                        z-index: 1;
                                        top: 40px;
                                        background-color: #f9f9f9;
                                        min-width: 160px;
                                        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                                        border-radius: 4px;
                                      }

                                      /* Style the links inside the dropdown */
                                      .dropdown-content a {
                                        color: black;
                                        padding: 12px 16px;
                                        text-decoration: none;
                                        display: block;
                                      }

                                      /* Change color of dropdown links on hover */
                                      .dropdown-content a:hover {
                                        background-color: #f1f1f1;
                                      }

                                      /* Show the dropdown menu on click */
                                      .dropdown .dropbtn:focus + .dropdown-content {
                                        display: block;
                                      }

                                      /* Add a chevron icon to indicate dropdown menu */
                                      .dropdown .dropbtn i {
                                        position: absolute;
                                        right: 10px;
                                        top: 50%;
                                        transform: translateY(-50%);
                                        transition: transform 0.2s ease;
                                      }

                                      /* Rotate chevron icon when dropdown is open */
                                      .dropdown .dropbtn:focus i {
                                        transform: translateY(-50%) rotate(180deg);
                                      }

                                      /* Style the selected value */
                                      .dropdown .selected {
                                        font-weight: bold;
                                      }
                                      </style>

                                      <script>
                                      // Script to update selected value when link is clicked
                                      var dropdown = document.querySelector('.dropdown');
                                      dropdown.addEventListener('click', function(event) {
                                        if (event.target.hasAttribute('data-value')) {
                                          var newValue = event.target.getAttribute('data-value');
                                          var selected = dropdown.querySelector('.selected');
                                          selected.textContent = event.target.textContent;
                                          selected.setAttribute('data-value', newValue);
                                        }
                                      });
                                      </script>
                                      </div>
                                  </div>
                                  <!-- Small table -->
                                  <div class="col-md-12">
                                      <div class="card shadow">
                                          <div class="card-body">
                                              <!-- table -->
                                              <p><b>Nama Bidang: </b><span id="namaBidang">-</span></p>
                                              <p><b>Nama Sub Bidang: </b><span id="namaSubBidang">-</span></p>
                                              <div class="table-responsive">
                                              <table class="table datatables" id="dataTableHasilPemetaan">
                                                  <thead class="thead-dark">
                                                      <tr>
                                                          <th>No</th>
                                                          <th>Nama Mahasiswa</th>
                                                          <th>Sks Terkait</th>
                                                          <th>Nilai Akhir</th>
                                                          <th>Action</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody id="isitabeldarihasilpemilihansubbidang">
                                                    <tr><td colspan=5><center>Data Kosong</center></td></tr>
                                                  </tbody>
                                              </table>
                                              </div>
                                          </div>
                                      </div>
                                      <h6 class="mt-4">Keterangan :</h6>
                                      Nama Mahasiswa: <span id="namaMahasiswa">-</span>
                                      <br>
                                      Nilai Tertinggi: <span id="nilaiTertinggi">-</span>
                                  </div>
                                  <!-- simple table -->
                              </div>
                              <!-- end section -->
                              <!-- <canvas id="chartHanif2"></canvas> -->
                          </div>
                          <!-- .col-12 -->
                      </div>
                    </div>
                  </form>
                </div> 
                <!-- .card-body -->
            </div> 
            <div class="card shadow mb-4">
                <div class="card-header">
                  <strong class="card-title">Grafik Pemetaan Keterampilan antar Sub Bidang Bedasarkan Nilai</strong>
                </div>
                <div class="card-body">
                  <div class="row">
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
                    <canvas id="chartHanif2"></canvas>
                    <script>
                      var ctx = document.getElementById('chartHanif2').getContext('2d');
                        var chartHanif2 = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: <?php echo json_encode($data2['labels']); ?>,
                                datasets: [{
                                    label: 'Nilai Akhir',
                                    data: <?php echo json_encode($data2['datasets'][0]['data']); ?>,
                                    backgroundColor: <?php echo json_encode($data2['datasets'][0]['backgroundColor']); ?>,
                                    borderColor: <?php echo json_encode($data2['datasets'][0]['borderColor']); ?>,
                                    borderWidth: <?php echo json_encode($data2['datasets'][0]['borderWidth']); ?>
                                }]
                            },
                            options: {
                                legend : {
                                  display: false
                                },
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                datalabels: {
                                      color: 'black',
                                      font: {
                                          weight: 'bold'
                                      }
                                }
                            }
                        });
                    </script>
                  </div>
                </div>
              </div> <!-- / .card -->
            <!-- .card -->
            <div class="card shadow mb-4">
                <div class="card-header">
                  <strong class="card-title">Grafik Pemetaan Keterampilan antar Sub Bidang Bedasarkan Nilai</strong>
                </div>
                <div class="card-body">
                  <div class="row">
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
                    <canvas id="chartHanif"></canvas>
                    <script>
                        var ctx = document.getElementById('chartHanif').getContext('2d');
                        var chartHanif = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: <?php echo json_encode($data3['labels']); ?>,
                                datasets: [{
                                    label: 'Nilai Akhir',
                                    data: <?php echo json_encode($data3['datasets'][0]['data']); ?>,
                                    backgroundColor: <?php echo json_encode($data3['datasets'][0]['backgroundColor']); ?>,
                                    borderColor: <?php echo json_encode($data3['datasets'][0]['borderColor']); ?>,
                                    borderWidth: <?php echo json_encode($data3['datasets'][0]['borderWidth']); ?>
                                }]
                            },
                            options: {
                                legend : {
                                  display: false
                                },
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                datalabels: {
                                      color: 'black',
                                      font: {
                                          weight: 'bold'
                                      }
                                }
                            }
                        });
                    </script>
                  </div>
                </div>
              </div> <!-- / .card -->
          <!-- .col-12 -->
      </div>
<!-- .container-fluid -->
<!-- Modal Detail Mata Kuliah Relevan -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Mata Kuliah Terkait</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
      <div class="table-responsive">
        <table id="detailTable" class="table table-bordered table-striped">
          <thead class="thead-dark">
            <tr>
              <th>Sub Bidang</th>
              <th>Kode MK</th>
              <th>Nama MK</th>
              <th>SKS MK</th>
            </tr>
          </thead>
          <tbody id="isitabeldarihasilmatakuliah">
            
          </tbody>
        </table>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
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
</script>
</main>
<?php echo $this->include('sipema/sipema_partial/dashboard/footer');?>