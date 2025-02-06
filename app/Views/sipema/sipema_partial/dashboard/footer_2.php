<div id="loadingOverlay" class="loading-overlay">
    <div class="loading-box">
        <div class="loading-spinner"></div>
        <p>Harap tunggu...</p>
</div>
</div>
</div>
</div>
<script src="<?= base_url('../assets/js/jquery.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/popper.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/moment.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/simplebar.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/daterangepicker.js') ?>"></script>
<script src="<?= base_url('../assets/js/jquery.stickOnScroll.js') ?>"></script>
<script src="<?= base_url('../assets/js/tinycolor-min.js') ?>"></script>
<script src="<?= base_url('../assets/js/config.js') ?>"></script>
<script src="<?= base_url('../assets/js/d3.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/topojson.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/datamaps.all.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/datamaps-zoomto.js') ?>"></script>
<script src="<?= base_url('../assets/js/datamaps.custom.js') ?>"></script>
<script src="<?= base_url('../assets/js/Chart.min.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.js"></script>
<script>
$(function() {

    <?php if(session()->has("success")) { ?>
    Swal.fire({
        icon: 'success',
        title: 'Great!',
        text: '<?= session("success") ?>'
    })
    <?php } ?>
});
</script>
<script>
$(function() {

    <?php if(session()->has("error")) { ?>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '<?= session("error") ?>'
    })
    <?php } ?>
});
</script>
<script>
$(function() {

    <?php if(session()->has("warning")) { ?>
    Swal.fire({
        icon: 'warning',
        title: 'Great!',
        text: '<?= session("warning") ?>'
    })
    <?php } ?>
});
</script>
<script>
$(function() {

    <?php if(session()->has("info")) { ?>
    Swal.fire({
        icon: 'info',
        title: 'Hi!',
        text: '<?= session("info") ?>'
    })
    <?php } ?>
});
</script>
<script>
$(function() {
    <?php if(session()->has("status_icon") && session()->has("status_text")) { ?>
    Swal.fire({
        icon: '<?= session("status_icon") ?>',
        title: '<?= session("status_icon") === "success" ? "Great!" : (session("status_icon") === "error" ? "Oops..." : (session("status_icon") === "warning" ? "Attention" : "Hi!")) ?>',
        text: '<?= session("status_text") ?>'
    });
    <?php } ?>
});
</script>
<script>
$(document).ready(function() {
    $(document).on('click', '.remove-item-btn', function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        
        Swal.fire({
            title: 'Anda yakin ingin menghapus ?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
                document.getElementById('loadingOverlay').classList.add('active'); 
            } else {
                document.getElementById('loadingOverlay').classList.remove('active');
            }
        });
    });
});
</script>
<script>
  var myChart;
  var id_bidang = $('#id_bidang').val();
  var detailTable;

  $(document).ready(function() {
    if (typeof populateBidang === 'function') {
        populateBidang();
    }
    
    $('#resetPemetaan').click(function() {
        $('#id_bidang').val('');
        $('#filter').val("");
        $('#id_sub_bidang').prop('disabled', true);
        $('#id_sub_bidang').empty();
        $('#id_sub_bidang').append('<option value="">Pilih Sub Bidang</option>');
        $('#sks_filter').prop('disabled', true);
        $('#sks_filter').empty();
        $('#sks_filter').append('<option value="">Pilih Range Sks</option>');
        $('#nilai_akhir_filter').prop('disabled', true);
        $('#nilai_akhir_filter').empty();
        $('#nilai_akhir_filter').append('<option value="">Pilih Range Nilai Akhir</option>');

        if (typeof populateBidang === 'function') {
            populateBidang();
        }

        if (detailTable) {
            detailTable.destroy();
        }
        $('#isitabeldarihasilpemilihansubbidang').html('<tr><td colspan=5><center>Data Kosong</center></td></tr>');
        $('#nilaiTertinggi').text('-');
        $('#namaMahasiswa').text('-');
        $('#namaBidang').text('-');
        $('#namaSubBidang').text('-');

        if (myChart) {
            myChart.destroy();
        }
        var ctx = document.getElementById('chartHanif2').getContext('2d');
        ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
    });
  });
  $(document).on('click', '#prosesPemetaan, #filter, #id_bidang', function() {
      var id_bidang = $('#id_bidang').val();
      var id_sub_bidang = $('#id_sub_bidang').val();
      var nilai_akhir_filter = $('#nilai_akhir_filter').val();
      var sks_filter = $('#sks_filter').val();
      var filter = $('#filter').val();
      
      if (id_bidang == '') {
        Swal.fire({
            icon: "warning",
            text: "Nama Bidang harus dipilih!"
        })
        return false;
      }
      
        if(id_bidang != '' && id_sub_bidang == '' && nilai_akhir_filter == '' && sks_filter == ''){
            var url = "<?php echo base_url('sipema/hasil_pemetaan_keterampilan/getDataSubBidang'); ?>" + "/" + id_bidang;
        } else if (id_sub_bidang != '' && nilai_akhir_filter != '' && sks_filter != '') {           
            var url = "<?php echo base_url('sipema/hasil_pemetaan_keterampilan/getDataSubBidang'); ?>" + "/" + id_bidang + "/" + id_sub_bidang + "/" + nilai_akhir_filter + "/" + sks_filter;
        } else if(id_sub_bidang == '' && nilai_akhir_filter != '' && sks_filter != '') {
            var url = "<?php echo base_url('sipema/hasil_pemetaan_keterampilan/getDataBidangNilaiAkhirSks'); ?>" + "/" + id_bidang +  "/" + nilai_akhir_filter + "/" + sks_filter;
        } else if (id_sub_bidang != '' && nilai_akhir_filter == '' && sks_filter == '') {
            var url = "<?php echo base_url('sipema/hasil_pemetaan_keterampilan/getDataSubBidang'); ?>" + "/" + id_bidang +  "/" + id_sub_bidang;
        } else if (id_sub_bidang == '' && nilai_akhir_filter != '' && sks_filter == '') {
            var url = "<?php echo base_url('sipema/hasil_pemetaan_keterampilan/getDataBidangNilaiAkhir'); ?>" + "/" + id_bidang +  "/" + nilai_akhir_filter;
        } else if (id_sub_bidang == '' && nilai_akhir_filter == '' && sks_filter != '') {
            var url = "<?php echo base_url('sipema/hasil_pemetaan_keterampilan/getDataBidangSks'); ?>" + "/" + id_bidang +  "/" + sks_filter;
        } else if (id_sub_bidang != '' && nilai_akhir_filter != '' && sks_filter == '') {
            var url = "<?php echo base_url('sipema/hasil_pemetaan_keterampilan/getDataSubBidang'); ?>" + "/" + id_bidang + "/" + id_sub_bidang + "/" + nilai_akhir_filter;
        } else if (id_sub_bidang != '' && nilai_akhir_filter == '' && sks_filter != '') {
            var url = "<?php echo base_url('sipema/hasil_pemetaan_keterampilan/getDataBidangSubBidangSks'); ?>" + "/" + id_bidang + "/" + id_sub_bidang + "/" + sks_filter;
        }
    
      if (myChart) {
        myChart.destroy();
      }
    
      $.ajax({
         url : url,
          method: "GET",
          dataType: 'json',
          success: function(data) {
            if (data.length === 0) {
                var str = "<tr><td colspan='5'><center>Data tidak ditemukan</center></td></tr>";
                document.querySelector('#isitabeldarihasilpemilihansubbidang').innerHTML = str;
                document.querySelector('#nilaiTertinggi').textContent = '-';
                document.querySelector('#namaMahasiswa').textContent = '-';
                document.querySelector('#namaBidang').textContent = '-';
                document.querySelector('#namaSubBidang').textContent = '-';

                if (myChart) {
                    myChart.destroy();
                }
            } else {
                var str = "";
                var count = 1;
                var maxNilai = -Infinity; 
                var namaMahasiswa = '';
                var limit = parseInt(filter) || data.length;
                data = data.slice(0, limit);
                for (var i = 0; i < data.length; i++) {
                    str += "<tr>";
                    str += "<td>"+ count++ +"</td>";
                    str += '<td>'+ data[i].nama_mahasiswa +'</td>';
                    str += '<td>'+ data[i].total_sks +'</td>';
                    str += '<td>'+ data[i].nilai_akhir +'</td>';
                    str += '<td><button type="button" id="detailBtn'+data[i].id_mhs+'" data-id="'+data[i].id_mhs+'" class="btn btn-primary">Detail</button></td>';
                    str += "</tr>";
                    
                    if (data[i].nilai_akhir > maxNilai) {
                        maxNilai = data[i].nilai_akhir;
                        namaMahasiswa = data[i].nama_mahasiswa;
                        namaBidang = data[i].nama_bidang;
                        namaSubBidang = data[i].nama_sub_bidang;
                    }
                }

                document.querySelector('#isitabeldarihasilpemilihansubbidang').innerHTML = str;
                document.querySelector('#nilaiTertinggi').textContent = maxNilai;
                document.querySelector('#namaMahasiswa').textContent = namaMahasiswa;
                document.querySelector('#namaBidang').textContent = namaBidang;
                if(namaSubBidang == ''){
                    document.querySelector('#namaSubBidang').textContent = '-';
                }else{
                    document.querySelector('#namaSubBidang').textContent = namaSubBidang;
                }
                $('#dataTableHasilPemetaan').DataTable();
                
                var detailButtons = document.querySelectorAll('[id^="detailBtn"]');
                detailButtons.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        var id_mhs = this.dataset.id;
                        showDetail(id_mhs);
                    });
                });

                function showDetail(id_mhs) {
                    var id_bidang = $('#id_bidang').val();
                    var id_sub_bidang = $('#id_sub_bidang').val();
                    var url = "<?php echo base_url('mahasiswa/getDataMataKuliah'); ?>" + "/" + id_bidang + "/" + id_mhs;

                    if (id_sub_bidang != null || id_sub_bidang != '') {
                        url += "/" + id_sub_bidang;
                    } 
                    
                    $.ajax({
                        url: url,
                        method: "GET",
                        dataType: 'json',
                        success: function(data) {
                        if (detailTable) {
                            detailTable.destroy();
                        }
                        var str = "";
                        for (var i = 0; i < data.length; i++) {
                            str += "<tr>";
                            str += "<td>"+ data[i].nama_sub_bidang +"</td>";
                            str += "<td>"+ data[i].kode_mata_kuliah +"</td>";
                            str += "<td>"+ data[i].nama_mata_kuliah +"</td>";
                            str += "<td>"+ data[i].sks +"</td>";
                            str += "</tr>";
                        }
                        document.querySelector('#isitabeldarihasilmatakuliah').innerHTML = str;
                        $('#myModal').modal('show');
                        detailTable = $('#detailTable').DataTable();
                        },
                        error: function() {
                        Swal.fire({
                            icon: "error",
                            text: "Terjadi kesalahan saat mengambil data!"
                        });
                        }
                    });
                }

                var ctx = document.getElementById('chartHanif2').getContext('2d');
                    
                    if (window.myChart) {
                        window.myChart.destroy();
                    }

                    
                    var labels = [];
                    var nilai_akhir = [];
                    for (var i = 0; i < data.length; i++) {
                        var label = data[i].nama_bidang; 
                        if (data[i].nama_sub_bidang) {
                            label += ' - ' + data[i].nama_sub_bidang;
                        }
                        
                        label += ' - ' + data[i].nama_mahasiswa;
                        labels.push(label);
                        nilai_akhir.push(data[i].nilai_akhir);
                    }
                
                    function randomColor() {
                        var letters = '0123456789ABCDEF';
                        var color = '#';
                        for (var i = 0; i < 6; i++) {
                            color += letters[Math.floor(Math.random() * 16)];
                        }
                        return color;
                    }

                window.myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                        label: 'Nilai Akhir',
                        data: nilai_akhir,
                        backgroundColor: randomColor,
                        borderColor: randomColor,
                        borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    font: {
                                        color: 'black'
                                    }
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        color: 'black' 
                                    }
                                }
                            }
                        },
                        responsive: true,
                    }
                });
          }
        }
      });
  });
    $('#id_bidang').change(function() {
        var id_bidang = $(this).val();
        $.ajax({
            url: '<?php echo base_url('sipema/hasil_pemetaan_keterampilan/getSubBidangByBidang'); ?>' + "/" + id_bidang, 
            type: 'get',
            dataType: 'json',
            success: function(data) {
                   
                    $('#id_sub_bidang').prop('disabled', false);
                    var idSubBidangSebelumnya = $('#id_sub_bidang').val(); 
                    $('#id_sub_bidang').empty();
                    $('#id_sub_bidang').append('<option value="">Semua Sub Bidang</option>');
                    $('#sks_filter').prop('disabled', false);
                    $('#nilai_akhir_filter').prop('disabled', false);
                    $('#sks_filter').empty();
                    $('#nilai_akhir_filter').empty();
                    $('#nilai_akhir_filter').append('<option value="">Semua Range Nilai</option>\
                                  <option value="1">90 - 100</option>\
                                  <option value="2">85 - 89.9</option>\
                                  <option value="3">80 - 84.9</option>\
                                  <option value="4">75 - 79.9</option>\
                                  <option value="5">70 - 74.9</option>\
                                  <option value="6">65 - 69.9</option>\
                                  <option value="7">60 - 64.9</option>\
                                  <option value="8">55 - 59.9</option>\
                                  <option value="9">50 - 54.9</option>\
                                  <option value="10">0 - 49.9</option>');
                    $('#sks_filter').append('<option value="">Semua Range SKS</option>\
                                            <option value="1">Kurang dari 7 sks</option>\
                                            <option value="2">10 - 20 sks</option>\
                                            <option value="3">20 - 30 sks</option>\
                                            <option value="4">30 - 40 sks</option>\
                                            <option value="5">40 - 50 sks</option>\
                                            <option value="6">50 - 60 sks</option>\
                                            <option value="7">60 - 70 sks</option>\
                                            <option value="8">70 - 80 sks</option>\
                                            <option value="9">80 - 90 sks</option>\
                                            <option value="10">90 - 105 sks</option>\
                                            <option value="11">Sama dengan 106 sks</option>');
                    
                    $.each(data, function(key, value) {
                        $('#id_sub_bidang').append('<option value="' + value.id_sub_bidang + '">' + value.nama_sub_bidang + '</option>');
                    });
                    
                    if (idSubBidangSebelumnya != null && idSubBidangSebelumnya != '') {
                        $('#id_sub_bidang').val(idSubBidangSebelumnya);
                    }
                    id_sub_bidang_terpilih = $('#id_sub_bidang').val(); 
                },
                error: function(xhr, status, error) {
                    console.error(xhr.dataText);
                }
            });
            
            if ($('#id_bidang option:selected').length > 0 ) {
                $('#id_sub_bidang').empty();
                $('#id_sub_bidang').append('<option value="">Pilih Sub Bidang</option>');
            }
            if(id_bidang == null || id_bidang == '' ){
                $('#id_sub_bidang').prop('disabled', true);
                $('#id_sub_bidang').empty();
                $('#id_sub_bidang').append('<option value="">Pilih Nama Sub Bidang</option>');
                $('#sks_filter').prop('disabled', true);
                $('#sks_filter').empty();
                $('#sks_filter').append('<option value="">Pilih Range Sks</option>');
                $('#nilai_akhir_filter').prop('disabled', true);
                $('#nilai_akhir_filter').empty();
                $('#nilai_akhir_filter').append('<option value="">Pilih Range Nilai</option>');
            }
    });
