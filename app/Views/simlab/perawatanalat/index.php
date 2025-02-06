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
                            <li class="breadcrumb-item active">Perawatan Alat Laboratorium</li>
                        </ol>
                    </div>
                </div>

                <!-- Small table -->
                <div class="card shadow">
                    <div class="card-body">
                        <!-- table -->
                        <a href="<?=('perawatan-alat/tambah');?>" class="btn btn-primary btn-icon-split mb-3 mt-1">
                            <span class="fe fe-plus-circle"></span>&nbsp; Tambah</a>
                        <table class="table datatables" role="grid" id="dataTable-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Alat</th>
                                    <th>Nomor Inventaris</th>
                                    <th>Letak/Ruang</th>
                                    <th>Jenis Perawatan</th>
                                    <th>Level Perawatan</th>
                                    <th>Tanggal Perawatan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;?>
                                <?php foreach ($perawatanalat as $perawatanalat): ?>
                                <tr>
                                    <td><?=$no++?></td>
                                    <td><?=$perawatanalat->nama_alat?></td>
                                    <td><?php if ($perawatanalat->nama_kategori == 'Peralatan'): ?>
                                        <?=$perawatanalat->no_inventaris?>
                                        <?php elseif ($perawatanalat->nama_kategori == 'Barang Habis Pakai'): ?>
                                        -
                                        <?php endif;?></td>
                                    <td><?=$perawatanalat->nama_ruang?></td>
                                    <td><?=$perawatanalat->jenis?></td>
                                    <td><?=$perawatanalat->level?></td>
                                    <td><?=$perawatanalat->tanggal?></td>
                                    <td>
                                        <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item"
                                                href="<?=base_url("simlab/perawatan-alat/edit/$perawatanalat->id_perawatan_alat");?>">
                                                <i class="fe fe-edit fe-16"></i>&nbsp;Edit</a>
                                            <form method="POST"
                                                action="<?=base_url("simlab/perawatan-alat/hapus/$perawatanalat->id_perawatan_alat");?>">
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="dropdown-item remove-item-btn"
                                                    data-toggle="tooltip" title='Delete'><i
                                                        class="fe fe-trash-2 fe-16"></i>&nbsp;
                                                    Delete</button>
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