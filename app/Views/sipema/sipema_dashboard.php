<?php echo $this->include('sipema/sipema_partial/dashboard/header'); ?>
<?php echo $this->include('sipema/sipema_partial/dashboard/top_menu'); ?>
<?php echo $this->include('sipema/sipema_partial/dashboard/side_menu'); ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row align-items-center mb-2">
                    <div class="col">
                        <h2 class="h5 page-title">Selamat Datang di Sistem Informasi Pemetaan Keterampilan Mahasiswa, <?= user()->username; ?> &#128522 </h2>
                    </div>
                </div>
                <div class="row">
                <?php if(in_groups('mahasiswa')) : ?>
                <div class="col-md-6 mb-4">
                  <div class="card shadow">
                    <div class="card-header">
                      <strong class="card-title mb-0">Tabel Hasil Pemetaan Keterampilan Bedasarkan Nilai </strong>
                    </div>
                    <div class="card-body">
                    <!-- <h3>Hasil Pemetaan</h3> -->
                      <section>
                      <div class="row justify-content-center">
                          <div class="col-12">
                              <div class="row my-1">
                                  <!-- Small table -->
                                  <div class="col-md-12">
                                      <div class="card shadow">
                                          <div class="card-body">
                                                <?php if($data2['labels'] == null || $data2['datasets'][0]['data'] == null) : ?>
                                                    <h6 style="color:red"><center>Hasil Pemetaan Belum Tersedia</center></h6>
                                                <?php else : ?>
                                                    <!-- table -->
                                                    <div class="table-responsive">
                                                    <table class="table datatables" id="hanif2">
                                                        <thead class="thead-dark">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama Bidang</th>
                                                                <th>Nama Sub Bidang</th>
                                                                <th>Nilai Akhir</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php if(isset($hasilDataChart)): ?>
                                                                <?= $hasilDataChart['tableHtml']; ?>
                                                                <?= $hasilDataChart['keteranganHtml']; ?>
                                                        <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                    </div>
                                                <?php endif; ?>   
                                          </div>
                                      </div>
                                  </div>
                                  <!-- simple table -->
                              </div>
                              <!-- end section -->
                          </div>
                          <!-- .col-12 -->
                      </div>
                      </section>
                    </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                    </div> <!-- /. col -->
                    <div class="col-md-6 mb-4">
                    <div class="card shadow">
                    <div class="card-header">
                        <strong class="card-title mb-0">Hasil Sub Bidang yang Direkomendasikan oleh Dosen</strong>
                    </div>
                    <div class="card-body">
                    <section>
                                    <div class="row justify-content-center">
                                        <div class="col-12">
                                            <div class="row my-1">
                                                <!-- Small table -->
                                                <div class="col-md-12">
                                                    <div class="card shadow">
                                                        <div class="card-body">
                                                        <div class="card-body text-center">
                                                            <div class="avatar avatar-lg mt-4">
                                                                <a href="">
                                                                <img src="<?= base_url('../sipema_assets/img/keterampilan.png') ?>" alt="..." class="avatar-img rounded-circle">
                                                                </a>
                                                            </div>
                                                            <div class="card-text my-2 mt-4">
                                                                <?php if(isset($rekomendasi_sub_bidang[0])) : ?>
                                                                    <?php if($rekomendasi_sub_bidang[0]['nama_sub_bidang'] == null && $rekomendasi_sub_bidang[0]['nama'] == null) : ?>
                                                                        <h6 style="color:red"><center>Hasil Pemetaan Belum Tersedia</center></h6>
                                                                    <?php elseif($rekomendasi_sub_bidang[0]['nama_sub_bidang'] != null && $rekomendasi_sub_bidang[0]['nama'] != null) : ?>
                                                                        <strong class="card-title my-0">Sub Bidang : <?= $rekomendasi_sub_bidang[0]['nama_sub_bidang'] ?></strong>
                                                                        <p>Dosen Pemberi Rekomendasi : <?= $rekomendasi_sub_bidang[0]['nama'] ?></p>
                                                                    <?php endif; ?>
                                                                <?php else : ?>
                                                                    <h6 style="color:red"><center>Hasil Rekomendasi Belum Tersedia</center></h6>
                                                                <?php endif; ?>
                                                            </div>
                                                            </div> <!-- ./card-text -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- simple table -->
                                            </div>
                                            <!-- end section -->
                                        </div>
                                        <!-- .col-12 -->
                                    </div>
                                    </section>
                                            </div>
                                        </div>
                                        </div> <!-- /.card-body -->
                                    </div> <!-- /.card -->
                                    </div> <!-- /. col -->
                                </div> <!-- end section -->
                                    <!-- .row-->
                                </div>
                                <!-- .col-12 -->
                                <div class="col-md-6 mb-4">
                            </div>
                            <!-- .row -->
                        </div>
                <?php else : ?>
                  <div class="col-md-6 mb-4">
                  <div class="card shadow">
                    <div class="card-header">
                      <strong class="card-title mb-0">Pemetaan Keterampilan Bedasarkan Rekomendasi </strong>
                    </div>
                    <div class="card-body">
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
                    <canvas id="myChart" width="400" height="300"></canvas>
                    <script>
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: <?php echo json_encode($data['labels1']); ?>,
                                datasets: [{
                                    label: 'Jumlah',
                                    data: <?php echo json_encode($data['data1']); ?>,
                                    backgroundColor: <?php echo json_encode($data['backgroundColor']); ?>,
                                    borderColor: <?php echo json_encode($data['borderColor']); ?>,
                                    borderColor: 'transparent',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                    legend : {
                                    display: false
                                    },
                                    scales: {
                                        yAxes: [{
                                            beginAtZero: false,
                                            ticks: {
                                                beginAtZero: true,
                                                userCallback: function(label, index, labels) {
                                                    // when the floored value is the same as the value we have a whole number
                                                    if (Math.floor(label) === label) {
                                                        return label;
                                                    }

                                                },
                                            }
                                        }],
                                    }
                            } 
                        });
                    </script>
                    </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                    </div> <!-- /. col -->
                    <div class="col-md-6 mb-4">
                    <div class="card shadow">
        <div class="card-header">
            <strong class="card-title mb-0">Grafik Pemetaan Keterampilan antar Sub Bidang Bedasarkan Nilai </strong>
        </div>
        <div class="card-body">
            <canvas id="chart2" width="400" height="300"></canvas>
            <script>
            var ctx = document.getElementById('chart2').getContext('2d');
            var chart2 = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($data2['labels']); ?>,
                    datasets: [{
                        label: 'Nilai Akhir',
                        data: <?php echo json_encode($data2['datasets'][0]['data']); ?>,
                        backgroundColor: <?php echo json_encode($data2['datasets'][0]['backgroundColor']); ?>,
                        borderColor: <?php echo json_encode($data2['datasets'][0]['borderColor']); ?>,
                        borderWidth: 1
                    }]
                },
                options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        },
                                        plugins: {
                                        datalabels: {
                                            color: 'white',
                                            labels: {
                                                title: {
                                                    font: {
                                                    weight: 'bold'
                                                    }
                                                },
                                                value: {
                                                    color: 'green'
                                                }
                                              }
                                            }
                                        }  
                                    }
                                });
                            </script>
                        </div>
                    </div>
                    </div> <!-- /.card-body -->
                  </div> <!-- /.card -->
                </div> <!-- /. col -->
              </div> <!-- end section -->
                <!-- .row-->
            </div>
            <!-- .col-12 -->
        </div>
        <!-- .row -->
    </div>
    <?php endif; ?>
    <!-- .container-fluid -->
    <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="defaultModalLabel">
                        Notifications
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="list-group list-group-flush my-n3">
                        <div class="list-group-item bg-transparent">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="fe fe-box fe-24"></span>
                                </div>
                                <div class="col">
                                    <small><strong>Package has uploaded successfull</strong></small>
                                    <div class="my-0 text-muted small">
                                        Package is zipped and uploaded
                                    </div>
                                    <small class="badge badge-pill badge-light text-muted">1m ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item bg-transparent">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="fe fe-download fe-24"></span>
                                </div>
                                <div class="col">
                                    <small><strong>Widgets are updated successfull</strong></small>
                                    <div class="my-0 text-muted small">
                                        Just create new layout Index, form, table
                                    </div>
                                    <small class="badge badge-pill badge-light text-muted">2m ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item bg-transparent">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="fe fe-inbox fe-24"></span>
                                </div>
                                <div class="col">
                                    <small><strong>Notifications have been sent</strong></small>
                                    <div class="my-0 text-muted small">
                                        Fusce dapibus, tellus ac cursus commodo
                                    </div>
                                    <small class="badge badge-pill badge-light text-muted">30m ago</small>
                                </div>
                            </div>
                            <!-- / .row -->
                        </div>
                        <div class="list-group-item bg-transparent">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="fe fe-link fe-24"></span>
                                </div>
                                <div class="col">
                                    <small><strong>Link was attached to menu</strong></small>
                                    <div class="my-0 text-muted small">
                                        New layout has been attached to the menu
                                    </div>
                                    <small class="badge badge-pill badge-light text-muted">1h ago</small>
                                </div>
                            </div>
                        </div>
                        <!-- / .row -->
                    </div>
                    <!-- / .list-group -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">
                        Clear All
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-shortcut modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="defaultModalLabel">Shortcuts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <div class="row align-items-center">
                        <div class="col-6 text-center">
                            <div class="squircle bg-success justify-content-center">
                                <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
                            </div>
                            <p>Control area</p>
                        </div>
                        <div class="col-6 text-center">
                            <div class="squircle bg-primary justify-content-center">
                                <i class="fe fe-activity fe-32 align-self-center text-white"></i>
                            </div>
                            <p>Activity</p>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-6 text-center">
                            <div class="squircle bg-primary justify-content-center">
                                <i class="fe fe-droplet fe-32 align-self-center text-white"></i>
                            </div>
                            <p>Droplet</p>
                        </div>
                        <div class="col-6 text-center">
                            <div class="squircle bg-primary justify-content-center">
                                <i class="fe fe-upload-cloud fe-32 align-self-center text-white"></i>
                            </div>
                            <p>Upload</p>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-6 text-center">
                            <div class="squircle bg-primary justify-content-center">
                                <i class="fe fe-users fe-32 align-self-center text-white"></i>
                            </div>
                            <p>Users</p>
                        </div>
                        <div class="col-6 text-center">
                            <div class="squircle bg-primary justify-content-center">
                                <i class="fe fe-settings fe-32 align-self-center text-white"></i>
                            </div>
                            <p>Settings</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#hanif2').DataTable();
  });
</script>
</main>
<?php echo $this->include('sipema/sipema_partial/dashboard/footer'); ?>