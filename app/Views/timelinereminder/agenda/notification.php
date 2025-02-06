<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php echo $this->include('master_partial/dashboard/side_menu'); ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Notifikasi Kegiatan</h2>
                    </div>
                    <?php if(has_permission('admin')) : ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a
                                    href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                            </li>
                            <li class="breadcrumb-item active"><a
                                    href="<?= base_url('timelinereminder/agenda') ?>"><small>Agenda Prodi</small></a>
                          </li>
                            <li class="breadcrumb-item active"><a
                                    href="<?= base_url('timelinereminder/agenda/detail/' . $kegiatan->id_kegiatan) ?>"><small>Detail Agenda</small></a>
                          </li>
                            <li class="breadcrumb-item active"><small>Notifikasi</small></li>
                        </ol>
                    </div>
                    <?php endif;?>
                </div>
                <div class="row my-4">
                <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header">
                    <strong class="card-title">Kirim Notifikasi Kegiatan</strong>
                  </div>
                  <div class="card-body">
                    <form method="POST" action="<?=base_url("timelinereminder/agenda/kirim_notifikasi/" . $kegiatan->id_kegiatan)?>" onsubmit="return disableButton()">
                    <div class="form-group row">
                        <label class="col-sm-3" for="penerima">Penerima</label>
                            <div class="col-sm-9">
                             <span><?=$kegiatan->penanggung_jawab_nama?></span>
                            <input type="hidden" name="penerima" value="<?=$kegiatan->pic?>">
                            </div>
                        </div>
                        <div class="form-group row">
                        <div class="col-sm-3">Platform</div>
                        <div class="col-sm-9">
                        <div class="form-check">
                         <input class="form-check-input" type="checkbox" id="gridCheck1" name="platform[]" value="email">
                          <label class="form-check-label" for="gridCheck1">
                          <img src="https://firebasestorage.googleapis.com/v0/b/myfin-ktp.appspot.com/o/Logo%2Femail.png?alt=media&token=fb081954-5bb9-4b12-b8be-c45db6976816" alt="Email Icon" width="20" height="20"> Email
                          </label>
                        </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck2" name="platform[]" value="whatsapp">
                            <label class="form-check-label" for="gridCheck2">
                            <img src="https://firebasestorage.googleapis.com/v0/b/myfin-ktp.appspot.com/o/Logo%2Fwa.png?alt=media&token=97f48b34-b099-4a0d-a0e5-87fc2f05e174" alt="Whatsapp Icon" width="20" height="20"> Whatsapp
                          </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck3" name="platform[]" value="telegram">
                            <label class="form-check-label" for="gridCheck3">
                             <img src="https://firebasestorage.googleapis.com/v0/b/myfin-ktp.appspot.com/o/Logo%2Ftelegram.png?alt=media&token=cb49e0f5-f42c-4d38-b94f-0cf5bf8b8d9c" alt="Telegram Icon" width="20" height="20"> Telegram
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3" for="exampleFormControlTextarea1">Pesan</label>
                        <div class="col-sm-9">
                          <textarea name="pesan" class="form-control" id="exampleFormControlTextarea1" rows="2" required></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3" for="email_subject">Email Subject</label>
                        <div class="col-sm-9">
                          <input id="email_subject" name="email_subject" class="form-control" id="exampleFormControlTextarea1" rows="2" placeholder="Wajib diisi jika platform Email dipilih"></input>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3" for="pesan_email">Pesan Email (Bisa HTML)</label>
                        <div class="col-sm-9">
                          <textarea id="pesan_email" name="pesan_email" class="form-control" id="exampleFormControlTextarea1" rows="2" placeholder="Wajib diisi jika platform Email dipilih"></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3" for="exampleFormControlTextarea1">Pilih Tanggal</label>
                        <div class="col-sm-9">
                        <input
                              name="tanggal"
                              type="text"
                              class="form-control drgpicker"
                              id="date-input1"
                              aria-describedby="button-addon2"
                              rows="2" />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3" for="example-time">Pukul</label>
                        <div class="col-sm-9">
                        <input
                          class="form-control"
                          id="example-time"
                          type="time"
                          name="time"
                          required
                        />
                        </div>
                      </div>
                      <div class="form-group mb-4">
                        <button id="submitBtn" type="submit" class="btn btn-primary">Tambahkan Notifikasi</button>
                      </div>
                    </form>
                  </div>
                  <table class="table table-borderless table-striped">
                <thead>
                  <tr>
                    <th></th>
                    <th class="w-50">Jadwal Notifikasi</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $no = 1;
                  foreach ($notification as $notif) :
                  ?>
                  <tr>
                    <td class="text-center">
                      <div class="circle circle-sm bg-warning">
                        <span class="fe fe-bell fe-16 text-white"></span>
                      </div>
                    </td>
                    <th scope="row">
                      
                    <?php
                                                    if ($notif->schedule_time) {
                                                        $timestamp = intval($notif->schedule_time);
                                                        $dateTime = DateTime::createFromFormat('U.u', number_format($timestamp / 1000, 6, '.', ''));
                                                        if ($dateTime) {
                                                            // Mengubah ke zona waktu lokal
                                                            $dateTime->setTimezone(new DateTimeZone(date_default_timezone_get()));
                                                            $formattedDateTime = $dateTime->format('l, d-m-Y');
                                                            echo $formattedDateTime;
                                                        } else {
                                                            echo "Invalid DateTime";
                                                        }
                                                    } else {
                                                        echo "No Data";
                                                    }
                                        ?>
                    
                    <br />
                      <span class="badge badge-light text-muted">Jadwal</span>
                    </th>
                    <td class="text-muted">
                    <?php if($notif->status_notification) : ?>
                      <span class="badge badge-pill badge-success text-white">Aktif</span>
                      <?php else: ?>
                      <span class="badge badge-pill badge-danger text-white">Tidak Aktif</span>
                      <?php endif; ?>
                  </td>
                    <td>
                      <div class="file-action">
                        <button type="button" class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="text-muted sr-only">Action</span>
                        </button>
                        <div class="dropdown-menu m-2">
                          <a class="dropdown-item" href="<?=base_url("timelinereminder/agenda/notifikasi_edit/" . $kegiatan->id_kegiatan . "/" . $notif->id)?>"><i class="fe fe-edit-3 fe-12 mr-4"></i>Edit Pesan</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach?>
                </tbody>
              </table>
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
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim...';
    submitBtn.disabled = true;

    var emailCheckbox = document.getElementById("gridCheck1");
    var pesanEmail = document.getElementById("pesan_email").value;
    var emailSubject = document.getElementById("email_subject").value;

    if (emailCheckbox.checked && (pesanEmail.trim() === '' || emailSubject.trim() === '')) {
      alert("Mohon lengkapi Pesan Email dan Subject Email.");
      submitBtn.innerHTML = 'Kirim';
      submitBtn.disabled = false;
      return false;
    }

    return true;
  }
</script>
<?php echo $this->include('bot/bot_partial/dashboard/footer'); ?>