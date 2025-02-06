<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php echo $this->include('master_partial/dashboard/side_menu'); ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Chatbot Log Notification</h2>
                    </div>
                    <?php if(has_permission('admin')) : ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a
                                    href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                            </li>
                            <li class="breadcrumb-item active"><small>Notifikasi Log</small></li>
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
                                            <th>Penerima</th>
                                            <th>Jadwal Notifikasi</th>
                                            <th>Status Pengiriman</th>
                                            <th>Status Notifikasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;?>
                                        <?php foreach ($log as $log): ?>
                                        <tr>
                                        <td><?=$no++?></td>
                                        <td><?=$log->nama_penerima?></td>
                                        <td>
                                        <?php
                                                    if ($log->schedule_time) {
                                                        $timestamp = intval($log->schedule_time);
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
                                        ?>
                                        </td>
                                        <td>
                                        <?php
                                                    if ($log->pass_time != '-') {
                                                        $timestamp = intval($log->pass_time);
                                                        $dateTime = DateTime::createFromFormat('U.u', number_format($timestamp / 1000, 6, '.', ''));
                                                        if ($dateTime) {
                                                            // Mengubah ke zona waktu lokal
                                                            $dateTime->setTimezone(new DateTimeZone(date_default_timezone_get()));
                                                            $formattedDateTime = $dateTime->format('l, d-m-Y H:i:s');
                                                            echo $formattedDateTime;
                                                        } else {
                                                            echo "-";
                                                        }
                                                    } else {
                                                        echo "-";
                                                    }
                                        ?>
                                        </td>
                                        <td>
                                        <?php if ($log->status_notification == false) : ?>
                                        </strong><span class="badge badge-pill badge-danger text-white">Canceled</span>
                                        <?php elseif ($log->status_notification == true) : ?>
                                        </strong><span class="badge badge-pill badge-success text-white">Berhasil</span>
                                        <?php endif; ?>
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