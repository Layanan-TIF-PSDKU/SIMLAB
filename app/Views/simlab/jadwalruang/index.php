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
                            <li class="breadcrumb-item active">Penggunaan Ruang Laboratorium</li>
                        </ol>
                    </div>
                </div>

                <!-- Small table -->
                <div class="card shadow">
                    <div class="card-body">
                        <!-- table -->
                        <?php if (has_permission('laboran')): ?>
                        <a href="<?=base_url('simlab/penggunaan-ruang-laboratorium/tambah/' . $ruanglab->id_ruang);?>"
                            class="btn btn-primary btn-icon-split mb-3 mt-1">
                            <span class="fe fe-plus-circle"></span>&nbsp;Tambah</a>
                        <?php endif;?>
                        <table class="table datatables" role="grid" id="dataTable-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Waktu </th>
                                    <th>Mata Kuliah</th>
                                    <th>Kelas</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Semester</th>
                                    <?php if(has_permission('laboran')):?>
                                    <th>Action</th>
                                    <?php endif;?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;?>
                                <?php foreach ($jadwal as $jdw): ?>
                                <tr>
                                    <td><?=$no++?></td>
                                    <td><?=$jdw->hari?></td>
                                    <td><?=$jdw->waktu_mulai?> - <?=$jdw->waktu_selesai?> WIB</td>
                                    <td><?=$jdw->nama_mata_kuliah?></td>
                                    <td><?=$jdw->kelas?></td>
                                    <td><?=$jdw->tahun_ajaran?></td>
                                    <td><?=$jdw->semester?></td>
                                    <?php if(has_permission('laboran')):?>
                                    <td>
                                        <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item"
                                                href="<?=base_url("simlab/penggunaan-ruang-laboratorium/edit/$jdw->id_ruang/$jdw->id_jadwal");?>">
                                                <i class="fe fe-edit fe-16"></i>&nbsp;Edit</a>

                                            <form method="POST"
                                                action="<?=base_url("simlab/penggunaan-ruang-laboratorium/hapus/$jdw->id_ruang");?>">
                                                <input name="id_jadwal" type="hidden" value="<?=$jdw->id_jadwal?>">
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="dropdown-item remove-item-btn"
                                                    data-toggle="tooltip" title='Delete'><i
                                                        class="fe fe-trash-2 fe-16"></i>&nbsp;Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                    <?php endif;?>
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