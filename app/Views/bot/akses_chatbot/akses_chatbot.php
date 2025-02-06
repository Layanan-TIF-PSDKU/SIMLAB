<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/side_menu'); ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Akses Chatbot</h2>
                    </div>
                </div>
                <div class="row my-4">
                <div class="card-body">
                <h5>Akun Terdaftar Di Chatbot</h5>
                <p>Berikut adalah akun Telegram yang tertaut di Chatbot </p>
                <?php foreach ($data_user as $user) : ?>
                  <?php foreach ($nama as $nama) : ?>
                <div class="list-group mb-5 shadow">
                <div class="list-group-item">
                    <div class="row align-items-center">
                      <div class="col">
                      <p class="text-muted mb-0">Nama Lengkap</p>
                        <strong class="mb-2"><?=$nama->nama?></strong>
                      </div> <!-- .col -->
                    </div> <!-- .row -->
                  </div> <!-- .list-group-item -->
                  <div class="list-group-item">
                    <div class="row align-items-center">
                      <div class="col">
                      <p class="text-muted mb-0">Username Telegram</p>
                        <strong class="mb-2"><?=$user->username_telegram?></strong>
                      </div> <!-- .col -->
                    </div> <!-- .row -->
                  </div> <!-- .list-group-item -->
                  <div class="list-group-item">
                    <div class="row align-items-center">
                      <div class="col">
                      <p class="text-muted mb-0">Nomor Whatsapp</p>
                        <strong class="mb-2"><?=$user->no_wa?></strong>
                      </div> <!-- .col -->
                      <div class="col-auto">
                        <button data-toggle="modal" data-target="#editTagModal-<?=$user->id_user_bot;?>" class="btn btn-primary btn-sm">Ubah</button>
                      </div> <!-- .col -->
                    </div> <!-- .row -->
                  </div> <!-- .list-group-item -->
                  <div class="list-group-item">
                    <div class="row align-items-center">
                      <div class="col">
                        <strong class="mb-2">Ganti Akun Telegram ?</strong>
                      </div> <!-- .col -->
                      <div class="col-auto">
                        <p class="text-muted mb-0">Hubungi Admin Prodi Jika Anda Ingin Mengubah Akun Telegram</p>
                      </div> <!-- .col -->
                    </div> <!-- .row -->
                  </div> <!-- .list-group-item -->
                </div> 
                </div>
        </div>
        <!-- .row -->
        <?php if (has_permission('dosen', 'pimpinan','admin')): ?>
        <div class="row my-4">
          <div class="card-body">
          <h5>Status Nofitikasi Bot</h5>
          <p>Berikut adalah untuk merubah status notifikasi pada akun anda </p>
        <div class="list-group mb-5 shadow">
        <div class="list-group-item">
                    <div class="row align-items-center">
                      <div class="col">
                      <?php if ($user->status_notification == false) : ?>
                        <strong class="mb-2">Aktifkan Notifikasi Anda
                          </strong><span class="badge badge-pill badge-danger text-white">Mute</span>
                          <p class="text-warning mb-0">Notifikasi anda tidak aktif. saat ini anda tidak dapat menerima pesan notifikasi dari chatbot di semua platform. <strong class="text-warning mb-0" >Termasuk anda tidak akan menerima notifikasi pengingat kegiatan prodi jika anda menjadi PIC Kegiatan</strong></p>
                          <?php elseif ($user->status_notification == true) : ?>
                            <strong class="mb-2">Non Aktifkan Notifikasi ?
                            </strong><span class="badge badge-pill badge-success text-white">Aktif</span>
                        </strong>
                        <p class="text-warning mb-0">Dengan menonaktifkan notifikasi maka anda tidak akan menerima pesan notifikasi dari chatbot di semua platform. <strong class="text-warning mb-0" >Termasuk anda tidak akan menerima notifikasi pengingat kegiatan prodi jika anda menjadi PIC Kegiatan</strong></p>
                        <?php endif; ?>
                      </div> <!-- .col -->
                      <div class="col-auto">
                      <form method="POST" onsubmit="disableButton()" action="<?=base_url("bot/akses_chatbot/ubah-status-notifikasi/" . $user->id_user_bot);?>">
                      <?php if ($user->status_notification == false): ?>
                            <input type="hidden" name="status_notification" value="1">
                              <button id="submitBtn" type="submit" class="btn btn-primary btn-sm"><i
                             class="fe fe-bell fe-12 mr-4"></i>
                              Aktifkan</button>
                      <?php elseif ($user->status_notification == true): ?>
                        <input  type="hidden" name="status_notification" value="0">
                              <button id="submitBtn" type="submit" class="btn btn-secondary btn-sm"><i
                             class="fe fe-bell-off fe-12 mr-4"></i>
                              Nonaktifkan</button>
                      <?php endif; ?>
                                                        </form>
                      </div> <!-- .col -->
                    </div> <!-- .row -->
                  </div> <!-- .list-group-item -->
                  </div>
                  </div>
                  <?php endif; ?>
                  <?php endforeach; ?>
                <?php endforeach; ?>
        </div>
    </div>
</main>
                            <!-- Edit Tag modal -->
                <?php foreach ($data_user as $user): ?>
                <div class="modal fade" id="editTagModal-<?=$user->id_user_bot;?>" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="varyModalLabel">Ubah Nomor Whatsapp</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body p-4">
                      <form method="POST" action="<?=base_url("bot/akses_chatbot/update-nomor-wa/" . $user->id_user_bot);?>" onsubmit="disableButton()">
                      <div class="list-group list-group-flush my-n3">
                        <div class="list-group-item">
                          <div class="row align-items-center">
                            <div class="col-auto">
                              <span class="circle circle-sm bg-warning"><i class="fe fe-alert-circle fe-16 text-white"></i></span>
                            </div>
                            <div class="col">
                              <medium><strong>Peringatan !</strong></medium>
                              <div class="mb-2 text-muted medium"><strong class="mb-2 text-warning medium" >Mengubah Nomor Whatsapp Berpengaruh Dalam Penerimaan Notifikasi Anda, Pastikan Nomor WA sudah benar dan Aktif</strong></div>
                            </div>
                          </div> <!-- / .row -->
                    </div>
                        <div class="form-group">
                          <label for="tag-update" name="tag-baru" class="col-form-label">Nomor Whatsapp</label>
                          <input type="text" class="form-control" id="tag-update" name="whatsapp" value="<?=$user->no_wa;?>" placeholder="Ubah Tag"></input>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                      <button id="submitBtn" type="submit" class="btn mb-2 btn-primary">Simpan</button>
                    </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <?php endforeach?>
<script>
  function disableButton() {
    var submitBtn = document.getElementById("submitBtn");
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Proses...';
    submitBtn.disabled = true;
  }
</script>
<?php echo $this->include('bot/bot_partial/dashboard/footer'); ?>