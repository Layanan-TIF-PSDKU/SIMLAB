<?= $this->include('simlab/simlab_partial/dashboard/header')?>
<?= $this->include('simlab/simlab_partial/dashboard/top_menu')?>
<?= $this->include('simlab/simlab_partial/dashboard/side_menu')?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- Small table -->

              <!-- Breadcrumbs -->
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Halaman <?=$title?></h2>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a href="<?=base_url('simlab')?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Kategori</li>
                        </ol>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-body">
                        <!-- table -->
                        <a href="<?= ('kategori/tambah'); ?>" class="btn btn-primary btn-icon-split mb-3 mt-1">
                            <span class="fe fe-plus-circle"></span>&nbsp; Tambah</a>
                        <table class="table datatables" id="dataTable-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($kategori as $ktg): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $ktg->nama_kategori ?></td>
                                    <td>
                                        <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item"
                                                href="<?= base_url("simlab/kategori/edit/$ktg->id_kategori"); ?>"><i
                                                    class="fe fe-edit fe-16"></i>&nbsp;Edit</a>
                                            <form method="POST"
                                                action="<?= base_url("simlab/kategori/hapus/$ktg->id_kategori"); ?>">
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="dropdown-item remove-item-btn"
                                                    data-toggle="tooltip" title='Delete'><i
                                                        class="fe fe-trash-2 fe-16"></i>&nbsp;Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- simple table -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</main>

<?= $this->include('simlab/simlab_partial/dashboard/footer')?>