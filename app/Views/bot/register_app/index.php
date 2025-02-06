<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php echo $this->include('master_partial/dashboard/side_menu'); ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Daftar Akses API Chatbot</h2>
                    </div>
                    <?php if(has_permission('admin')) : ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a
                                    href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                            </li>
                            <li class="breadcrumb-item active"><small>App Auth</small></li>
                        </ol>
                    </div>
                    <?php endif;?>
                </div>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <?php if (has_permission('pimpinan')): ?>
                                <?php else: ?>
                                <a href="<?=base_url('bot/register_app/tambah');?>"
                                    class="btn btn-primary mb-3">Tambah</a>
                                    <a href="https://documenter.getpostman.com/view/20809206/2s93kxakd5" target= blank_
                                    class="btn btn-outline-secondary mb-3">Dokumentasi API</a>
                                <?php endif;?>
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>ID Register</th>
                                            <th>Detail App</th>
                                            <?php if (has_permission('pimpinan')): ?>
                                            <?php else: ?>
                                            <th>Action</th>
                                            <?php endif;?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;?>
                                        <?php foreach ($app_list as $app_list): ?>
                                        <tr>
                                        <td><?=$no++?></td>
                                        <td><?=$app_list->registered_id?></td>
                                        <td><?=$app_list->app_detail?></td>
                                            <?php if (has_permission('pimpinan')): ?>
                                            <?php else: ?>
                                            <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                        
                                                    <form method="POST" action="<?=base_url("bot/register_app/hapus/$app_list->id");?>">
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            <button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title='Delete'><i class="fe fe-delete fe-16"></i> Delete</button>
                                                            <!-- <a class="btn dropdown-item" style="color:black" onclick="deletedatanilai()">Hapus</a> -->
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
                    </div>
                    <!-- simple table -->
                </div>
                <!-- end section -->
            </div>
            <!-- .col-12 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container-fluid -->
</main>
<?php echo $this->include('bot/bot_partial/dashboard/footer'); ?>