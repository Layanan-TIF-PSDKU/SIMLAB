<?php echo $this->include('master_partial/dashboard/header');?>
<?php echo $this->include('master_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')) : ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
<?php echo $this->include('sipema/sipema_partial/dashboard/side_menu') ?>
<?php endif; ?>
<main role="main" class="main-content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
              <h2 class="h3 mb-4 page-title">Profile</h2>
              <div class="my-4">
                <form method="POST" action="<?= base_url('profil/update-profil/' . user()->id); ?>">
                  <hr class="my-4">
                  <!-- <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="nama">Nama</label>
                      <input type="text" id="nama" class="form-control" placeholder="Brown" value="">
                    </div>
                  </div> -->
                  <div class="form-group">
                    <label for="inputEmail4">Email</label>
                    <input type="email" class="form-control" id="inputEmail4" name="email" value="<?= user()->email; ?>">
                      <div class="invalid-feedback">
                            <?= $validation->getError('email'); ?>
                      </div>
                  </div>
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" class="form-control" name="username" value="<?= user()->username; ?>">
                      <div class="invalid-feedback">
                            <?= $validation->getError('username'); ?>
                      </div>
                  </div>
                  <hr class="my-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <input type="hidden" name="id" value="<?= user()->id; ?>">
                            <input type="hidden" name="password" value="<?= user()->password_hash; ?>">
                            <div class="form-group">
                                <label for="inputPassword4">Old Password</label>
                                <input type="password" name="old_password"
                                    class="form-control <?= ($validation->hasError('old_password')) ? 'is-invalid' : ''; ?>"
                                    id="inputPassword5">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('old_password'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword5">New Password</label>
                                <input type="password" name="new_password"
                                    class="form-control <?= ($validation->hasError('new_password')) ? 'is-invalid' : ''; ?>"
                                    id="inputPassword5">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('new_password'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword6">Confirm Password</label>
                                <input type="password" name="confirm_new_password"
                                    class="form-control <?= ($validation->hasError('confirm_new_password')) ? 'is-invalid' : ''; ?>"
                                    id="inputPassword6">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('confirm_new_password'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">Password requirements</p>
                            <p class="small text-muted mb-2"> To create a new password, you have to meet all of the
                                following requirements: </p>
                            <ul class="small text-muted pl-4 mb-0">
                                <li> Minimum 8 character </li>
                                <li>At least one special character</li>
                                <li>At least one number</li>
                                <li>Can’t be the same as a previous password </li>
                            </ul>
                        </div>
                    </div>
                  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                  <?php if(in_groups('admin')) : ?>
                  <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-warning">Kembali</a>
                  <?php else: ?>
                  <a href="<?= base_url('sipema'); ?>" class="btn btn-warning">Kembali</a>
                  <?php endif; ?>
                </form>
              </div> <!-- /.card-body -->
            </div> <!-- /.col-12 -->
          </div> <!-- .row -->
        </div> <!-- .container-fluid -->
    </div>
</main> <!-- main -->
<?php echo $this->include('master_partial/dashboard/footer');?>