<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/side_menu'); ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Register Chatbot</h2>
                    </div>
                </div>
                <div class="row my-4">
                <div class="card-body">
                  <form method="POST" action="<?=base_url("bot/register_chatbot/submit")?>" onsubmit="disableButton()">
                    <div>
                      <h4>Get Started</h4>
                      <section>
                      <div class="card-body">
                      <div class="list-group list-group-flush my-n3">
                        <div class="list-group-item">
                          <div class="row align-items-center">
                            <div class="col-auto">
                              <span class="circle circle-sm bg-warning"><i class="fe fe-alert-circle fe-16 text-white"></i></span>
                            </div>
                            <div class="col">
                              <small><strong>Tentang Chatbot</strong></small>
                              <div class="mb-2 text-muted small">Chatbot adalah fitur untuk mencari informasi tentang kegiatan prodi dengan cara interaksi secara langsung dengan bot Telegram, selain itu juga untuk notifikasi kegiatan prodi</div>
                            </div>
                            <div class="col-auto pr-0">
                              <small class="fe fe-more-vertical fe-16 text-muted"></small>
                            </div>
                          </div> <!-- / .row -->
                        </div><!-- / .list-group-item -->
                        <div class="list-group-item">
                          <div class="row align-items-center">
                            <div class="col-auto">
                              <span class="circle circle-sm bg-primary"><i class="fe fe-send fe-16 text-white"></i></span>
                            </div>
                            <div class="col">
                              <small><strong>Telegram</strong></small>
                              <div class="mb-2 text-muted small">Pastikan kamu sudah mempunyai akun telegram dan mengakses <strong><a href="https://t.me/d3timadiun_bot">Chatbot Prodi D3TI PSDKU</a>.</strong> Jika belum mempunyai akun telegram bisa daftar terlebih dahulu.</div>
                            </div>
                            <div class="col-auto pr-0">
                              <small class="fe fe-more-vertical fe-16 text-muted"></small>
                            </div>
                          </div> <!-- / .row -->
                        </div><!-- / .list-group-item -->
                        <div class="list-group-item">
                          <div class="row align-items-center">
                            <div class="col-auto">
                              <span class="circle circle-sm bg-success"><i class="fe fe-message-circle fe-16 text-white"></i></span>
                            </div>
                            <div class="col">
                              <small><strong>Whatsapp</strong></small>
                              <div class="mb-2 text-muted small">Pastikan juga kamu mempunyai nomor Whatsapp dan Aktif digunakan sehari - hari</div>
                            </div>
                            <div class="col-auto pr-0">
                              <small class="fe fe-more-vertical fe-16 text-muted"></small>
                            </div>
                          </div> <!-- / .row -->
                        </div><!-- / .list-group-item -->
                      </div> <!-- / .list-group -->
                    </div>
                    <br>
                      </section>
                      <h4>Lengkapi Data</h4>
                      <section>
                      <div class="col-md-12">
                      <div class="card shadow mb-4">
                      <div class="card-body">
                        <?php foreach ($nama as $nama) : ?>
                      <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input readonly="" value="<?=$nama->nama?>" id="nama" name="nama" type="text" class="form-control" required>
                        </div>
                        <?php endforeach ?>
                        <div class="form-group">
                          <label for="email">Email UNS</label>
                          <input readonly="" id="email" value="<?= user()->email; ?>" name="email" type="text" class="form-control required email">
                        </div>
                        <div class="form-group">
                          <label for="address">No Whatsapp</label>
                          <input id="phone" name="no_wa" class="form-control" type="number" required>
                        </div>
                        <div class="help-text text-muted">Pastikan Mengisikan Nomor Whatsapp Aktif Digunakan</div>
                      </div>
                      </div>
                      </div>
                      </section>
                      <div class="form-group mb-2">
                        <button id="submitBtn" type="submit" class="btn btn-primary">Registrasi</button>
                      </div>
                    </div>
                  </form>
                </div>
        </div>
        <!-- .row -->
    </div>
</main>
<script>
  function disableButton() {
    var submitBtn = document.getElementById("submitBtn");
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Proses Register...';
    submitBtn.disabled = true;
  }
</script>
<?php echo $this->include('bot/bot_partial/dashboard/footer'); ?>