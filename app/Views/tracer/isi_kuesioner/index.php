<?= $this->include('tracer/dashboard/header');?>
<?= $this->include('tracer/dashboard/top_menu');?>
<?= $this->include('tracer/dashboard/side_menu');?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row align-items-center mb-2">
                    <div class="col">
                        <h2 class="h5 page-title">Jadwal Kuesioner</h2>
                    </div>
                    <div class="col-auto">
                        <form class="form-inline">
                            <div class="form-group d-none d-lg-inline">
                                <label for="reportrange" class="sr-only">Date Ranges</label>
                                <div id="reportrange" class="px-2 py-2 text-muted">
                                    <span class="small"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-sm">
                                    <span class="fe fe-refresh-ccw fe-16 text-muted"></span>
                                </button>
                                <button type="button" class="btn btn-sm mr-2">
                                    <span class="fe fe-filter fe-16 text-muted"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Jadwal Kuesioner</th>
                                            <th>Tahun</th>
                                            <th>action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($jadwal_kuesioner as $jk): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $jk->nama ?></td>
                                            <td><?= $jk->tahun ?></td>
                                            <td><a href="<?= base_url("tracer/isi_kuesioner/mengisi/$jk->id_jadwal_kuesioner"); ?>" class="">Isi Kuesioner</a></td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- simple table -->
                </div>
                
            </div>
            <!-- .col-12 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container-fluid -->
</main>
<?= $this->include('tracer/dashboard/footer');?>