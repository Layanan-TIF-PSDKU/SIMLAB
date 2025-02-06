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
                                <strong class="card-title">Form Edit Data Kategori</strong>
                            </div>
                            <div class="card-body">
                                <!-- table -->
                                <form method="POST"
                                    action="<?=base_url("simlab/kategori/update/" . $kategori->id_kategori)?>">
                                    <div class="form-group mb-3">
                                        <label for="nama_kategori">Nama Kategori</label>
                                        <input type="text" id="nama_kategori" name="nama_kategori"
                                            class="form-control <?=($validation->hasError('nama_kategori')) ? 'is-invalid' : ''?>"
                                            value="<?=$kategori->nama_kategori?>"
                                            placeholder="Masukkan Nama Kategori" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('nama_kategori');?>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">
                                        Edit
                                    </button>
                                    <a href="<?=base_url('simlab/kategori');?>" class="btn btn-warning">Kembali</a>
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