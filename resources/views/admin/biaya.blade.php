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
                                            <th>Jenis</th>
                                            <th>Biaya</th>
                                            @canany(['update surat', 'delete surat'])
                                                <th>Action</th>
                                            @endcanany
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $i)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $i->type }}</td>
                                                <td>{{ $i->cost }}</td>
                                            @canany(['update biaya', 'delete biaya'])
                                                    <td>
                                                        <div class="btn-group">
                                                            @can('update biaya')
                                                                <button class="btn btn-sm btn-primary btn-edit" title="Ubah Data!" data-id="{{ $i->id }}"><i class="fas fa-pencil-alt"></i></button>
                                                            @endcan
                                                            @can('delete biaya')
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
    {{-- <script>
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
                        $("#id_perjadin").val(data.perjadin_id);
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
        });
    </script> --}}
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
                        <div class="input-group">
                            <label>Tipe</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('document_number') is-invalid @enderror" placeholder="Nomor Surat" name="document_number" value="{{ old('document_number') }}">
                                @error('document_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Input leave date  --}}
                        <div class="input-group">
                            <label>Biaya</label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('document_date') is-invalid @enderror" id="document_date" name="document_date" value="{{ old('document_date') }}">
                                @error('document_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End Input date --}}
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
    {{-- <div class="modal fade" id="modal-edit">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="input-group">
                            <label>Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name" id="name" value="{{ old('name') }}">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="input-group">
                            <label>Email</label>
                            <div class="input-group">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" id="email" value="{{ old('email') }}">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="input-group">
                            <label>Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" value="{{ old('password') }}">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="input-group">
                            <label>NIP</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" placeholder="NIP" name="nip" id="nip" value="{{ old('nip') }}">
                                @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="input-group">
                            <label>NIPS</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('nips') is-invalid @enderror" placeholder="NIPS" name="nips" id="nips" value="{{ old('nips') }}">
                                @error('nips')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="input-group">
                            <label>Jabatan</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('jabatan') is-invalid @enderror" placeholder="Jabatan" name="jabatan" id="jabatan" value="{{ old('jabatan') }}">
                                @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="input-group">
                            <label>Golongan</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('golongan') is-invalid @enderror" placeholder="Golongan" name="golongan" id="golongan" value="{{ old('golongan') }}">
                                @error('golongan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="input-group">
                            <label>Role</label>
                            <div class="input-group">
                                <select class="form-control" name="role" id="role">
                                    @foreach ($role as $i)
                                        <option value="{{ $i->name }}">{{ $i->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
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
    </div> --}}
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
                    <form action="{{ route('user.destroy') }}" method="POST" enctype="multipart/form-data">
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