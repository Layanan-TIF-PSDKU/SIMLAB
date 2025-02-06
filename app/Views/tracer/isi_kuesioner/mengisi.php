<?= $this->include('tracer/dashboard/header');?>
<?= $this->include('tracer/dashboard/top_menu');?>
<?= $this->include('tracer/dashboard/side_menu');?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row align-items-center mb-2">
                    <div class="col">
                        <h2 class="h5 page-title">Pengisian Kuesioner</h2>
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
                                <form method="POST" action="<?= base_url('tracer/isi_kuesioner/simpan') ?>">
                                    <?php foreach ($pertanyaan_kuesioner as $pk): ?>
                                    <input type="hidden" id="address-wpalaceholder" name="id_jadwal_kuesioner" class="form-control" value="<?= $jadwal_kuesioner->id_jadwal_kuesioner ?>" />
                                    <input type="hidden" id="address-wpalaceholder" name="id_user" class="form-control" value="<?= user()->id; ?>" />
                                    <?php $no = 1; ?>
                                        <tr>
                                            <input type="hidden" id="address-wpalaceholder" name="id_pertanyaan[]" class="form-control" value="<?= $pk->id_pertanyaan ?>" />
                                            <input type="hidden" id="address-wpalaceholder" name="pertanyaan[]" class="form-control" value="<?= $pk->pertanyaan ?>" />
                                            <td><?= $no++ ?>. <?= $pk->pertanyaan ?></td><br>
                                            <td>
                                                <input type="radio" name="pilihan[]<?= $pk->id_pertanyaan ?>" value="<?= $pk->pilihan1 ?>" required /><?= $pk->pilihan1 ?>
                                                <input type="radio" name="pilihan[]<?= $pk->id_pertanyaan ?>" value="<?= $pk->pilihan2 ?>" required /><?= $pk->pilihan2 ?>
                                            </td>
                                            <hr>
                                        </tr>
                                    <?php endforeach ?>

                                    <?php foreach ($pertanyaan_isian as $pi): ?>
                                    <input type="hidden" id="address-wpalaceholder" name="id_jadwal_kuesioner_isian" class="form-control" value="<?= $jadwal_kuesioner->id_jadwal_kuesioner ?>" />
                                    <input type="hidden" id="address-wpalaceholder" name="id_user_isian" class="form-control" value="<?= user()->id; ?>" />
                                        <tr>
                                            <input type="hidden" id="address-wpalaceholder" name="id_pertanyaan_isian[]" class="form-control" value="<?= $pi->id_pertanyaan_isian ?>" />
                                            <input type="hidden" id="address-wpalaceholder" name="pertanyaan_isian[]" class="form-control" value="<?= $pi->pertanyaan_isian ?>" />
                                            <td><?= $pi->pertanyaan_isian ?></td><br>
                                            <td>
                                                <input type="text" id="address-wpalaceholder" name="isian[]<?= $pi->id_pertanyaan_isian ?>" class="form-control" required />
                                            </td>
                                            <hr>
                                        </tr>
                                    <?php endforeach ?>
                                    <div class="text-right">
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                        <a href="<?= base_url('tracer/isi_kuesioner'); ?>" class="btn btn-warning text-light">Kembali</a>
                                    </div>
                                </form>
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