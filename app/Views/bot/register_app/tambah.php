<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php echo $this->include('master_partial/dashboard/side_menu'); ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Tambah Hak Akses API Chatbot</h2>
                    </div>
                </div>
                <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header">
                    <strong class="card-title">Tambah Aplikasi</strong>
                  </div>
                  <div class="card-body">
                    <form method="POST" action="<?=base_url("bot/register_app/tambah/submit")?>">
                      <div class="form-group row">
                        <label class="col-sm-12" name= "pesan" for="exampleFormControlTextarea1">ID Register</label>
                        <div class="col-sm-12">
                          <input class="form-control" placeholder="Buat ID Register" name= "id_register" id="exampleFormControlTextarea1" rows="2"></input>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-12" name= "pesan" for="exampleFormControlTextarea1">Detail Aplikasi</label>
                        <div class="col-sm-12">
                          <textarea class="form-control" placeholder="Jelaskan Nama Aplikasi" name= "detail_aplikasi" id="exampleFormControlTextarea1" rows="2"></textarea>
                        </div>
                      </div>
                      <div class="form-group mb-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
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
<?php echo $this->include('bot/bot_partial/dashboard/footer'); ?>