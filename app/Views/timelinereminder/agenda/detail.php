<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php echo $this->include('master_partial/dashboard/side_menu'); ?>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Detail Kegiatan</h2>
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
                            <li class="breadcrumb-item active"><small>Detail Agenda</small></li>
                        </ol>
                    </div>
                    <?php endif;?>
                </div>
                <div class="row my-4">
                <div class="col-md-12 mb-4">
                  <div class="card profile shadow">
                    <div class="card-body my-4">
                      <div class="row align-items-center">
                        <div class="col">
                          <div class="row align-items-center">
                            <div class="col-md-7">
                              <h4 class="mb-1"><?=$kegiatan->nama_kegiatan?></h4>
                            </div>
                            <div class="col">
                            </div>
                          </div>
                          <div class="row mb-4">
                            <div class="col-md-7">
                              <p class="text-muted text-justify"><?=$kegiatan->deskripsi_kegiatan?></p>
                            </div>
                            <div class="col">
                                <div class="card mb-4">
                                    <div class="card-body text-center">
                                    <a href="#!" class="avatar avatar-lg">
                                         <img src="https://firebasestorage.googleapis.com/v0/b/myfin-ktp.appspot.com/o/Avatar%2Fuser.png?alt=media&token=22e6fddc-0378-4045-9d39-9fb6d1db9832" alt="..." class="avatar-img rounded-circle">
                                            </a>
                                            <div class="card-text my-2">
                                            <strong class="card-title my-0"><?=$kegiatan->penanggung_jawab_nama?></strong>
                                            <p class="small text-muted mb-0">D3 Teknik Informatika PSDKU</p>
                                             <p class="small"><span class="badge badge-dark">PIC Kegiatan</span></p>
                                            </div>
                                            </div> <!-- ./card-text -->
                                            </div>
                                         </div>
                                        </div>
                          <div class="row align-items-center">
                            <div class="col-md-7 mb-2">
                              <span class="small text mb-0"><strong><h4>
                              <?php
                                if ($kegiatan->waktu_kegiatan) {
                                    $timestamp = intval($kegiatan->waktu_kegiatan);
                                    $dateTime = DateTime::createFromFormat('U.u', number_format($timestamp / 1000, 6, '.', ''));
                                if ($dateTime) {
                                // Mengubah ke zona waktu lokal
                                     $dateTime->setTimezone(new DateTimeZone(date_default_timezone_get()));
                                     $formattedDateTime = $dateTime->format('l, d-m-Y H:i:s');
                                      echo $formattedDateTime;
                                } else {
                                     echo "Invalid DateTime";
                                }
                                } else {
                                  echo "No Data";
                                }
                                ?>
                              </h4></strong></span>
                            </div>
                            <div class="col mb-2">
                            <a href="<?=base_url("timelinereminder/agenda/edit-kegiatan/" . $kegiatan->id_kegiatan )?>" type="button" class="btn mb-2 btn-outline-primary"><span class="fe fe-edit-3 fe-16 mr-2"></span>Edit</a>
                            </div>
                            <div class="col mb-2">
                            <form method="POST" action="<?=base_url("timelinereminder/agenda/hapus-kegiatan/".$kegiatan->id_kegiatan)?>">
                            <input name="_method" type="hidden" value="DELETE">
                              <button type="submit" class="btn mb-2 btn-outline-danger remove-item-btn"
                             data-toggle="tooltip" title='Delete'><i
                             class="fe fe-trash fe-12 mr-4"></i>
                              Hapus</button>
                                                        </form>
                              </div>
                          </div>
                        </div>
                      </div> <!-- / .row- -->
                    </div> <!-- / .card-body - -->
                  </div> <!-- / .card- -->
                </div>
                  
                </div>
                <!-- end section -->
            </div>
            <!-- .col-12 -->
        </div>
        <!-- .row -->
        <div class="card shadow mb-4">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-4 col-md-2 text-center">
                          <a href="profile-posts.html" class="avatar avatar-md">
                          <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_0skurerf.json" background="transparent"  speed="1"  style="width: 100px; height: 100px;" loop autoplay></lottie-player>
                          </a>
                        </div>
                        <div class="col">
                          <h4><strong>Notifikasi Pengingat Kegiatan
                          <?php if ($notification == false) : ?>
                          </strong><span class="badge badge-pill badge-danger text-white">Belum Aktif</span>
                          <?php elseif ($notification == true) : ?>
                            </strong><span class="badge badge-pill badge-success text-white">Aktif</span>
                            <?php endif; ?>
                        </h4>
                          <p class="small text-muted mb-1">Sistem akan mengirim notifikasi / pesan customize</p>
                        </div>
                        <div class="col-4 col-md-auto offset-4 offset-md-0 my-2">
                          <a href="<?=base_url("timelinereminder/agenda/notifikasi/" . $kegiatan->id_kegiatan )?>" class="btn btn-primary">Detail Notifikasi</a>
                        </div>
                      </div>
                    </div> <!-- / .card-body -->
                  </div> <!-- / .card -->
        
                  <div class="card shadow mb-4">
                  <div class="col-12">
                    <br>
                <h2 class="mb-2 page-title">Dokumen Kegiatan</h2>
                <p class="card-text">
                    File Dokumen Kegiatan <?= $kegiatan->nama_kegiatan?>
                </p>
                    <div class="card-body">
                    <a href="<?=base_url("timelinereminder/agenda/tambah-dokumen/" . $kegiatan->id_kegiatan )?>" class="btn btn-primary mb-3">Tambah Dokumen</a>
                                <div class="table-responsive">
              <table class="table table-borderless table-striped">
                <thead>
                  <tr>
                    <th></th>
                    <th class="w-50">Nama Dokumen</th>
                    <th>Kegiatan</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $no = 1;
                  foreach ($dokumen as $dok) :
                  ?>
                  <tr>
                    <td class="text-center">
                      <div class="circle circle-sm bg-light">
                        <span class="fe fe-file-text fe-16 text-muted"></span>
                      </div>
                      <span class="dot dot-md bg-success mr-1"></span>
                    </td>
                    <th scope="row"><?=$dok->nama_dokumen?><br />
                      <span class="badge badge-light text-muted">File</span>
                    </th>
                    <td class="text-muted"><?= $kegiatan->nama_kegiatan?></td>
                    <td>
                      <div class="file-action">
                        <button type="button" class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="text-muted sr-only">Action</span>
                        </button>
                        <div class="dropdown-menu m-2">
                          <!-- <a class="dropdown-item" href="#"><i class="fe fe-edit-3 fe-12 mr-4"></i>Rename</a> -->
                          <form method="POST" action="<?=base_url("timelinereminder/agenda/hapus-dokumen/".$kegiatan->id_kegiatan ."/". $dok->id_dokumen);?>">
                            <input name="_method" type="hidden" value="DELETE">
                              <button type="submit" class="dropdown-item remove-item-btn"
                             data-toggle="tooltip" title='Delete'><i
                             class="fe fe-delete fe-12 mr-4"></i>
                              Delete</button>
                                                        </form>
                          <a class="dropdown-item" href="<?=base_url("timelinereminder/agenda/download-dokumen/" . $dok->id_dokumen)?>"> <i class="fe fe-download fe-12 mr-4"></i>Download</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach?>
                </tbody>
              </table>
                    </div> <!-- / .card-body -->
                  </div> <!-- / .card -->
                </div>
                <!-- end section -->
            </div>
            <!-- .col-12 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container-fluid -->
                </div>
                </div>
    </div>
    <!-- .container-fluid -->


    <div class="modal fade" id="tambahDokumenModal" tabindex="-1" role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="varyModalLabel">Tambah Dokumen</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form method="POST" action="<?=base_url("timelinereminder/agenda/detail/tambah-dokumen/" . $kegiatan->id_kegiatan);?>">
                              <div class="form-group mb-3">
                          <label for="customFile">File Dokumen</label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" name="file_dokumen" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                          </div>
                        </div>

                        <div class="form-group">
                                  <label for="nama_dokumen" class="col-form-label">Nama Dokumen:</label>
                                  <input type="text" class="form-control" name= "nama_dokumen" id="nama_dokumen">
                                </div>
                                <div class="modal-footer">
                              <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn mb-2 btn-primary" >Simpan</button>
                            </div>
                      </form>
                            </div>
                           
                          </div>
                        </div>
                      </div>
</main>

<script>
  function submitForms() {
    var form1 = document.getElementById("form1");
    var form2 = document.getElementById("form2");

    // Menggabungkan data dari kedua formulir
    var combinedData = new FormData(form1);
    for (var pair of new FormData(form2)) {
      combinedData.append(pair[0], pair[1]);
    }

    // Buat elemen form baru untuk mengirim data gabungan
    var combinedForm = document.createElement("form");
    combinedForm.method = "POST";
    combinedForm.action = "<?=base_url("timelinereminder/agenda/detail/tambah-dokumen/" . $kegiatan->id_kegiatan);?>";
    combinedForm.style.display = "none";
    combinedForm.appendChild(document.createElement("input"));

    // Tambahkan data gabungan ke elemen form baru
    for (var pair of combinedData) {
      var input = document.createElement("input");
      input.type = "hidden";
      input.name = pair[0];
      input.value = pair[1];
      combinedForm.appendChild(input);
    }

    // Tambahkan elemen form baru ke dokumen
    document.body.appendChild(combinedForm);

    // Submit elemen form baru
    combinedForm.submit();
  }
</script>

<?php echo $this->include('bot/bot_partial/dashboard/footer'); ?>