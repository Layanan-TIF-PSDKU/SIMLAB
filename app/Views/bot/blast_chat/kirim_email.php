<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php echo $this->include('master_partial/dashboard/side_menu'); ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Blast Chat</h2>
                    </div>
                    <?php if(has_permission('admin')) : ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a
                                    href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                            </li>
                            <li class="breadcrumb-item active"><a
                                    href="<?= base_url('bot/blast_chat') ?>"><small>Blast Chat</small></a></li>
                            <li class="breadcrumb-item active"><small>Kirim Email</small></li>
                        </ol>
                    </div>
                    <?php endif;?>
                </div>
                <div class="row my-4">
                <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header">
                    <strong class="card-title">Kirim Email</strong>
                  </div>
                  <div class="card-body">
                  <a class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                        href="<?=base_url('bot/blast_chat/download-format-blast-email');?>">
                                                        <span class="fe fe-download-cloud fe-16 align-middle"></span>Download Format Excel
                                                    </a>
                  <br>
                    <form method="POST" action="<?=base_url('bot/blast_chat/kirim_email/kirim')?>" enctype="multipart/form-data" id="kirimemailForm" onsubmit="disableButton()">
                    <fieldset class="form-group">
                        <div class="row">
                          <label class="col-form-label col-sm-3 pt-0">Mode Pengiriman</label>
                          <div class="col-sm-9">
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="penerima" id="gridRadios1" value="single" checked onchange="togglePenerimaForm(this)">
                              <label class="form-check-label" for="gridRadios1"> Single </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="penerima" id="gridRadios2" value="multiple" onchange="togglePenerimaForm(this)">
                              <label class="form-check-label" for="gridRadios2"> Multiple (Excel) </label>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      <div class="form-group row" >
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Penerima</label>
                        <div class="col-sm-9">
                          <input name="email" type="email" class="form-control" id="singlePenerimaForm" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row" >
                        <label for="inputExcelFile" class="col-sm-3 col-form-label">Import File Excel</label>
                        <div class="col-sm-9">
                        <input name="excel_file" type="file" class="form-control-file" id="multiplePenerimaForm" style="display: none;">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputsubject3" class="col-sm-3 col-form-label">Subject</label>
                        <div class="col-sm-9">
                          <input name="email_subject" type="text" class="form-control" id="inputsubject3" placeholder="Subject" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3" for="exampleFormControlTextarea1">Pesan Email (Bisa HTML)</label>
                        <div class="col-sm-9">
                          <textarea name="pesan_email" class="form-control" id="exampleFormControlTextarea1" rows="2" required></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                                            <label for="inputExcelFile" class="col-sm-3 col-form-label">Lampiran Dokumen (PDF)</label>
                                            <div class="col-sm-9">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile" name="lampiran_file">
                                                   <label class="custom-file-label" for="customFile">Tambahkan Jika Diperlukan | PDF Maks. 5 Mb</label>
                                                </div>
                                            </div>
                                        </div>
                      <div class="form-group mb-2">
                        <button id="submitBtn" type="submit" class="btn btn-primary">Kirim Email</button>
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
  var actionUrl1 = "<?=base_url('bot/blast_chat/kirim_email/kirim_excel')?>";
  var actionUrl2 = "<?=base_url('bot/blast_chat/kirim_email/kirim')?>";
</script>
<script>
  function togglePenerimaForm(radio) {
    var singleForm = document.getElementById('singlePenerimaForm');
    var multipleForm = document.getElementById('multiplePenerimaForm');

    if (radio.value === 'single') {
      singleForm.style.display = 'block';
      multipleForm.style.display = 'none';
      singleForm.required = true; // Tambahkan required di sini
      multipleForm.required = false; // Hapus required jika diperlukan
      document.getElementById('kirimemailForm').action = actionUrl2;
    } else if (radio.value === 'multiple') {
      singleForm.style.display = 'none';
      multipleForm.style.display = 'block';
      singleForm.required = false; // Hapus required jika diperlukan
      multipleForm.required = true; // Tambahkan required di sini
      document.getElementById('kirimemailForm').action = actionUrl1;
    }
  }

  function disableButton() {
    var submitBtn = document.getElementById("submitBtn");
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim...';
    submitBtn.disabled = true;
  }
</script>
<?php echo $this->include('bot/bot_partial/dashboard/footer'); ?>