<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php echo $this->include('master_partial/dashboard/side_menu'); ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Kelola Chatbot</h2>
                    </div>
                </div>
                <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header">
                    <strong class="card-title">Edit Respons Chatbot Telegram</strong>
                  </div>
                  <div class="card-body">
                    <!-- Update Pesan -->
                    <form method="POST" action="<?=base_url("bot/kelola_bot/update/" . $message->id)?>">
                      <div class="form-group row">
                        <label class="col-sm-12" name= "pesan" for="exampleFormControlTextarea1">Pesan</label>
                        <div class="col-sm-12">
                          <textarea class="form-control" name= "pesan" id="exampleFormControlTextarea1" rows="2"><?=$message->message?></textarea>
                               <!-- Error Validation -->
                        </div>
                      </div>
                      <div class="form-group mb-2">
                        <button type="submit" class="btn btn-outline-primary">Update Pesan</button>
                      </div>
                    </form>
                    <hr>
                    <form method="POST" action="<?=base_url("bot/kelola_bot/edit/hapus_lampiran/$message->id");?>">
                      <div class="d-flex justify-content-between align-items-center">
                          <div class="form-check form-check-inline ml-1">
                          <strong>Lampiran File (PDF)</strong>
                          </div>
                          <?php if ($message->attachment != "-") : ?>
                          <div class="flex-fill mr-2 text-right">
                            <a href="<?=base_url("bot/kelola_bot/download-lampiran/$message->id");?>" class="btn"><i class="fe fe-download"></i></a>
                            <a href="<?=base_url("bot_assets/lampiran/chatbot/$message->attachment");?>" target="_blank" class="btn"><i class="fe fe-eye"></i></a>
                          </div>
                          <button data-toggle="modal" data-target="#ubahLampiranModal"  type="button" class="btn mb-2 btn-primary">Ubah</button>
                          <button type="submit" class="btn mb-2 btn-light">Hapus</button>
                          <?php else : ?>
                          <button data-toggle="modal" data-target="#tambahLampiranModal"  type="button" class="btn btn-primary">Tambah Lampiran</button>
                          <?php endif; ?>
                        </div>
                        <hr>
                        <br>
                    </form>
                    <!-- Update Tag -->
                                <!-- table -->
                                <a data-toggle="modal" data-target="#tagModal"
                                    class="btn btn-outline-primary mb-3">Tambah Tag</a>
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Tag</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no = 1;?>
                                    <?php foreach ($tag as $tagItem): ?>
    <tr>
        <td><?=$no++?></td>
        <td><?=$tagItem->tag?></td>
        <td>
            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" data-toggle="modal" data-target="#editTagModal-<?=$tagItem->id_tag;?>"> <i class="fe fe-edit fe-16"></i> Edit</a>
            <form method="POST" action="<?=base_url("bot/kelola_bot/edit/hapus_tag/$tagItem->id_tag");?>">
             <input name="_method" type="hidden" value="DELETE">
            <button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title='Delete'><i class="fe fe-delete fe-16"></i> Delete</button>
                                                            <!-- <a class="btn dropdown-item" style="color:black" onclick="deletedatanilai()">Hapus</a> -->
            </form>
            </div>

        </td>
    </tr>
<?php endforeach?>
                                    </tbody>
                                </table>
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
              <!-- Tambah Tag modal -->
              <div class="modal fade" id="tagModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="varyModalLabel">Tambah Tag Baru</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body p-4">
                      <form method="POST" action="<?=base_url('bot/kelola_bot/edit/tambah_tag/' . $message->id);?>">
                        <div class="form-group">
                          <label for="tag-baru" name="tag-baru" class="col-form-label">Tag</label>
                          <input type="text" class="form-control" id="tag-baru" name="tag-baru" placeholder="Tambah Tag Baru">
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                      <button type="submit" class="btn mb-2 btn-primary">Simpan</button>
                    </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

                            <!-- Edit Tag modal -->
                 <?php foreach ($tag as $tagItem): ?>
                <div class="modal fade" id="editTagModal-<?=$tagItem->id_tag;?>" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="varyModalLabel">Edit Tag</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body p-4">
                      <form method="POST" action="<?=base_url("bot/kelola_bot/edit/update_tag/" . $tagItem->id_tag);?>">
                        <div class="form-group">
                          <label for="tag-update" name="tag-baru" class="col-form-label">Tag</label>
                          <input type="text" class="form-control" id="tag-update" name="tag-update" value="<?=$tagItem->tag;?>" placeholder="Ubah Tag"></input>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                      <button type="submit" class="btn mb-2 btn-primary">Simpan</button>
                    </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <?php endforeach?>

              <div class="modal fade" id="tambahLampiranModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="varyModalLabel">Tambah Lampiran</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body p-4">
                      <form method="POST" enctype="multipart/form-data" action="<?=base_url("bot/kelola_bot/edit/tambah_lampiran/" . $message->id)?>" onsubmit="return disableButton()">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <input type="file" class="custom-file-input" id="customFile" name="lampiran_file">
                          <label class="custom-file-label" for="customFile">Tambah file lampiran | PDF Maks. 5 Mb</label>
                        </div>
                 </div>
                        <div class="modal-footer d-flex justify-content-between">
                      <button type="submit" class="btn mb-2 btn-primary">Simpan</button>
                    </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>


              <div class="modal fade" id="ubahLampiranModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="varyModalLabel">Ubah Lampiran</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body p-4">
                      <form method="POST" enctype="multipart/form-data" action="<?=base_url("bot/kelola_bot/edit/tambah_lampiran/" . $message->id)?>">
                        <div class="form-group">
                        <div class="col-sm-12">
                          <input type="file" class="custom-file-input" id="customFile" name="lampiran_file">
                          <label class="custom-file-label" for="customFile">Pilih file perubahan | PDF Maks. 5 Mb</label>
                        </div>
                 </div>
                        <div class="modal-footer d-flex justify-content-between">
                      <button type="submit" class="btn mb-2 btn-primary">Simpan</button>
                    </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

<?php echo $this->include('bot/bot_partial/dashboard/footer'); ?>