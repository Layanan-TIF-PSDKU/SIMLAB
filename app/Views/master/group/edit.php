<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('master_partial/dashboard/top_menu'); ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Edit Data Group</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <!-- <div class="card-header">
                                <strong class="card-title">Tambah Data Mitra</strong>
                            </div> -->
                            <div class="card-body">
                            <form action="<?= base_url('group/update/' . $group->id) ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" value="<?= $group->name ?>">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" name="description" class="form-control" value="<?= $group->description ?>">
                            </div>
                            <button class="btn btn-primary" type="submit">Simpan</button>
                            <a href="<?= base_url('group'); ?>" class="btn btn-warning">Kembali</a>
                        </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- end section -->
            </div>
            <!-- /.col-12 col-lg-10 col-xl-10 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container-fluid -->
</main>

<?= $this->include('master_partial/dashboard/footer'); ?>

<script>

    function toggle(source) {
        checkboxes = document.getElementsByName('permission[]');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
        }
    }

</script>