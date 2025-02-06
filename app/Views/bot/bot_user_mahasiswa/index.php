<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php echo $this->include('master_partial/dashboard/side_menu'); ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Chatbot User Mahasiswa</h2>
                    </div>
                    <?php if(has_permission('admin')) : ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a
                                    href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                            </li>
                            <li class="breadcrumb-item active"><small>User Mahasiswa</small></li>
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
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Telegram</th>
                                            <th>Whatsapp</th>
                                            <th>Notifikasi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;?>
                                        <?php foreach ($mahasiswa as $mhs): ?>
                                        <tr>
                                        <td><?=$no++?></td>
                                        <td><?=$mhs->nama?></td>
                                        <td><?=$mhs->email?></td>
                                        <td><?=$mhs->username_telegram?></td>
                                        <td><?=$mhs->no_wa?></td>
                                        <td>
                                        <?php if ($mhs->status_notification == false) : ?>
                                        </strong><span class="badge badge-pill badge-danger text-white">Mute</span>
                                        <?php elseif ($mhs->status_notification == true) : ?>
                                        </strong><span class="badge badge-pill badge-success text-white">Aktif</span>
                                        <?php endif; ?>
                                        </td>
                                            <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                    <!-- <a class="dropdown-item" data-toggle="modal" data-target="#PesanModal";?><i class="fe fe-eye fe-16"></i> Lihat</a> -->
                                                    <a class="dropdown-item" href="<?=base_url("bot/kelola_bot/user/mahasiswa/edit/$mhs->id_user_bot");?>"><i class="fe fe-edit fe-16"></i> Edit</a>
                                                    <form method="POST" action="<?=base_url("bot/kelola_bot/user/mahasiswa/hapus-mahasiswa/$mhs->id_user_bot");?>">
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            <button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title='Delete'><i class="fe fe-delete fe-16"></i> Delete</button>
                                                            <!-- <a class="btn dropdown-item" style="color:black" onclick="deletedatanilai()">Hapus</a> -->
                                                    </form>
                                                    </div>
                                            </td>
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