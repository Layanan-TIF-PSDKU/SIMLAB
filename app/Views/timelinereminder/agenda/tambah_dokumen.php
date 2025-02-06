<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php echo $this->include('master_partial/dashboard/side_menu'); ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Tambah Dokumen Kegiatan</h2>
                    </div>
                </div>
                <div class="row my-4">
                <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header">
                    <strong class="card-title">Tambahkan Dokumen</strong>
                  </div>
                  <div class="card-body">
                  <form method="POST" enctype="multipart/form-data" action="<?=base_url("timelinereminder/agenda/simpan-dokumen/" . $id_kegiatan)?>" onsubmit="return disableButton()">
                  <div class="form-group mb-3">
                                        <label for="customFile">Upload Berkas</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile"
                                                name="file_dokumen" required>
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                        <div class="form-group">
                                  <label for="nama_dokumen" class="col-form-label">Nama Dokumen:</label>
                                  <input type="text" class="form-control" name= "nama_dokumen" id="nama_dokumen">
                                </div>
                              <button id="submitBtn" type="submit" class="btn mb-2 btn-primary" >Simpan</button>
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
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploadin...';
    submitBtn.disabled = true;
  }
</script>
<?php echo $this->include('bot/bot_partial/dashboard/footer'); ?>