<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title." - ".Setting::getValue('app_name') }}</title>
        <link rel="icon" href="{{ asset(Setting::getValue('app_favicon')) }}" type="image/png" />
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('template/admin/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('template/admin/dist/css/adminlte.min.css') }}">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{ asset('template/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{ asset('template/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('template/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('template/admin/plugins/select2/css/select2.css')}}">
        <link rel="stylesheet" href="{{ asset('template/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
        <link rel="stylesheet" href="{{ asset('template/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
        @stack('style')
    </head>

<body>
    <section class="content">
        <div class="container-fluid p-5">
            <div class="row mb-5">
                <div class="col col-md-12"><img src="{{ asset('storage/Header.png') }}" class="width:100%" alt=""></div>
            </div>
            <div class="row">
                <div class="offset-md-8">
                </div>
                <div class="col col-lg-2">
                  <p class="h6">Lembar ke</p>
                </div>
                <div class="col col-lg-2">
                    <p class="h6">:</p>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-8">
                </div>
                <div class="col col-lg-2">
                  <p class="h6">Kode nomor</p>
                </div>
                <div class="col col-lg-2">
                    <p class="h6">:</p>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-8">
                </div>
                <div class="col col-lg-2">
                  <p class="h6">Nomor</p>
                </div>
                <div class="col col-lg-2">
                    <p class="h6">:</p>
                </div>
            </div>
            <p class="text-center font-weight-bold h3 mt-2">Surat Perjalanan Dinas (SPD)</p>
            <div class="row">
                <div class="col-12 mt-3">
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="d-flex">
                                <td class="col-1 h-6 p-1"><p class="text-center">1</p></td>
                                <td class="col-5 h-6 p-1"><p class="text-left">Pengguna Anggaran/Kuasa Pengguna Anggaran</p></td>
                                <td class="col-6 h-6 p-1"><p class="text-left">Sutra Sugi Prabowo</p></td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-1 h-6 p-1"><p class="text-center">2</p></td>
                                <td class="col-5 h-6 p-1"><p class="text-left">Nama/NIP Pegawai yang melaksanakan perjalanan dinas</p></td>
                                <td class="col-6 h-6 p-1">
                                    <p class="text-left m-0">Sutra Sugi Prabowo</p>
                                    <p class="text-left mb-1">NIP.089646771518</p>
                                </td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-1 h-6 p-1"><p class="text-center">3</p></td>
                                <td class="col-5 h-6 p-1">
                                    <p class="text-left m-0">a. Pangkat dan Golongan</p>
                                    <p class="text-left m-0">b. Jabatan</p>
                                    <p class="text-left mb-1">c. Tingkat Biaya Perjalanan Dinas</p>
                                </td>
                                <td class="col-6 h-6 p-1">
                                    <p class="text-left m-0">Golongan orang beriman</p>
                                    <p class="text-left m-0">Kepala Keluarga</p>
                                    <p class="text-left mb-1">RP. 200.000</p>
                                </td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-1 h-6 p-1"><p class="text-center">4</p></td>
                                <td class="col-5 h-6 p-1"><p class="text-left">Maksud Perjalanan Dinas</p></td>
                                <td class="col-6 h-6 p-1"><p class="text-left">Kegiatan Chitose Gathering</p></td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-1 h-6 p-1"><p class="text-center">5</p></td>
                                <td class="col-5 h-6 p-1"><p class="text-left">Alat angkutan / transpotasi yang digunakan</p></td>
                                <td class="col-6 h-6 p-1"><p class="text-left">Angkutan Darat</p></td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-1 h-6 p-1"><p class="text-center">6</p></td>
                                <td class="col-5 h-6 p-1">
                                    <p class="text-left m-0">a. Tempat berangkat</p>
                                    <p class="text-left m-0">b. Tempat tujuan</p>
                                </td>
                                <td class="col-6 h-6 p-1">
                                    <p class="text-left m-0">Golongan orang beriman</p>
                                    <p class="text-left m-0">Kepala Keluarga</p>
                                </td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-1 h-6 p-1"><p class="text-center">7</p></td>
                                <td class="col-5 h-6 p-1">
                                    <p class="text-left m-0">a. Lamanya Perjalanan Dinas</p>
                                    <p class="text-left m-0">b. Tanggal berangkat</p>
                                    <p class="text-left mb-1">c. Tanggal harus kembali/tiba di tempat baru*</p>
                                </td>
                                <td class="col-6 h-6 p-1">
                                    <p class="text-left m-0">1 Hari</p>
                                    <p class="text-left m-0">23 Agustus 2022</p>
                                    <p class="text-left mb-1">23 Agustus 2022</p>
                                </td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-1 h-6 p-1"><p class="text-center">8</p></td>
                                <td class="col-5 h-6 p-1"><p class="text-left">Pengikut: Nama</p></td>
                                <td class="col-3 h-6 p-1"><p class="text-center">Tanggal Lahir</p></td>
                                <td class="col-3 h-6 p-1"><p class="text-center">Keterangan</p></td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-1 h-6 p-1"><p class="text-center"></p></td>
                                <td class="col-5 h-6 p-1"><p class="text-left">1. </p></td>
                                <td class="col-3 h-6 p-1"><p class="text-left"></p></td>
                                <td class="col-3 h-6 p-1"><p class="text-left"></p></td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-1 h-6 p-1"><p class="text-center"></p></td>
                                <td class="col-5 h-6 p-1"><p class="text-left">2. </p></td>
                                <td class="col-3 h-6 p-1"><p class="text-left"></p></td>
                                <td class="col-3 h-6 p-1"><p class="text-left"></p></td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-1 h-6 p-1"><p class="text-center"></p></td>
                                <td class="col-5 h-6 p-1"><p class="text-left">3. </p></td>
                                <td class="col-3 h-6 p-1"><p class="text-left"></p></td>
                                <td class="col-3 h-6 p-1"><p class="text-left"></p></td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-1 h-6 p-1"><p class="text-center">9</p></td>
                                <td class="col-5 h-6 p-1">
                                    <p class="text-left m-0">Pembebanan anggaran</p>
                                    <p class="text-left m-0">a. Instansi</p>
                                    <p class="text-left mb-1">b. Akun</p>
                                </td>
                                <td class="col-6 h-6 p-1">
                                    <p class="text-left m-0"><br></p>
                                    <p class="text-left m-0">SMA Negeri 6 Cimahi</p>
                                    <p class="text-left mb-1">5.1.02.05.01</p>
                                </td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-1 h-6 p-1"><p class="text-center">10</p></td>
                                <td class="col-5 h-6 p-1"><p class="text-left">Keterangan lain lain</p></td>
                                <td class="col-6 h-6 p-1"><p class="text-left"></p></td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-1 h-6 p-1"></td>
                                <td class="col-5 h-6 p-1"><p class="text-left">* Coret yang tidak perlu</p></td>
                                <td class="col-6 h-6 p-1">
                                    <p></p>
                                    <p class="text-left mb-0">Dikeluarkan di: Kota Cimahi</p>
                                    <p class="text-left pl-5 mb-5">Tanggal: 22 Agustus 2022</p>
                                    <p class="text-center mb-5 font-weight-bold">Kepala SMA Negeri 6 Cimahi</p>
                                    <br/> <br/> <br/>
                                    <p class="text-center mb-0 font-weight-bold"><u>Drs. ADE SURATMAN, M.PD.</u></p>
                                    <p class="text-center">NIP. 196301141988031007</p>
                                </td>               
                            </tr>
                          </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->




















    <script src="{{ asset('template/admin/plugins/jquery/jquery.min.js') }}"></script>
    @yield('js')
    @include('admin.layouts.script')
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('template/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('template/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('template/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('template/admin/dist/js/adminlte.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('template/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Moment JS -->
    <script src="{{ asset('template/admin/plugins/moment/moment.min.js') }}"></script>
    <!--Tempus Dominus-->
    <script src="{{ asset('template/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    @stack('script')
</body>
</html>