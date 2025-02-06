<?php echo $this->include('simta/simta_partial/dashboard/header');?>
<?php echo $this->include('simta/simta_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')) : ?>
    <?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
    <?php echo $this->include('simta/simta_partial/dashboard/side_menu') ?>
<?php endif; ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="mt-2 page-title">Halaman Tambah Dosen Penguji Ujian Proposal Tugas Akhir</h2>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</li>
                                <li class="breadcrumb-item active">Tambah Dosen Penguji Ujian Proposal</li>
                            </ol>
                        </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</li>
                                <li class="breadcrumb-item active">Tambah Dosen Penguji Ujian Proposal</li>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row my-4">
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title"></strong>
                            </div>
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data" action="<?= base_url('simta/ujianproposal/storepengujiujianproposal/' . $ujianproposal->id_ujianproposal); ?>" id="ujianproposal-form">
                                    <?= csrf_field(); ?>
                                    <div class="form-group" id="id_ujianproposal-container">
                                        <label for="id_ujianproposal">Ujian Proposal<span class="text-danger">*</span></label>
                                        <div class="id_ujianproposal-row">
                                            <input type="text" id="id_ujianproposal" name="id_ujianproposal[]" class="form-control" placeholder="Masukkan Ujian Proposal" value="<?= $ujianproposal->id_ujianproposal ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group" id="id_staf-container">
                                        <label for="id_staf">Nama Dosen</label>
                                        <div class="staf-row">
                                        <select name="id_staf[]" id="id_staf"
                                            class="form-control select2 <?= ($validation->hasError('id_staf')) ? 'is-invalid' : ''; ?>">
                                            <option>Pilih Dosen Pembimbing</option>
                                            <?php foreach ($staf as $s) : ?>
                                            <option value="<?= $s->id_staf ?>"><?= $s->nama ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="penguji-container">
                                        <label for="nama_penguji">Nama Penguji</label>
                                        <div class="penguji-row">
                                            <select name="nama_penguji[]" class="form-control">
                                                <option value="">Pilih Nama Penguji</option>
                                                <option value="PENGUJI 1">PENGUJI 1</option>
                                                <option value="PENGUJI 2">PENGUJI 2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary" id="add-id_ujianproposal">Tambah ID </button>
                                    <button type="button" class="btn btn-primary" id="add-staf">Tambah Dosen Penguji</button>
                                    <button type="button" class="btn btn-primary" id="add-penguji">Tambah Penguji</button>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-12 col-lg-10 col-xl-10 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container-fluid -->
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
    $(document).ready(function () {
        $('#add-id_ujianproposal').click(function () {
            var id_ujianproposalRow = '<div class="form-group" id="id_ujianproposal-container">' +
            '<input type="text" id="id_ujianproposal" name="id_ujianproposal[]" class="form-control" placeholder="Masukkan Ujian Proposal" value="<?= $ujianproposal->id_ujianproposal ?>" />' +
            '</div>';
            $('#id_ujianproposal-container').append(id_ujianproposalRow);
        });

        $('#add-staf').click(function () {
            var stafRow = '<div class="staf-row">' +
                '<select name="id_staf[]" id="id_staf" class="form-control select2"> <?= ($validation->hasError('id_staf')) ? 'is-invalid' : ''; ?>">';
                '<option>Pilih Dosen Pembimbing</option>';
            <?php foreach ($staf as $s) : ?>
                stafRow += '<option value="<?= $s->id_staf ?>"><?= $s->nama ?></option>';
            <?php endforeach; ?>
            stafRow += '</select>' +
                '</div>';
            $('#id_staf-container').append(stafRow);
        });

        $('#add-penguji').click(function () {
            var pengujiRow = '<div class="penguji-row">' +
                '<select name="nama_penguji[]" class="form-control">' +
                '<option value="">Pilih Nama Penguji</option>' +
                '<option value="PENGUJI 1">PENGUJI 1</option>' +
                '<option value="PENGUJI 2">PENGUJI 2</option>' +
                '</select>' +
                '</div>';
            $('#penguji-container').append(pengujiRow);
        });
    });
</script>

<?php echo $this->include('simta/simta_partial/dashboard/footer'); ?>