</script>
<script>
    $(document).ready(function(){
    $('#simple-select-1').change(function(){
        var sub_bidang_id = $(this).val();
        $.ajax({
        url:"<?= base_url('sipema/rekomendasi/get_dosen_by_sub_bidang_id'); ?>"  + "/" + sub_bidang_id,
        method:"GET",
        dataType: 'json',
        success:function(data){
            if (data) {
                $('#nama_dosen').val(data.nama_dosen);
                $('#id_staf').val(data.id_staf);
            } else {
                $('#nama_dosen').val('Anda tidak berhak mengisi');
                $('#id_staf').val('');
            }
        }
        });
    });
    });
</script>
<script>
    $(document).ready(function() {
        $('#id_mhs').on('change', function() {
            var id_mhs = $(this).val();

            if (id_mhs) {
                $.ajax({
                    url: "<?= base_url('sipema/nilai/getMataKuliahByMahasiswa'); ?>" + "/" + id_mhs,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        $('#id_mata_kuliah').empty();
                        $('#id_mata_kuliah').append($('<option>', {
                            value: '',
                            text: 'Pilih Mata Kuliah'
                        }));
                        $.each(response, function(key, value) {
                            $('#id_mata_kuliah').append($('<option>', {
                                value: value.id_mata_kuliah,
                                text: value.nama_mata_kuliah
                            }));
                        });
                    }
                });
            } else {
                $('#id_mata_kuliah').empty();
                $('#id_mata_kuliah').append($('<option>', {
                    value: '',
                    text: 'Pilih Mata Kuliah'
                }));
            }
        });
    });
