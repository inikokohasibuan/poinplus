<!doctype html>
<html>

<head>
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- REQUIRED SCRIPTS -->


    <script src="{{asset('plugins/jquery.mask.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js')}}"></script>

    <script src="{{asset('plugins/terbilang.js')}}"></script>

    <!-- DataTables  & Plugins -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
    <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
    <script>
        function formatInputUang(input) {
            let value = input.value.replace(/[^0-9,]/g, ''); // Hanya izinkan angka dan koma
            if (value.includes(',')) {
                let parts = value.split(',');
                if (parts.length > 2) {
                    parts = [parts[0], parts.slice(1).join('')];
                }
                value = parts.join('.');
            }
            value = value ? parseFloat(value).toLocaleString('id-ID') : '';
            input.value = value;
        }

        function formatInputPersen(input) {
            let value = input.value.replace(/[^\d.]/g, ''); // Hanya izinkan angka dan titik desimal
            if (value.includes('.')) {
                let parts = value.split('.');
                if (parts.length > 2) {
                    parts = [parts[0], parts.slice(1).join('')];
                }
                value = parts.join('.');
            }
            input.value = value;
        }

        function showFlashMessage(type, message) {
            toastr[type](message);
        }
    </script>
    @include('includes.head')
    <style>
        button {
            margin: 0;
            padding: 0;
            display: flex;
        }

        button .konten {
            display: flex;
            position: absolute;
            top: 50%;
            left: 55px;
            max-width: 400px;
            background: #000;
            padding: 20px;
            box-sizing: border-box;
            border-radius: 4px;
            visibility: hidden;
            opacity: 0;
            transition: 0.5s;
            transform: translateX(-50%) translateY(-50px);
        }

        button .konten:before {
            content: '';
            position: absolute;
            max-width: 30px;
            max-height: 30px;
            background: #000;
            top: -15px;
            left: 194px;
            transform: rotate(-45deg);
        }

        button:hover .konten {
            visibility: visible;
            opacity: 1;
            transform: translateX(-50%) translateY(0px);
        }
    </style>
</head>

<body class="text-sm">
    <div class="wrapper">
        @include('includes.header')
        @include('includes.menu')
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h4 class="m-0">@yield('page')</h4>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Main row -->
                    <div class="row">
                        <div class="col-lg-12">
                            @yield('content')
                        </div>
                    </div>
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
        </div>
        @if(Session::has('flashMessage'))
        <script>
            showFlashMessage("{{Session::get('flashMessage')['type']}}", "{{Session::get('flashMessage')['message']}}");
        </script>
        @endif
        @include('includes.footer')
    </div>

    <script type="text/javascript">
        function alpha(e) {
            var k;
            document.all ? k = e.keyCode : k = e.which;
            return (k == 46 || (k >= 48 && k <= 57));
        }

        function inputTerbilang(angka, textangka) {
            if (angka.value === '') {
                textangka.innerHTML = '';
            } else {
                $('.mata-uang').mask('0.000.000.000', {
                    reverse: true
                });
                var input = angka.value.replace(/\./g, "");
                textangka.innerHTML = terbilang(input).replace(/  +/g, ' ');
            }
        }

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
            $('#example3').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
            $('#example4').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });

        function tgl_indo(tanggal) {
            const bulan = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            const pecahkan = tanggal.split('-');
            return pecahkan[2] + ' ' + bulan[parseInt(pecahkan[1], 10) - 1] + ' ' + pecahkan[0];
        }

        function createElement(tag, className, id) {
            const element = document.createElement(tag);
            if (className) element.className = className;
            if (id) element.id = id;
            return element;
        }
    </script>

</body>

</html>