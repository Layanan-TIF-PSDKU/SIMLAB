<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('master_partial/dashboard/top_menu'); ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
        --warna: <?php echo $cms->warna_bg ?>;
        }
    </style>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Hasil Jadwal Kuesioner</h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-10">
                            <div class="card-body">                      
                                <?php foreach ($jawabanData as $pertanyaan => $pilihan) : ?>
                                    <strong><?= $pertanyaan; ?></strong>
                                    <div class="col-md-4">
                                        <canvas id="<?= str_replace(' ', '_', $pertanyaan); ?>_chart"></canvas>
                                    </div>
                                    <hr>
                                    <script>
                                        // Mengambil data jawaban dan totalnya dari PHP
                                        var jawabanData = <?= json_encode($pilihan); ?>;

                                        // Mengubah data menjadi format yang diterima oleh Chart.js
                                        var labels = Object.keys(jawabanData);
                                        var data = Object.values(jawabanData);
                                        var backgroundColors = ['#FF6384', '#36A2EB', '#FFCE56']; // Warna untuk setiap bagian pie chart

                                        // Membuat pie chart menggunakan Chart.js
                                        var ctx = document.getElementById('<?= str_replace(' ', '_', $pertanyaan); ?>_chart').getContext('2d');
                                        var chart = new Chart(ctx, {
                                            type: 'pie',
                                            data: {
                                                labels: labels,
                                                datasets: [{
                                                    data: data,
                                                    backgroundColor: backgroundColors,
                                                }]
                                            },
                                            options: {
                                                responsive: true,
                                                maintainAspectRatio: false,
                                            }
                                        });
                                    </script>
                                <?php endforeach; ?>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- end section -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-10">
                            <div class="card-body">
                                <?php foreach ($jawabanDataIsian as $pertanyaan_isian => $isian) : ?>
                                    <strong><?= $pertanyaan_isian; ?></strong>
                                    <ul>
                                        <?php foreach ($isian as $key => $count) : ?>
                                            <li><?= $key; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endforeach; ?>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <!-- /.col-12 col-lg-10 col-xl-10 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container-fluid -->
</main>
<?php echo $this->include('sipema/sipema_partial/dashboard/footer');?>