</script>
<script>
$(document).ready(function() {
     $('#dataTablePemetaanMataKuliah').DataTable({
        columnDefs: [
            {
                targets: [0, 1, 2],
                orderable: false,
            }
        ],
        rowGroup: {
            startRender: function (rows, group) {
            var namaSubBidang = group;
            var count = 0;
            rows.every(function () {
                if (this.data() && this.data().nama_sub_bidang === namaSubBidang) {
                    count++;
                }
            });
            
            return $('<tr role="group" class="bg-light"/>')
                .append('<th style="border-left: 2px solid black; border-width: 2px;" colspan="4">' + namaSubBidang + '</th>')
                <?php if(has_permission('pimpinan')) : ?>
                <?php else : ?>
                .append(`<button class="btn btn-sm dropdown-toggle more-horizontal mt-2 ml-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="<?= base_url("sipema/pemetaan_mata_kuliah/edit_sub_bidang_pemetaan") ?>/${rows.data()[0][1]}"><i class="fe fe-edit fe-16"></i> Edit</a><form method="POST" action="<?= base_url("sipema/pemetaan_mata_kuliah/hapus_sub_bidang_pemetaan") ?>/${rows.data()[0][1]}"><input name="_method" type="hidden" value="DELETE"><button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title="Delete"><i class="fe fe-delete fe-16"></i> Delete</button></form></div>`);
                <?php endif; ?>
            },
            endRender: null,
            dataSrc: 0
        },
    });

    $('#dataTableNilai').DataTable({
        columnDefs: [
            {
                targets: [0, 1, 2],
                orderable: false,
            }
        ],
        rowGroup: {
            startRender: function (rows, group) {

            var namaMahasiswa = group;

            var count = 0;
            rows.every(function () {
                if (this.data() && this.data().nama_mahasiswa === namaMahasiswa) {
                    count++;
                }
            });
            
            return $('<tr role="group" class="bg-light"/>')
                .append('<th style="border-left: 2px solid black; border-width: 2px;" colspan="4">' + namaMahasiswa + '</th>')
                <?php if(has_permission('pimpinan')) : ?>
                <?php else : ?>
                .append(`<button class="btn btn-sm dropdown-toggle more-horizontal mt-2 ml-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="<?= base_url("sipema/nilai/edit_mahasiswa") ?>/${rows.data()[0][1]}"><i class="fe fe-edit fe-16"></i> Edit</a><form method="POST" action="<?= base_url("sipema/nilai/hapus_mahasiswa") ?>/${rows.data()[0][1]}"><input name="_method" type="hidden" value="DELETE"><button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title="Delete"><i class="fe fe-delete fe-16"></i> Delete</button></form></div>`);
                <?php endif; ?>
            },
            endRender: null,
            dataSrc: 0
        },
    });

    $('#dataTableSubBidang').DataTable({
        rowGroup: {
            startRender: function (rows, group) {
                return $('<tr role="group" class="bg-light"/>')   
                    .append('<td style="border-left: 2px solid black; border-width: 2px;" rowspan="">' + rows.data()[0][0] + '</td>')
                    .append('<td style="border-left: 2px solid black; border-width: 2px;" colspan="2">' + rows.data()[0][2] + '</td>')
                    <?php if (has_permission('pimpinan')) : ?>
                    <?php else : ?>
                        .append(`<td><button class="btn btn-sm dropdown-toggle more-horizontal mt-2 ml-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="<?= base_url("sipema/sub-bidang/edit") ?>/${rows.data()[0][1]}"><i class="fe fe-edit fe-16"></i> Edit</a><form method="POST" action="<?= base_url("sipema/sub-bidang/hapus") ?>/${rows.data()[0][1]}"><input name="_method" type="hidden" value="DELETE"><button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title="Delete"><i class="fe fe-delete fe-16"></i> Delete</button></form></div></td>`);
                    <?php endif; ?>
            },
            endRender: null,
            dataSrc: 1
        },
    });
});
</script>
<script>
$(document).on('click', '#detailMataKuliah', function() {
  var id_bidang = $('#id_bidang').val();
  var id_sub_bidang = $('#id_sub_bidang').val();
  var url = "<?php echo base_url('sipema/hasil_pemetaan_keterampilan/getDataMataKuliah'); ?>";

  if (id_bidang && !id_sub_bidang) {
    
    url += "/" + id_bidang;
  } else if (id_bidang && id_sub_bidang) {
    
    url += "/" + id_sub_bidang;
  } else {

    Swal.fire({
      icon: "warning",
      text: "Bidang atau Sub Bidang harus dipilih!"
    });
    return false;
  }

  $.ajax({
    url: url,
    method: "GET",
    dataType: 'json',
    success: function(data) {
      var str = "";
      for (var i = 0; i < data.length; i++) {
        str += "<tr>";
        str += "<td>"+ data[i].kode_mk +"</td>";
        str += "<td>"+ data[i].nama_mk +"</td>";
        str += "<td>"+ data[i].sks_mk +"</td>";
        str += "</tr>";
      }
      document.querySelector('#isitabeldarihasilmatakuliah').innerHTML = str;
      $('#myModal').modal('show');
    },
    error: function() {
      Swal.fire({
        icon: "error",
        text: "Terjadi kesalahan saat mengambil data!"
      });
    }
  });
});
</script>
<script>
$(document).ready(function () {
  $('#prosesNilaiFilter').on('click', function () {
    var id_mhs_filter = $('#id_mhs_filter').val();
    var id_mata_kuliah_filter = $('#id_mata_kuliah_filter').val();
    var nilai_uts_uas_filter = $('#nilai_uts_uas_filter').val();
    
    if (id_mhs_filter != '' && id_mata_kuliah_filter == '' && nilai_uts_uas_filter == '') {
        var url = '<?php echo base_url('sipema/nilai/getFilterDataNilaiByIdMahasiswa');?>' + "/" + id_mhs_filter ;
    } else if (id_mhs_filter == '' && id_mata_kuliah_filter != '' && nilai_uts_uas_filter == '') {
        var url = '<?php echo base_url('sipema/nilai/getFilterDataNilaiByIdMataKuliah'); ?>' + "/" + id_mata_kuliah_filter;
    } else if (id_mhs_filter == '' && id_mata_kuliah_filter == '' && nilai_uts_uas_filter != '') {
        var url = '<?php echo base_url('sipema/nilai/getFilterDataNilaiByNilaiUtsUasFilter');?>' + "/" + nilai_uts_uas_filter ;
    } else if (id_mhs_filter != '' && id_mata_kuliah_filter != '' && nilai_uts_uas_filter == '') {
        var url = '<?php echo base_url('sipema/nilai/getFilterDataNilaiByIdMahasiswaAndIdMataKuliah');?>' + "/" + id_mhs_filter + "/" + id_mata_kuliah_filter;
    } else if (id_mhs_filter != '' && id_mata_kuliah_filter == '' && nilai_uts_uas_filter != '') {
        var url = '<?php echo base_url('sipema/nilai/getFilterDataNilaiByIdMahasiswaAndNilaiUtsUasFilter');?>' + "/" + id_mhs_filter + "/" + nilai_uts_uas_filter;
    } else if (id_mhs_filter == '' && id_mata_kuliah_filter != '' && nilai_uts_uas_filter != '') {
        var url = '<?php echo base_url('sipema/nilai/getFilterDataNilaiByIdMataKuliahAndNilaiUtsUasFilter');?>' + "/" + id_mata_kuliah_filter + "/" + nilai_uts_uas_filter ;
    } else if (id_mhs_filter != '' && id_mata_kuliah_filter != '' && nilai_uts_uas_filter != '') {
        var url = '<?php echo base_url('sipema/nilai/getFilterDataNilaiByIdMataKuliahAndNilaiUtsUasFilterAndNilaiUtsUasFilter');?>' + "/" + id_mhs_filter + "/" + id_mata_kuliah_filter + "/" + nilai_uts_uas_filter ;
    }
    
    $.ajax({
        url: url,
        method: "GET",
        dataType: 'json',
        success: function(data) {
        var dataAwal = data;
        
        $('#dataTableNilai').DataTable().clear().destroy();
            
            $.each(data, function(i, item) {
                $('#dataTableNilai tbody').append('<tr><td style="visibility: hidden;">' + item.nama + '</td><td class="d-none">' + item.id_mhs + '</td><td>' + item.nama_mata_kuliah + '</td><td>' + item.nilai_uts + '</td><td>' + item.nilai_uas + '</td><?php if(has_permission('pimpinan')) : ?><?php else : ?><td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="<?= base_url("sipema/nilai/edit_nilai_mata_kuliah") ?>' + '/' + item.id_mhs + '/' + item.id_mata_kuliah + '"><i class="fe fe-edit fe-16"></i> Edit</a><form method="POST" action="<?= base_url('sipema/nilai/hapus_nilai_mata_kuliah') ?>' + '/' + item.id_mhs + '"><input name="_method" type="hidden" value="DELETE"><input name="id_mata_kuliah" type="hidden" value="' + item.id_mata_kuliah + '"><button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title="Delete"><i class="fe fe-delete fe-16"></i> Delete</button></form></div></td><?php endif; ?></tr>');
            });
            $('#dataTableNilai').DataTable({
            columnDefs: [
                {
                    targets: [0, 1, 2],
                    orderable: false,
                }
            ],
            rowGroup: {
                startRender: function (rows, group) {

                var namaMahasiswa = group;

                var count = 0;
                rows.every(function () {
                    if (this.data() && this.data().nama_mahasiswa === namaMahasiswa) {
                        count++;
                    }
                });
                
                return $('<tr role="group" class="bg-light"/>')
                    <?php if(has_permission('pimpinan')) : ?>
                    .append('<th style="border-left: 2px solid black; border-width: 2px;" colspan="4">' + namaMahasiswa + '</th>')
                    <?php else : ?>
                    .append('<th style="border-left: 2px solid black; border-width: 2px;" colspan="4">' + namaMahasiswa + '</th>')
                    .append(`<button class="btn btn-sm dropdown-toggle more-horizontal mt-2 ml-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="<?= base_url("sipema/nilai/edit_mahasiswa") ?>/${rows.data()[0][1]}"><i class="fe fe-edit fe-16"></i> Edit</a><form method="POST" action="<?= base_url("sipema/nilai/hapus_mahasiswa") ?>/${rows.data()[0][1]}"><input name="_method" type="hidden" value="DELETE"><button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title="Delete"><i class="fe fe-delete fe-16"></i> Delete</button></form></div>`);
                    <?php endif; ?>
                },
                endRender: null,
                dataSrc: 0
            },
        });
        },
    });
  });
  $(document).ready(function() {
        $('#resetNilaiFilter').click(function() {
            $('#id_mhs_filter').val(null).trigger('change');
            $('#id_mata_kuliah_filter').val(null).trigger('change');
            $('#nilai_uts_uas_filter').val(null).trigger('change');
            $.ajax({
                url: '<?php echo base_url('sipema/nilai/getDetailNilaiMataKuliahMahasiswa');?>',
                method: "GET",
                dataType: 'json',
                success: function(data) {
                
                $('#dataTableNilai').DataTable().clear().destroy();
                    
                    $.each(data, function(i, item) {
                        $('#dataTableNilai tbody').append('<tr><td style="visibility: hidden;">' + item.nama_mahasiswa + '</td><td class="d-none">' + item.id_mhs + '</td><td>' + item.nama_mata_kuliah + '</td><td>' + item.nilai_uts + '</td><td>' + item.nilai_uas + '</td><?php if(has_permission('pimpinan')) : ?><?php else : ?><td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="<?= base_url("sipema/nilai/edit_nilai_mata_kuliah") ?>' + '/' + item.id_mhs + '/' + item.id_mata_kuliah + '"><i class="fe fe-edit fe-16"></i> Edit</a><form method="POST" action="<?= base_url('sipema/nilai/hapus_nilai_mata_kuliah') ?>' + '/' + item.id_mhs + '"><input name="_method" type="hidden" value="DELETE"><input name="id_mata_kuliah" type="hidden" value="' + item.id_mata_kuliah + '"><button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title="Delete"><i class="fe fe-delete fe-16"></i> Delete</button></form></div></td><?php endif; ?></tr>');
                    });
                    $('#dataTableNilai').DataTable({
                    columnDefs: [
                        {
                            targets: [0, 1, 2],
                            orderable: false,
                        }
                    ],
                    rowGroup: {
                        startRender: function (rows, group) {

                        var namaMahasiswa = group;

                        var count = 0;
                        rows.every(function () {
                            if (this.data() && this.data().nama_mahasiswa === namaMahasiswa) {
                                count++;
                            }
                        });
                        return $('<tr role="group" class="bg-light"/>')
                            <?php if(has_permission('pimpinan')) : ?>
                            .append('<th style="border-left: 2px solid black; border-width: 2px;" colspan="4">' + namaMahasiswa + '</th>')
                            <?php else : ?>
                            .append('<th style="border-left: 2px solid black; border-width: 2px;" colspan="4">' + namaMahasiswa + '</th>')
                            .append(`<button class="btn btn-sm dropdown-toggle more-horizontal mt-2 ml-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="<?= base_url("sipema/nilai/edit_mahasiswa") ?>/${rows.data()[0][1]}"><i class="fe fe-edit fe-16"></i> Edit</a><form method="POST" action="<?= base_url("sipema/nilai/hapus_mahasiswa") ?>/${rows.data()[0][1]}"><input name="_method" type="hidden" value="DELETE"><button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title="Delete"><i class="fe fe-delete fe-16"></i> Delete</button></form></div>`);
                            <?php endif; ?>
                        },
                        endRender: null,
                        dataSrc: 0
                    },
                });
                },
            });
        });
  }); 
});  
</script>
<script>
$(document).ready(function () {
  $('#prosesFilterPemetaanMataKuliah').on('click', function () {

    var id_bidang_filter_pemetaan = $('#id_bidang_filter_pemetaan').val();
    var id_sub_bidang_filter_pemetaan = $('#id_sub_bidang_filter_pemetaan').val();
    var jenis_bobot_filter_pemetaan = $('#jenis_bobot_filter_pemetaan').val();

    if (id_bidang_filter_pemetaan != '' && id_sub_bidang_filter_pemetaan == '' && jenis_bobot_filter_pemetaan == '') {
              var url = "<?php echo base_url('sipema/pemetaan_mata_kuliah/getDataFilterPemetaan'); ?>" + "/" + id_bidang_filter_pemetaan;
    } else if (id_bidang_filter_pemetaan != '' && id_sub_bidang_filter_pemetaan != '' && jenis_bobot_filter_pemetaan == '') {
              var url = "<?php echo base_url('sipema/pemetaan_mata_kuliah/getDataFilterPemetaan'); ?>" + "/" + id_bidang_filter_pemetaan + "/" + id_sub_bidang_filter_pemetaan;
    } else if (id_bidang_filter_pemetaan != '' && id_sub_bidang_filter_pemetaan != '' && jenis_bobot_filter_pemetaan != '') {
              var url = "<?php echo base_url('sipema/pemetaan_mata_kuliah/getDataFilterPemetaan'); ?>" + "/" + id_bidang_filter_pemetaan + "/" + id_sub_bidang_filter_pemetaan + "/" + jenis_bobot_filter_pemetaan;
    } else if (id_bidang_filter_pemetaan != '' && id_sub_bidang_filter_pemetaan == '' && jenis_bobot_filter_pemetaan != '') {
              var url = "<?php echo base_url('sipema/pemetaan_mata_kuliah/getDataFilterPemetaanBidangJenisBobot'); ?>" + "/" + id_bidang_filter_pemetaan + "/" + jenis_bobot_filter_pemetaan;
    } else if (id_bidang_filter_pemetaan == '' && id_sub_bidang_filter_pemetaan == '' && jenis_bobot_filter_pemetaan != '') {
              var url = "<?php echo base_url('sipema/pemetaan_mata_kuliah/getDataFilterPemetaanJenisBobot'); ?>" + "/" + jenis_bobot_filter_pemetaan;
    } 

    $.ajax({
        url: url,
        method: "GET",
        dataType: 'json',
        success: function(data) {
        var dataAwal = data;
        
        $('#dataTablePemetaanMataKuliah').DataTable().clear().destroy();
           
            $.each(data, function(i, item) {
                $('#dataTablePemetaanMataKuliah tbody').append('<tr><td style="visibility: hidden;">' + item.nama_sub_bidang + '</td><td class="d-none">' + item.id_sub_bidang + '</td><td>' + item.nama_mata_kuliah + '</td><td>' + item.jenis_bobot + '</td><td>' + item.nilai_bobot + '</td><?php if(has_permission('pimpinan')) : ?><?php else: ?><td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="<?= base_url("sipema/pemetaan_mata_kuliah/edit_detail_pemetaan_mata_kuliah") ?>' + '/' + item.id_sub_bidang + '/' + item.id_mata_kuliah + '"><i class="fe fe-edit fe-16"></i> Edit</a><form method="POST" action="<?= base_url('sipema/pemetaan_mata_kuliah/hapus_detail_pemetaan_mata_kuliah') ?>' + '/' + item.id_sub_bidang + '"><input name="_method" type="hidden" value="DELETE"><input name="id_mata_kuliah" type="hidden" value="' + item.id_mata_kuliah + '"><button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title="Delete"><i class="fe fe-delete fe-16"></i> Delete</button></form></div></td><?php endif; ?></tr>');
            });
            $('#dataTablePemetaanMataKuliah').DataTable({
            columnDefs: [
                {
                    targets: [0, 1, 2],
                    orderable: false,
                }
            ],
            rowGroup: {
                startRender: function (rows, group) {

                var namaSubBidang = group;

                var count = 0;
                rows.every(function () {
                    if (this.data() && this.data().nama_sub_bidang === namaSubBidang) {
                        count++;
                    }
                });
                return $('<tr role="group" class="bg-light"/>')
                    <?php if(has_permission('pimpinan')) : ?>
                    .append('<th style="border-left: 2px solid black; border-width: 2px;" colspan="4">' + namaSubBidang + '</th>')
                    <?php else: ?>
                    .append('<th style="border-left: 2px solid black; border-width: 2px;" colspan="4">' + namaSubBidang + '</th>')
                    .append(`<button class="btn btn-sm dropdown-toggle more-horizontal mt-2 ml-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="<?= base_url("sipema/pemetaan_mata_kuliah/edit_sub_bidang_pemetaan") ?>/${rows.data()[0][1]}"><i class="fe fe-edit fe-16"></i> Edit</a><form method="POST" action="<?= base_url("sipema/pemetaan_mata_kuliah/hapus_sub_bidang_pemetaan") ?>/${rows.data()[0][1]}"><input name="_method" type="hidden" value="DELETE"><button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title="Delete"><i class="fe fe-delete fe-16"></i> Delete</button></form></div>`);
                    <?php endif; ?>
                },
                endRender: null,
                dataSrc: 0
            },
        });
        },
    });
  });
  $(document).ready(function() {
        $('#resetFilterPemetaanMataKuliah').click(function() {
            $('#id_bidang_filter_pemetaan').val(null).trigger('change');
            $('#id_sub_bidang_filter_pemetaan').val(null).trigger('change');
            $('#jenis_bobot_filter_pemetaan').val(null).trigger('change');
            $.ajax({
                url: '<?php echo base_url('sipema/pemetaan_mata_kuliah/getDetailPemetaanMataKuliah');?>',
                method: "GET",
                dataType: 'json',
                success: function(data) {
                
                $('#dataTablePemetaanMataKuliah').DataTable().clear().destroy();
                   
                    $.each(data, function(i, item) {
                        $('#dataTablePemetaanMataKuliah tbody').append('<tr><td style="visibility: hidden;">' + item.nama_sub_bidang + '</td><td class="d-none">' + item.id_sub_bidang + '</td><td>' + item.nama_mata_kuliah + '</td><td>' + item.jenis_bobot + '</td><td>' + item.nilai_bobot + '</td><?php if(has_permission('pimpinan')) : ?><?php else: ?><td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="<?= base_url("sipema/pemetaan_mata_kuliah/edit_detail_pemetaan_mata_kuliah") ?>' + '/' + item.id_sub_bidang + '/' + item.id_mata_kuliah + '"><i class="fe fe-edit fe-16"></i> Edit</a><form method="POST" action="<?= base_url('sipema/pemetaan_mata_kuliah/hapus_detail_pemetaan_mata_kuliah') ?>' + '/' + item.id_sub_bidang + '"><input name="_method" type="hidden" value="DELETE"><input name="id_mata_kuliah" type="hidden" value="' + item.id_mata_kuliah + '"><button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title="Delete"><i class="fe fe-delete fe-16"></i> Delete</button></form></div></td><?php endif; ?></tr>');
                    });
                    $('#dataTablePemetaanMataKuliah').DataTable({
                    columnDefs: [
                        {
                            targets: [0, 1, 2],
                            orderable: false,
                        }
                    ],
                    rowGroup: {
                        startRender: function (rows, group) {

                        var namaSubBidang = group;

                        var count = 0;
                        rows.every(function () {
                            if (this.data() && this.data().nama_sub_bidang === namaSubBidang) {
                                count++;
                            }
                        });
                        return $('<tr role="group" class="bg-light"/>')
                            <?php if(has_permission('pimpinan')) : ?>
                            .append('<th style="border-left: 2px solid black; border-width: 2px;" colspan="4">' + namaSubBidang + '</th>')
                            <?php else: ?>
                            .append('<th style="border-left: 2px solid black; border-width: 2px;" colspan="4">' + namaSubBidang + '</th>')
                            .append(`<button class="btn btn-sm dropdown-toggle more-horizontal mt-2 ml-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="<?= base_url("sipema/pemetaan_mata_kuliah/edit_sub_bidang_pemetaan") ?>/${rows.data()[0][1]}"><i class="fe fe-edit fe-16"></i> Edit</a><form method="POST" action="<?= base_url("sipema/pemetaan_mata_kuliah/hapus_sub_bidang_pemetaan") ?>/${rows.data()[0][1]}"><input name="_method" type="hidden" value="DELETE"><button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title="Delete"><i class="fe fe-delete fe-16"></i> Delete</button></form></div>`);
                            <?php endif; ?>
                        },
                        endRender: null,
                        dataSrc: 0
                    },
                });
                },
            });
        });
  }); 
});  
</script>
<script>
$('#id_bidang_filter_pemetaan').change(function() {
        var id_bidang_filter_pemetaan = $(this).val();
        $.ajax({
            url: '<?php echo base_url('sipema/hasil_pemetaan_keterampilan/getSubBidangByBidang'); ?>' + "/" + id_bidang_filter_pemetaan,
            type: 'get',
            dataType: 'json',
            success: function(data) {
                    
                    $('#id_sub_bidang_filter_pemetaan').prop('disabled', false);
                    var idSubBidangSebelumnya2 = $('#id_sub_bidang_filter_pemetaan').val(); 
                    
                    $('#id_sub_bidang_filter_pemetaan').empty();
                    $('#id_sub_bidang_filter_pemetaan').append('<option value="">Semua Sub Bidang</option>');
                    
                    $.each(data, function(key, value) {
                        $('#id_sub_bidang_filter_pemetaan').append('<option value="' + value.id_sub_bidang + '">' + value.nama_sub_bidang + '</option>');
                    });
                    
                    if (idSubBidangSebelumnya2 != null && idSubBidangSebelumnya2 != '') {
                        $('#id_sub_bidang_filter_pemetaan').val(idSubBidangSebelumnya2);
                    }
                    id_sub_bidang_terpilih2 = $('#id_sub_bidang_filter_pemetaan').val(); 
                },
                error: function(xhr, status, error) {
                    console.error(xhr.dataText);
                }
            });
            
            if ($('#id_bidang option:selected').length > 0 ) {
                $('#id_sub_bidang_filter_pemetaan').append('<option value="">Pilih Sub Bidang</option>');
            }
            if(id_bidang == null || id_bidang == '' ){
                $('#id_sub_bidang_filter_pemetaan').prop('disabled', true);
                $('#id_sub_bidang_filter_pemetaan').empty();
                $('#id_sub_bidang_filter_pemetaan').append('<option value="">Pilih Nama Sub Bidang</option>');
            }
    });
