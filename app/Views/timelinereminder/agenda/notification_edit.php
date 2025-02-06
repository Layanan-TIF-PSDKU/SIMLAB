<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php echo $this->include('master_partial/dashboard/side_menu'); ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Edit Notifikasi</h2>
                    </div>
                </div>
                <div class="row my-4">
                <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header">
                    <strong class="card-title">Edit Notifikasi</strong>
                  </div>
                  <div class="card-body">
                  <?php foreach ($notification as $notification) :
                  ?>
                    <form method="POST" action="<?=base_url("timelinereminder/agenda/simpan_notifikasi_edit/" . $kegiatan->id_kegiatan . "/" . $notification->id)?>" onsubmit="return disableButton()">
                    <div class="form-group row">
                        <label class="col-sm-3" for="penerima">Penerima</label>
                            <div class="col-sm-9">
                             <span><?=$kegiatan->penanggung_jawab_nama?></span>
                            <input type="hidden" name="penerima" value="<?=$kegiatan->pic?>">
                            </div>
                        </div>
                        <div class="form-group row">
                        <label class="col-sm-3" for="simple-select2">Status Notifikasi</label>
                        <div class="col-sm-9">
                          <select
                            class="form-control select2"
                            id="simple-select2"
                            name = "status_notifikasi"
                            required
                          >
                              <option value="1">Aktif</option>
                              <option value="0">Tidak Aktif</option>
                          </select>
                       </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3" for="exampleFormControlTextarea1">Pesan</label>
                        <div class="col-sm-9">
                          <textarea name="pesan" class="form-control" id="exampleFormControlTextarea1" rows="2"><?=$notification->pesan?></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3" for="email_subject">Email Subject</label>
                        <div class="col-sm-9">
                          <input value="<?=$notification->subject_email?>" name="email_subject" class="form-control" id="email_subject" rows="2" placeholder="Wajib diisi jika platform Email dipilih"></input>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3" for="pesan_email">Pesan Email (Bisa HTML)</label>
                        <div class="col-sm-9">
                          <textarea class="form-control" name="pesan_email" id="pesan_email" rows="2" placeholder="Wajib diisi jika platform Email dipilih"><?=$notification->pesan_email?></textarea>
                        </div>
                        </div>
                      <div class="form-group mb-4">
                        <button id="submitBtn" type="submit" class="btn btn-primary">Update Notifikasi</button>
                      </div>
                      <?php endforeach?>
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
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
    submitBtn.disabled = true;
  }
</script>
<?php echo $this->include('bot/bot_partial/dashboard/footer'); ?>