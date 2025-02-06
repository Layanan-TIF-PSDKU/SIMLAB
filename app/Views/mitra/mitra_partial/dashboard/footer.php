</div>
<script src="<?=base_url('../assets/js/jquery.min.js')?>"></script>
<script src="<?=base_url('../assets/js/popper.min.js')?>"></script>
<script src="<?=base_url('../assets/js/moment.min.js')?>"></script>
<script src="<?=base_url('../assets/js/bootstrap.min.js')?>"></script>
<script src="<?=base_url('../assets/js/simplebar.min.js')?>"></script>
<script src="<?=base_url('../assets/js/daterangepicker.js')?>"></script>
<script src="<?=base_url('../assets/js/jquery.stickOnScroll.js')?>"></script>
<script src="<?=base_url('../assets/js/tinycolor-min.js')?>"></script>
<script src="<?=base_url('../assets/js/config.js')?>"></script>
<script src="<?=base_url('../assets/js/d3.min.js')?>"></script>
<script src="<?=base_url('../assets/js/topojson.min.js')?>"></script>
<script src="<?=base_url('../assets/js/datamaps.all.min.js')?>"></script>
<script src="<?=base_url('../assets/js/datamaps-zoomto.js')?>"></script>
<script src="<?=base_url('../assets/js/datamaps.custom.js')?>"></script>
<script src="<?=base_url('../assets/js/Chart.min.js')?>"></script>
<script src="<?=base_url('../assets/js/sweetalert2.min.js')?>"></script>
<!-- Modal -->
<div class="modal fade" id="importexcelmatakuliah" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verticalModalTitle">Import Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Upload file excel data mahasiswa</label>
                </div>
                <form action="/file-upload" class="dropzone bg-light rounded-lg" id="tinydash-dropzone">
                    <div class="dz-message needsclick">
                        <div class="circle circle-lg bg-primary">
                            <i class="fe fe-upload fe-24 text-white"></i>
                        </div>
                        <h5 class="text-muted mt-4">Drop files here or click to upload</h5>
                    </div>
                    <input type="file" name="file" id="file" class="d-none" accept=".xlsx,.xls">
                </form>
                <!-- Preview -->
                <!-- <div class="dropzone-previews mt-3" id="file-previews"></div> -->
                <!-- file preview template -->
                <div class="d-none" id="uploadPreviewTemplate">
                    <div class="card mt-1 mb-0 shadow-none border">
                        <div class="p-2">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
                                </div>
                                <div class="col pl-0">
                                    <a href="javascript:void(0);" class="text-muted font-weight-bold" data-dz-name></a>
                                    <p class="mb-0" data-dz-size></p>
                                </div>
                                <div class="col-auto">
                                    <!-- Button -->
                                    <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
                                        <i class="dripicons-cross"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn mb-2 btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
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
/* defind global options */
Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
Chart.defaults.global.defaultFontColor = colors.mutedColor;
</script>
<script src="<?=base_url('../assets/js/gauge.min.js')?>"></script>
<script src="<?=base_url('../assets/js/jquery.sparkline.min.js')?>"></script>
<script src="<?=base_url('../assets/js/apexcharts.min.js')?>"></script>
<script src="<?=base_url('../assets/js/apexcharts.custom.js')?>"></script>
<script src="<?=base_url('../assets/js/jquery.mask.min.js')?>"></script>
<script src="<?=base_url('../assets/js/select2.min.js')?>"></script>
<script src="<?=base_url('../assets/js/jquery.steps.min.js')?>"></script>
<script src="<?=base_url('../assets/js/jquery.validate.min.js')?>"></script>
<script src="<?=base_url('../assets/js/jquery.timepicker.js')?>"></script>
<script src="<?=base_url('../assets/js/dropzone.min.js')?>"></script>
<script src="<?=base_url('../assets/js/uppy.min.js')?>"></script>
<script src="<?=base_url('../assets/js/quill.min.js')?>"></script>
<script src="<?=base_url('../assets/js/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('../assets/js/dataTables.bootstrap4.min.js')?>"></script>
<script>
$("#dataTable-1").DataTable({
    autoWidth: true,
    lengthMenu: [
        [16, 32, 64, -1],
        [16, 32, 64, "All"],
    ],
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
<script src="<?=base_url('../assets/js/apps.js')?>"></script>
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

<script>
$('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
});
</script>
</body>

</html>