</script>
<script>
/* defind global options */
Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
Chart.defaults.global.defaultFontColor = colors.mutedColor;
</script>
<script src="<?= base_url('../assets/js/gauge.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/jquery.sparkline.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/apexcharts.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/apexcharts.custom.js') ?>"></script>
<script src="<?= base_url('../assets/js/jquery.mask.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/select2.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/jquery.steps.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/jquery.validate.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/jquery.timepicker.js') ?>"></script>
<script src="<?= base_url('../assets/js/dropzone.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/uppy.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/quill.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('../assets/js/dataTables.rowGroup.js') ?>"></script>
<script>
$(document).ready(function() {
    $('#dataTable-1').DataTable();
});
</script>
<script>
$(".select2").select2({
    theme: "bootstrap4",
});
$(".select2-multi").select2({
    multiple: true,
    theme: "bootstrap4",
});
$(".drgpicker").daterangepicker({
    singleDatePicker: true,
    timePicker: false,
    showDropdowns: true,
    locale: {
        format: "MM/DD/YYYY",
    },
});
$(".time-input").timepicker({
    scrollDefault: "now",
    zindex: "9999" /* fix modal open */ ,
});
/** date range picker */
if ($(".datetimes").length) {
    $(".datetimes").daterangepicker({
        timePicker: true,
        startDate: moment().startOf("hour"),
        endDate: moment().startOf("hour").add(32, "hour"),
        locale: {
            format: "M/DD hh:mm A",
        },
    });
}
var start = moment().subtract(29, "days");
var end = moment();

