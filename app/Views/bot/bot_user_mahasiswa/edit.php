<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php echo $this->include('master_partial/dashboard/side_menu'); ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Edit User Mahasiwa</h2>
                    </div>
                </div>
                <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header">
                    <strong class="card-title">Form Edit User Mahasiswa</strong>
                  </div>
                  <div class="card-body">
                  <div class="list-group list-group-flush my-n3">
                        <div class="list-group-item">
                          <div class="row align-items-center">
                            <div class="col-auto">
                              <span class="circle circle-sm bg-warning"><i class="fe fe-alert-circle fe-16 text-white"></i></span>
                            </div>
                            <div class="col">
                              <medium><strong>Peringatan !</strong></medium>
                              <div class="mb-2 text-muted medium"><strong class="mb-2 text-warning medium" >Mengubah Informasi Alamat Email dan Nomor WA Berpengaruh Dalam Penerimaan Notifikasi dan Blast Chat</strong></div>
                              <div class="mb-2 text-muted medium"><strong class="mb-2 text-warning medium" >Username Telegram Tidak Dapat Diubah, Jika Ingin Mengganti Username Telegram Bisa Hapus User dan Registrasi Ulang</strong></div>
                            </div>
                          </div> <!-- / .row -->
                </div>
                <br>
                  <?php foreach ($mahasiswa as $mahasiswa): ?>
                    <form method="POST" action="<?=base_url("bot/kelola_bot/user/mahasiswa/simpan-edit/". $mahasiswa->id_user_bot)?>" onsubmit="disableButton()">
                    <div class="form-group mb-3">
                        <label for="simpleinput">Nama Mahasiswa</label>
                        <input readonly=""  required value="<?=$mahasiswa->nama?>" type="text" id="simpleinput" name="nama" class="form-control">
                      </div>
                      <div class="form-group mb-3">
                        <label for="simpleinput">Email</label>
                        <input required value="<?=$mahasiswa->email?>" type="text" id="simpleinput" name="email" class="form-control">
                      </div>
                      <div class="form-group mb-3">
                        <label for="simpleinput">Telegram</label>
                        <input required readonly="" value="<?=$mahasiswa->username_telegram?>" type="text" id="simpleinput" name="telegram" class="form-control">
                      </div>
                      <div class="form-group mb-3">
                        <label for="simpleinput">Whatsapp</label>
                        <input required value="<?=$mahasiswa->no_wa?>" type="text" id="simpleinput" name="whatsapp" class="form-control">
                      </div>
                      <div class="form-group mb-3">
                      <label for="example-select">Status Notifikasi</label>
                                        <select name="status_notification"
                                            class="form-control select2">
                                            <option value="1">Aktif</option>
                                            <option value="0">Mute
                                            </option>
                                        </select>
                      </div>
                      <div id="formContainer">
                      <!-- Kontainer untuk menampilkan elemen form -->
                      </div>
                      <div class="form-group mb-2">
                        <button id="submitBtn" type="submit" class="btn btn-primary">Update Perubahan</button>
                      </div>
                    </form>
                    <?php endforeach?>
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