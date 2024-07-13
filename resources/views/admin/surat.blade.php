@extends('admin.layouts.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $title }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            @can('create user')
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-tambah" data-backdrop="static" data-keyboard="false">Tambah <i class="fas fa-plus"></i></a>
                                </h3>
                            </div>
                            @endcan
                            <!-- /.card-header -->
                            <div class="card-body table-responsive">
                                <table class="table table-bordered table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nomor Surat</th>
                                            <th>Tanggal Surat</th>
                                            <th>ID Perjadin</th>
                                            @canany(['update surat', 'delete surat'])
                                                <th>Action</th>
                                            @endcanany
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $i)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $i->document_number }}</td>
                                                <td>{{ date('j \\ F Y', strtotime($i->document_date)) }}</td>
                                                <td>{{ $i->perjadin->id }} - {{ $i->perjadin->plan}} ({{ date('j \\ F Y', strtotime($i->perjadin->leave_date)) }})</td>
                                            @canany(['update surat', 'delete surat'])
                                                    <td>
                                                        <div class="btn-group">
                                                            @can('read surat')
                                                                <a href="{{route('surat.download', $i->id )}}"class="btn btn-sm btn-warning btn-print" title="Cetak Surat!"><i class="fas fa-envelope"></i></a>
                                                            @endcan
                                                            @can('read surat')
                                                                <a href="{{route('surat.rincian', $i->id )}}"class="btn btn-sm btn-warning btn-print" title="Cetak Rincian Biaya!"><i class="fas fa-dollar-sign"></i></a>
                                                            @endcan
                                                            @can('read surat')
                                                                <a href="{{route('surat.pembayaran', $i->id )}}"class="btn btn-sm btn-warning btn-print" title="Cetak Daftar Pembayaran!"><i class="fas fa-file-contract"></i></a>
                                                            @endcan
                                                            @can('update surat')
                                                                <button class="btn btn-sm btn-primary btn-edit" title="Ubah Data!" data-id="{{ $i->id }}"><i class="fas fa-pencil-alt"></i></button>
                                                            @endcan
                                                            @can('delete surat')
                                                                <button class="btn btn-sm btn-danger btn-delete" title="Hapus Data!" data-id="{{ $i->id }}" data-name="{{ $i->document_number }}"><i class="fas fa-trash"></i></button>
                                                            @endcan
                                                        </div>
                                                    </td>
                                                @endcanany
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('js')
    <script>
         $(document).ready(function() {
            $(document).on("click", '.btn-edit', function() {
                let id = $(this).attr("data-id");
                $('#modal-loading').modal({backdrop: 'static', keyboard: false, show: true});

                $.ajax({
                    url: "{{ route('surat.show') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        var data = data.data;
                        $("#document_number").val(data.document_number);
                        $("#document_date").val(data.document_date);
                        $("#perjadin_id").val(data.perjadin_id);
                        $("#id").val(data.id);
                        $('#modal-loading').modal('hide');
                        $('#modal-edit').modal({backdrop: 'static', keyboard: false, show: true});
                    },
                });
            });


            $(document).on("click", '.btn-print', function() {
                let id = $(this).attr("data-id");
                let perjadinId = $(this).attr("data-perjadin");
                $("#did").val(id);
                $("#perjadin-id").val(perjadinId);
                $("#print-perjadin").html(perjadinId);
                $('#modal-print').modal({backdrop: 'static', keyboard: false, show: true});
            });

            
            $(document).on("click", '.btn-delete', function() {
                let id = $(this).attr("data-id");
                let name = $(this).attr("data-name");
                $("#did").val(id);
                $("#delete-data").html(name);
                $('#modal-delete').modal({backdrop: 'static', keyboard: false, show: true});
            });

            $("#perjadin_id").select2({
                dropDownParent: $("#modal-tambah"),
                placeholder: "Pilih ID",
                theme: 'bootstrap4'
            });

            $("#perjadin_id").select2({
                dropDownParent: $("#modal-edit"),
                placeholder: "Pilih ID",
                theme: 'bootstrap4'
            });
            $('.select2-search__field').css('width', '100%');
        });
    </script>
@endsection

@section('modal')
    {{-- Modal tambah --}}
    <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{--Start: Input Document Number --}}
                        <div class="input-group">
                            <label>Nomor Surat</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('document_number') is-invalid @enderror" placeholder="Nomor Surat" name="document_number" value="{{ old('document_number') }}">
                                @error('document_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End: Input Document Number --}}
                        {{-- Input leave date  --}}
                        <div class="input-group">
                            <label>Tanggal Surat</label>
                            <div class="input-group">
                                <input type="date" class="form-control @error('document_date') is-invalid @enderror" placeholder="dd-mm-yyyy" name="document_date" value="{{ old('document_date') }}">
                                @error('document_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End Input date --}}
                        <div class="input-group">
                            <label>ID Perjadin</label>
                            <div class="input-group">
                                <select id="perjadin_id" class="form-control" name="perjadin_id">
                                    @foreach ($perjadin as $i)
                                        <option value="{{ $i->id }}">{{ $i->id }} - {{ $i->plan }}</option>
                                    @endforeach
                                </select>
                                @error('perjadin_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- Modal Update --}}
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('surat.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        {{-- Input leave date  --}}
                        <div class="input-group">
                            <label>Nomor Surat</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('document_number') is-invalid @enderror" id="document_number" name="document_number" value="{{ old('document_number') }}">
                                @error('document_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Input leave date  --}}
                        <div class="input-group">
                            <label>Tanggal Surat</label>
                            <div class="input-group">
                                <input type="date" class="form-control @error('document_date') is-invalid @enderror" id="document_date" name="document_date" value="{{ old('document_date') }}">
                                @error('document_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End Input date --}}
                        {{--Start: Input koordinator --}}
                        <label>ID Perjadin</label>
                        <div class="input-group">
                            <select id="perjadin_id" class="form-control js-states" name="perjadin_id" id="perjadin_id">
                                <@foreach ($perjadin as $i)
                                    <option value="{{ $i->id }}">{{ $i->id }} - {{ $i->plan }} ({{ date('j \\ F Y', strtotime($i->leave_date)) }})</option>
                                @endforeach
                            </select>
                            @error('perjadin_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" name="id" id="id">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- Modal delete --}}
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hapus Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('surat.destroy') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <p class="modal-text">Apakah anda yakin akan menghapus? <b id="delete-data"></b></p>
                        <input type="hidden" name="id" id="did">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- Modal Unduh --}}
    {{-- <div class="modal fade" id="modal-print">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Unduh data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('surat.download') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <p class="modal-text">Apakah anda yakin akan mengunduh data? <b id="print-perjadin"></b></p>
                        <input type="hidden" name="id" id="did">
                        <input type="hidden" name="id-perjadin" id="perjadin-id">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Unduh</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div> --}}
@endsection