function cb(start, end) {
    $("#reportrange span").html(
        start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
    );
}
$("#reportrange").daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            Today: [moment(), moment()],
            Yesterday: [
                moment().subtract(1, "days"),
                moment().subtract(1, "days"),
            ],
            "Last 7 Days": [moment().subtract(6, "days"), moment()],
            "Last 30 Days": [moment().subtract(29, "days"), moment()],
            "This Month": [moment().startOf("month"), moment().endOf("month")],
            "Last Month": [
                moment().subtract(1, "month").startOf("month"),
                moment().subtract(1, "month").endOf("month"),
            ],
        },
    },
    cb
);
cb(start, end);
$(".input-placeholder").mask("00/00/0000", {
    placeholder: "__/__/____",
});
$(".input-zip").mask("00000-000", {
    placeholder: "____-___",
});
$(".input-money").mask("#.##0,00", {
    reverse: true,
});
$(".input-phoneus").mask("(000) 000-0000");
$(".input-mixed").mask("AAA 000-S0S");
$(".input-ip").mask("0ZZ.0ZZ.0ZZ.0ZZ", {
    translation: {
        Z: {
            pattern: /[0-9]/,
            optional: true,
        },
    },
    placeholder: "___.___.___.___",
});
// editor
var editor = document.getElementById("editor");
if (editor) {
    var toolbarOptions = [
        [{
            font: [],
        }, ],
        [{
            header: [1, 2, 3, 4, 5, 6, false],
        }, ],
        ["bold", "italic", "underline", "strike"],
        ["blockquote", "code-block"],
        [{
                header: 1,
            },
            {
                header: 2,
            },
        ],
        [{
                list: "ordered",
            },
            {
                list: "bullet",
            },
        ],
        [{
                script: "sub",
            },
            {
                script: "super",
            },
        ],
        [{
                indent: "-1",
            },
            {
                indent: "+1",
            },
        ], // outdent/indent
        [{
            direction: "rtl",
        }, ], // text direction
        [{
                color: [],
            },
            {
                background: [],
            },
        ], // dropdown with defaults from theme
        [{
            align: [],
        }, ],
        ["clean"], // remove formatting button
    ];
    var quill = new Quill(editor, {
        modules: {
            toolbar: toolbarOptions,
        },
        theme: "snow",
    });
}
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    "use strict";
    window.addEventListener(
        "load",
        function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName("needs-validation");
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(
                forms,
                function(form) {
                    form.addEventListener(
                        "submit",
                        function(event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add("was-validated");
                        },
                        false
                    );
                }
            );
        },
        false
    );
})();
</script>
<script>
var uptarg = document.getElementById("drag-drop-area");
if (uptarg) {
    var uppy = Uppy.Core()
        .use(Uppy.Dashboard, {
            inline: true,
            target: uptarg,
            proudlyDisplayPoweredByUppy: false,
            theme: "dark",
            width: 770,
            height: 210,
            plugins: ["Webcam"],
        })
        .use(Uppy.Tus, {
            endpoint: "https://master.tus.io/files/",
        });
    uppy.on("complete", (result) => {
        console.log(
            "Upload complete! We’ve uploaded these files:",
            result.successful
        );
    });
}
</script>
<script src="<?= base_url('../assets/js/apps.js') ?>"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
<script>
window.dataLayer = window.dataLayer || [];

function gtag() {
    dataLayer.push(arguments);
}
gtag("js", new Date());
gtag("config", "UA-56159088-1");
</script>
</body>

</html>