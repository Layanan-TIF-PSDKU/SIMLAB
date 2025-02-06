<?=$this->include('simlab/simlab_partial/dashboard/header')?>
<?=$this->include('simlab/simlab_partial/dashboard/top_menu')?>
<?=$this->include('simlab/simlab_partial/dashboard/side_menu')?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Halaman <?=$title?></h2>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">Form Edit Data Ruang Laboratorium</strong>
                            </div>
                            <div class="card-body">
                                <!-- table -->
                                <form method="POST"
                                    action="<?=base_url("simlab/ruang-laboratorium/update/" . $ruanglab->id_ruang)?>">
                                    <div class="form-group mb-3">
                                        <label for="nama_ruang">Nama Ruang Laboratorium</label>
                                        <input type="text" id="nama_ruang" name="nama_ruang"
                                            class="form-control <?=($validation->hasError('nama_ruang')) ? 'is-invalid' : ''?>"
                                            value="<?=$ruanglab->nama_ruang?>"
                                            placeholder="Masukkan Nama Ruang Laboratorium" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('nama_ruang');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="gedung">Gedung</label>
                                        <select
                                            class="form-control select2 <?=($validation->hasError('gedung')) ? 'is-invalid' : ''?>"
                                            name="gedung" id="gedung">
                                            <option value="">Pilih Gedung</option>
                                            <option value="Gedung 1"
                                                <?=$ruanglab->gedung == 'Gedung 1' ? 'selected' : ''?>>Gedung 1</option>
                                            <option value="Gedung 2"
                                                <?=$ruanglab->gedung == 'Gedung 2' ? 'selected' : ''?>>Gedung 2</option>
                                        </select>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('gedung');?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="lantai">Lantai</label>
                                        <select
                                            class="form-control select2 <?=($validation->hasError('lantai')) ? 'is-invalid' : ''?>"
                                            name="lantai" id="lantai">
                                            <option value="">Pilih Lantai</option>
                                            <option value="Lantai 1"
                                                <?=$ruanglab->lantai == 'Lantai 1' ? 'selected' : ''?>>Lantai 1</option>
                                            <option value="Lantai 2"
                                                <?=$ruanglab->lantai == 'Lantai 2' ? 'selected' : ''?>>Lantai 2</option>
                                            <option value="Lantai 3"
                                                <?=$ruanglab->lantai == 'Lantai 3' ? 'selected' : ''?>>Lantai 3</option>
                                        </select>
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('lantai');?>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit">
                                        Edit
                                    </button>
                                    <a href="<?=base_url('simlab/ruang-laboratorium');?>"
                                        class="btn btn-warning">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div> <!-- simple table -->
                </div> <!-- end section -->
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</main>

<?=$this->include('simlab/simlab_partial/dashboard/footer')?>