<?=$this->include('simlab/simlab_partial/dashboard/header')?>
<?=$this->include('simlab/simlab_partial/dashboard/top_menu')?>
<?=$this->include('simlab/simlab_partial/dashboard/side_menu')?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">

                <!-- Breadcrumbs -->
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Halaman <?=$title?></h2>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a href="<?=base_url('simlab')?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Ruang Laboratorium</li>
                        </ol>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-body">
                        <!-- table -->
                        <a href="<?=('ruang-laboratorium/tambah');?>" class="btn btn-primary btn-icon-split mb-3 mt-1">
                            <span class="fe fe-plus-circle"></span>&nbsp; Tambah</a>
                        <table class="table datatables" role="grid" id="dataTable-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Ruang</th>
                                    <th>Gedung</th>
                                    <th>Lantai</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;?>
                                <?php foreach ($ruanglab as $ruanglab): ?>
                                <tr>
                                    <td><?=$no++?></td>
                                    <td><?=$ruanglab->nama_ruang?></td>
                                    <td><?=$ruanglab->gedung?></td>
                                    <td><?=$ruanglab->lantai?></td>
                                    <td>
                                        <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item"
                                                href="<?=base_url("simlab/ruang-laboratorium/edit/$ruanglab->id_ruang");?>"><i
                                                    class="fe fe-edit fe-16"></i>&nbsp;Edit</a>
                                            <form method="POST"
                                                action="<?=base_url("simlab/ruang-laboratorium/hapus/$ruanglab->id_ruang");?>">
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="dropdown-item remove-item-btn"
                                                    data-toggle="tooltip" title='Delete'><i
                                                        class="fe fe-trash-2 fe-16"></i>&nbsp;Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</main>

<?=$this->include('simlab/simlab_partial/dashboard/footer')?>