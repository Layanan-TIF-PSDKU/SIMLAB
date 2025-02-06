<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php echo $this->include('master_partial/dashboard/side_menu'); ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Kegiatan Prodi</h2>
                    </div>
                    <?php if(has_permission('admin')) : ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a
                                    href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                            </li>
                            <li class="breadcrumb-item active"><small>Agenda Prodi</small></li>
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
                                <a href="<?=base_url('timelinereminder/agenda/tambah');?>"
                                    class="btn btn-primary mb-3">Tambah Kegiatan</a>
                                <?php endif;?>
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kegiatan</th>
                                            <th>PIC</th>
                                            <th>Waktu Kegiatan</th>
                                            <?php if (has_permission('pimpinan')): ?>
                                            <?php else: ?>
                                            <th>Action</th>
                                            <?php endif;?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;?>
                                        <?php foreach ($kegiatan as $keg): ?>
                                        <tr>
                                        <td><?=$no++?></td>
                                        <td><?=$keg->nama_kegiatan?></td>
                                        <td><?=$keg->penanggung_jawab_nama?></td>
                                        <td><?php
                                                    if ($keg->waktu_kegiatan) {
                                                        $timestamp = intval($keg->waktu_kegiatan);
                                                        $dateTime = DateTime::createFromFormat('U.u', number_format($timestamp / 1000, 6, '.', ''));
                                                        if ($dateTime) {
                                                            // Mengubah ke zona waktu lokal
                                                            $dateTime->setTimezone(new DateTimeZone(date_default_timezone_get()));
                                                            $formattedDateTime = $dateTime->format('l, d-m-Y H:i:s');
                                                            echo $formattedDateTime;
                                                        } else {
                                                            echo "Invalid DateTime";
                                                        }
                                                    } else {
                                                        echo "No Data";
                                                    }
                                        ?></td>
                                            <?php if (has_permission('pimpinan')): ?>
                                            <?php else: ?>
                                            <td>
                                            <a class="btn btn-outline-primary mb-3" href="<?=base_url('timelinereminder/agenda/detail/' . $keg->id_kegiatan);?>"
                                           >Detail</a>
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
</main>

<?php echo $this->include('bot/bot_partial/dashboard/footer'); ?>