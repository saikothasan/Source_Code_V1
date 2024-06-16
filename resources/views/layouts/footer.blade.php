<footer class="main-footer">
    <div class="row text-center">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <span> Copyright &copy; 2020-{{ Carbon\carbon::now()->year }}
                <a href="http://ictbanglabd.com/" target="_blank">ICT Bangla BD</a>.</span>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <span> {{ translate('For')}} {{ translate('Support')}}<a> +88 01766 - 94 89 57</a></span>
        </div>

    </div>
</footer>

<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/raphael-min.js') }}"></script>
<script src="{{ asset('assets/plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('assets/plugins/knob/jquery.knob.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>

<script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/plugins/fastclick/fastclick.js') }}"></script>
<script src="{{ asset('assets/dist/js/app.min.js') }}"></script>

<script src="{{ asset('assets/dist/js/demo.js') }}"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

{{-- <script src="{{ asset('js/custom.js') }}"></script> --}}
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    // success message popup notification
    @if (Session::has('message'))
        toastr.success("{{ Session::get('message') }}");
    @endif
    @if (Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
    @endif
    // info message popup notification
    @if (Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
    @endif

    // warning message popup notification
    @if (Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
    @endif

    // error message popup notification
    @if (Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif
</script>
<script>
    $(".select2").select2();
    $(function() {
        $("#example1").DataTable({
            "pageLength": 100,
            responsive: true,
            "scrollY": "100%",
            "scrollCollapse": true,
        });
        $("#example2").DataTable({
            "pageLength": 100,
            responsive: true,
            "scrollY": "200px",
            "scrollCollapse": true,
        });
        //CKEDITOR.replace('editor1');

    });

    $.ajaxSetup({

        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}'
        }

    });
</script>




@section('footerSection')

@show
