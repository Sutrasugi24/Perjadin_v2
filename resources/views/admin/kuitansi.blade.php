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
                            @can('create kuitansi')
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
                                            <th>Nomor Kuitansi</th>
                                            <th>Tanggal Kuitansi</th>
                                            <th>ID Perjadin</th>
                                            <th>Biaya</th>
                                            @canany(['update kuitansi', 'delete kuitansi'])
                                                <th>Action</th>
                                            @endcanany
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $i)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $i->kuitansi_number }}</td>
                                                <td>{{ date('j \\ F Y', strtotime($i->kuitansi_date)) }}</td>
                                                <td>{{ $i->perjadin->id }} - {{ $i->perjadin->plan}} ({{ date('j \\ F Y', strtotime($i->perjadin->leave_date)) }})</td>
                                                <td>{{ $i->formatRupiah('cost_total') }}</td>
                                            @canany(['update kuitansi', 'delete kuitansi'])
                                                    <td>
                                                        <div class="btn-group">
                                                            @can('update kuitansi')
                                                                <button class="btn btn-sm btn-primary btn-edit" title="Ubah Data!" data-id="{{ $i->id }}"><i class="fas fa-pencil-alt"></i></button>
                                                            @endcan
                                                            @can('delete kuitansi')
                                                                <button class="btn btn-sm btn-danger btn-delete" title="Hapus Data!" data-id="{{ $i->id }}" data-name="{{ $i->document_number }}"><i class="fas fa-trash"></i></button>
                                                            @endcan
                                                            @can('read kuitansi')
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
                    url: "{{ route('kuitansi.show') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        var data = data.data;
                        $("#document_number").val(data.kuitansi_number);
                        $("#document_date").val(data.kuitansi_date);
                        $("#id_perjadin").val(data.perjadin_id);
                        $("#id_biaya").val(data.biaya_id);
                        $("#id").val(data.id);
                        $('#modal-loading').modal('hide');
                        $('#modal-edit').modal({backdrop: 'static', keyboard: false, show: true});
                    },
                });
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

            $("#biaya_id").select2({
                dropDownParent: $("#modal-tambah"),
                placeholder: "Pilih Kegiatan",
                theme: 'bootstrap4'
            });

            $("#biaya_id").select2({
                dropDownParent: $("#modal-edit"),
                placeholder: "Pilih Kegiatan",
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
                    <form action="{{ route('kuitansi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{--Start: Input Document Number --}}
                        <div class="input-group">
                            <label>Nomor Kuitansi</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('kuitansi_number') is-invalid @enderror" placeholder="Nomor Kuitansi" name="kuitansi_number" value="{{ old('kuitansi_number') }}">
                                @error('kuitansi_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End: Input Document Number --}}
                        {{-- Input leave date  --}}
                        <div class="input-group">
                            <label>Tanggal Kuitansi</label>
                            <div class="input-group">
                                <input type="date" class="form-control @error('kuitansi_date') is-invalid @enderror" placeholder="dd-mm-yyyy" name="kuitansi_date" value="{{ old('kuitansi_date') }}">
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

                        {{-- End biaya date --}}
                        <div class="input-group">
                            <label>Jenis Kegiatan</label>
                            <div class="input-group">
                                <select id="biaya_id" class="form-control" name="biaya_id">
                                    @foreach ($biaya as $i)
                                        <option value="{{ $i->id }}">{{ $i->type }}</option>
                                    @endforeach
                                </select>
                                @error('biaya_id')
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
                    <form action="{{ route('kuitansi.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        {{--Start: Input Document Number --}}
                        <div class="input-group">
                            <label>Nomor Kuitansi</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('kuitansi_number') is-invalid @enderror" id="document_number" placeholder="Nomor Kuitansi" name="kuitansi_number" value="{{ old('kuitansi_number') }}">
                                @error('kuitansi_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End: Input Document Number --}}
                        {{-- Input leave date  --}}
                        <div class="input-group">
                            <label>Tanggal Kuitansi</label>
                            <div class="input-group">
                                <input type="date" class="form-control @error('kuitansi_date') is-invalid @enderror" id="document_date" placeholder="dd-mm-yyyy" name="kuitansi_date" value="{{ old('kuitansi_date') }}">
                                @error('document_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End Input date --}}
                        <div class="input-group">
                            <label>ID Perjadin</label>
                            <div class="input-group">
                                <select id="perjadin_id" class="form-control" id="id_perjadin" name="perjadin_id">
                                    @foreach ($perjadin as $i)
                                        <option value="{{ $i->id }}">{{ $i->id }} - {{ $i->plan }}</option>
                                    @endforeach
                                </select>
                                @error('perjadin_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- End biaya date --}}
                        <div class="input-group">
                            <label>Jenis Kegiatan</label>
                            <div class="input-group">
                                <select id="biaya_id" class="form-control" id="id_biaya" name="biaya_id">
                                    @foreach ($biaya as $i)
                                        <option value="{{ $i->id }}">{{ $i->type }}</option>
                                    @endforeach
                                </select>
                                @error('biaya_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
                    <form action="{{ route('kuitansi.destroy') }}" method="POST" enctype="multipart/form-data">
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
@endsection