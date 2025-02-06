<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php echo $this->include('master_partial/dashboard/side_menu'); ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Edit Kegiatan</h2>
                    </div>
                </div>
                <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header">
                    <strong class="card-title">Form Edit Kegiatan</strong>
                  </div>
                  <div class="card-body">
                    <form method="POST" action="<?=base_url("timelinereminder/agenda/simpan-edit-kegiatan/". $kegiatan->id_kegiatan)?>" onsubmit="disableButton()">
                    <div class="form-group mb-3">
                        <label for="simpleinput">Nama Kegiatan</label>
                        <input value="<?=$kegiatan->nama_kegiatan?>" type="text" id="simpleinput" name="nama_kegiatan" class="form-control">
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-12" name= "pesan" for="exampleFormControlTextarea1">Deskripsi Kegiatan</label>
                        <div class="col-sm-12">
                          <textarea class="form-control" placeholder="Penjelasan Kegiatan" name= "deskripsi_kegiatan" id="exampleFormControlTextarea1" rows="2"><?=$kegiatan->deskripsi_kegiatan?></textarea>
                               <!-- Error Validation -->
                        </div>
                      </div>
                      <div class="form-group mb-3">
                                        <label for="example-select">Penanggung jawab Kegiatan (PIC)</label>
                                        <select name="id_staf"
                                            class="form-control select2 <?= ($validation->hasError('id_staf')) ? 'is-invalid' : ''; ?>">
                                            <option value="<?=$kegiatan->pic?>"><?=$kegiatan->penanggung_jawab_nama?></option>
                                            <?php foreach ($staf as $s) : ?>
                                            <option value="<?= $s->id_staf ?>"><?= $s->nama ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('id_staf'); ?>
                                        </div>
                                    </div>
                      <div class="form-group mb-3">
                          <label for="date-input1">Tanggal Kegiatan</label>
                          <div class="input-group">
                            <input
                              type="text"
                              name="tanggal_kegiatan"
                              class="form-control drgpicker"
                              id="date-input1"
                              value="<?=$tanggal?>"
                              aria-describedby="button-addon2"
                            />
                            <div class="input-group-append">
                              <div
                                class="input-group-text"
                                id="button-addon-date"
                              >
                                <span class="fe fe-calendar fe-16"></span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group mb-3">
                        <label for="example-time">Pukul</label>
                        <input
                          class="form-control"
                          id="example-time"
                          type="time"
                          name="time"
                          value="<?=$pukul?>"
                        />
                      </div>
                      <div id="formContainer">
                      <!-- Kontainer untuk menampilkan elemen form -->
                      </div>
                      <div class="form-group mb-2">
                        <button id="submitBtn" type="submit" class="btn btn-primary">Update Perubahan</button>
                      </div>
                    </form>
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
<script>
  function disableButton() {
    var submitBtn = document.getElementById("submitBtn");
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Proses...';
    submitBtn.disabled = true;
  }
</script>
<?php echo $this->include('bot/bot_partial/dashboard/footer'); ?>