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
// Hapus data
$(document).ready(function() {
    $('.remove-item-btn').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        return Swal.fire({
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
            }
        });
    });
});
</script>
<script>
  var myChart; // tambahkan variabel global untuk menyimpan objek grafik
  var id_bidang = $('#id_bidang').val();
  var id_sub_bidang_terpilih = $('#id_sub_bidang').val(); // Menyimpan nilai id_sub_bidang yang telah dipilih sebelumnya

  $(document).on('change', '#id_bidang, #id_sub_bidang', function() {
      var id_bidang = $('#id_bidang').val();
      var id_sub_bidang = $('#id_sub_bidang').val();
      var nilai_akhir_filter = $('#nilai_akhir_filter').val();
      var sks_filter = $('#sks_filter').val();
      var url = "<?php echo base_url('sipema/hasil_pemetaan_keterampilan/getDataSubBidang'); ?>" + "/" + id_bidang;
        
        if (id_sub_bidang != '' && nilai_akhir_filter != '' && sks_filter != '') {
            url += "/" + id_sub_bidang + "/" + nilai_akhir_filter + "/" + sks_filter;
        } else if (id_sub_bidang != '' && nilai_akhir_filter == '' && sks_filter == '') {
            url += "/" + id_sub_bidang;
        } else if (id_sub_bidang == '' && nilai_akhir_filter != '' && sks_filter == '') {
            url += "/''/" + nilai_akhir_filter;
        } else if (id_sub_bidang == '' && nilai_akhir_filter == '' && sks_filter != '') {
            url += "/''/''/" + sks_filter;
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

                 if (myChart) {
                    myChart.destroy();
                }
            } else {
                var str = "";
                var count = 1;
                var maxNilai = -Infinity; 
                var namaMahasiswa = '';
                for (var i = 0; i < data.length; i++) {
                    str += "<tr>";
                    str += "<td>"+ count++ +"</td>";
                    str += '<td>'+ data[i].nama_mahasiswa +'</td>';
                    str += '<td>'+ data[i].total_sks +'</td>';
                    str += '<td>'+ data[i].nilai_akhir +'</td>';
                    str += "</tr>";

                    if (data[i].nilai_akhir > maxNilai) {
                        maxNilai = data[i].nilai_akhir;
                        namaMahasiswa = data[i].nama_mahasiswa;
                    }
                }

                document.querySelector('#isitabeldarihasilpemilihansubbidang').innerHTML = str;
                document.querySelector('#nilaiTertinggi').textContent = maxNilai;
                document.querySelector('#namaMahasiswa').textContent = namaMahasiswa;

                var ctx = document.getElementById('chartHanif').getContext('2d');
                    // hapus grafik lama sebelum menambahkan yang baru
                    if (window.myChart) {
                        window.myChart.destroy();
                    }

                    // tambahkan data untuk membuat grafik
                    var labels = [];
                    var nilai_akhir = [];
                    for (var i = 0; i < data.length; i++) {
                        labels.push(data[i].nama_mahasiswa);
                        nilai_akhir.push(data[i].nilai_akhir);
                    }

                window.myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                        label: 'Nilai Akhir',
                        data: nilai_akhir,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    font: {
                                        color: 'black' // atur warna label y-axis menjadi hitam
                                    }
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        color: 'black' // atur warna label x-axis menjadi hitam
                                    }
                                }
                            }
                        }
                    }
                });
          }
        }
      });

      $.ajax({
        url: '<?php echo base_url('sipema/hasil_pemetaan_keterampilan/getSubBidangByBidang'); ?>' + "/" + id_bidang, // URL ke controller yang menghandle ajax
        type: 'get',
        dataType: 'json',
        success: function(data) {
                // Aktifkan dropdown id_sub_bidang
                $('#id_sub_bidang').prop('disabled', false);
                var idSubBidangSebelumnya = $('#id_sub_bidang').val(); // Menyimpan nilai id_sub_bidang yang telah dipilih sebelumnya
                // Menghapus pilihan sub bidang yang ada sebelumnya
                $('#id_sub_bidang').empty();
                // Menambahkan pilihan sub bidang baru dengan kata-kata "Pilih Sub Bidang"
                $('#id_sub_bidang').append('<option value="">Pilih Sub Bidang</option>');
                // Menambahkan pilihan sub bidang baru
                $.each(data, function(key, value) {
                    $('#id_sub_bidang').append('<option value="' + value.id_sub_bidang + '">' + value.nama_sub_bidang + '</option>');
                });
                // Mengatur ulang nilai yang telah dipilih sebelumnya
                if (idSubBidangSebelumnya != null && idSubBidangSebelumnya != '') {
                    $('#id_sub_bidang').val(idSubBidangSebelumnya);
                }
                id_sub_bidang_terpilih = $('#id_sub_bidang').val(); // Mengupdate nilai id_sub_bidang_terpilih
            },
            error: function(xhr, status, error) {
                console.error(xhr.dataText);
            }
        });
         // Menampilkan option "Pilih Sub Bidang" ketika id_bidang diganti lebih dari satu kali
        if ($('#id_bidang option:selected').length > 0) {
            $('#id_sub_bidang').append('<option value="">Pilih Sub Bidang</option>');
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
<!-- <script>
    $(document).ready(function () {
        $('#id_mhs').on('change', function () {
            var id_mhs = $(this).val();
            $.ajax({
                url: "<?= base_url('sipema/hasil_pemetaan_keterampilan/getChartDataByMahasiswa'); ?>" + "/" + id_mhs,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    var ctx = document.getElementById('chartHanif').getContext('2d');
                    // hapus grafik lama sebelum menambahkan yang baru
                    if (window.myChart) {
                        window.myChart.destroy();
                    }
                    window.myChart = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                }
                            },
                        }
                    });
                }
            });
        });
    });
</script> -->
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