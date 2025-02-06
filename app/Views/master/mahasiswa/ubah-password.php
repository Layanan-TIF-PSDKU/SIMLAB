<?= $this->include('master_partial/dashboard/header');?>
<?= $this->include('master_partial/dashboard/top_menu');?>
<?= $this->include('master_partial/dashboard/side_menu');?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <h2 class="h3 mb-4 page-title">Ubah Password</h2>
                <form method="POST" action="<?= base_url('mahasiswa/update-password/' . $mahasiswa->id_mhs); ?>">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <input type="hidden" name="id_user" value="<?= $mahasiswa->id_user ?>">
                            <input type="hidden" name="password" value="<?= $mahasiswa->password_hash ?>">
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
                    <a href="<?=base_url('staf');?>" class="btn btn-warning">Kembali</a>
                </form>
            </div> <!-- /.card-body -->
        </div> <!-- /.col-12 -->
    </div>
</main> <!-- main -->
<?php echo $this->include('master_partial/dashboard/footer');?>