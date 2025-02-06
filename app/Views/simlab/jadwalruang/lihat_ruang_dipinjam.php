<?= $this->include('simlab/simlab_partial/dashboard/header')?>
<?= $this->include('simlab/simlab_partial/dashboard/top_menu')?>
<?= $this->include('simlab/simlab_partial/dashboard/side_menu')?>

<main role="main" class="main-content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <h2 class="mb-2 page-title">Halaman <?=$title?></h2>
              <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                  <div class="card shadow">
                    <div class="card-body">
                      <!-- table -->
                      <table class="table datatables" role="grid" id="dataTable-1">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Peminjam</th>
                                <th>NIP/NIM</th>
                                <th>Keperluan</th>
                                <th>Hari/Tanggal</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($ruangdipinjam as $rpjm): ?>
                          <?php if ($rpjm->status_peminjaman =='Sedang Digunakan') :?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?php if ($rpjm->nama_mahasiswa): ?>
                                  <?= $rpjm->nama_mahasiswa?>
                                  <?php elseif ($rpjm->nama_staff): ?>
                                    <?= $rpjm->nama_staff ?>
                                    <?php endif; ?>
                                </td>
                                <td><?php if ($rpjm->nama_mahasiswa): ?>
                                  <?= $rpjm->nim?>
                                  <?php elseif ($rpjm->nama_staff): ?>
                                    <?= $rpjm->nip ?> 
                                    <?php endif; ?>
                                </td>
                                <td><?=$rpjm->keperluan ?></td>
                                <td><?=$rpjm->hari?> / <?=$rpjm->tanggal_pinjam?> </td>
                                <td><?=$rpjm->waktu_mulai?> - <?=$rpjm->waktu_selesai?> WIB</td>
                            </tr>
                            <?php endif;?>
                        <?php endforeach ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div> <!-- simple table -->
              </div> <!-- end section -->
            </div> <!-- .col-12 -->
          </div> <!-- .row -->
        </div> <!-- .container-fluid -->
      </main>

<?= $this->include('simlab/simlab_partial/dashboard/footer')?>