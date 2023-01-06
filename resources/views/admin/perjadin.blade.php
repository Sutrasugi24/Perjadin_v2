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
                                    <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-tambah" data-backdrop="static" data-keyboard="false"><i class="fas fa-plus"></i> Tambah</a>
                                </h3>
                            </div>
                            @endcan
                            <!-- /.card-header -->
                            <div class="card-body table-responsive">
                                <table class="table table-bordered table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal Pergi</th>
                                            <th>Tanggal Pulang</th>
                                            <th>Maksud</th>
                                            <th>Tujuan</th>
                                            <th>Keterangan</th>
                                            <th>Angkutan</th>
                                            <th>Koordinator</th>
                                            @canany(['update perjadin', 'delete perjadin'])
                                                <th>Action</th>
                                            @endcanany
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $i)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $i->leave_date }}</td>
                                                <td>{{ $i->return_date }}</td>
                                                <td>{{ $i->plan }}</td>
                                                <td>{{ $i->destination }}</td>
                                                <td>{{ $i->description }}</td>
                                                <td>{{ $i->transport }}</td>
                                                <td>{{ $i->coordinator }}</td>
                                            @canany(['update perjadin', 'delete perjadin'])
                                                    <td>
                                                        <div class="btn-group">
                                                            @can('update perjadin')
                                                                <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $i->id }}"><i class="fas fa-pencil-alt"></i></button>
                                                            @endcan
                                                            @can('delete perjadin')
                                                                <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $i->id }}" data-name="{{ $i->name }}"><i class="fas fa-trash"></i></button>
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
                    url: "{{ route('perjadin.show') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        var data = data.data;
                        $("#name").val(data.name);
                        $("#email").val(data.email);
                        $("#old_email").val(data.email);
                        $("#role").val(data.role);
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

            $("#single-input").select2({
                dropDownParent: $("#modal-tambah"),
                placeholder: "Pilih Koordinator",
                theme: 'bootstrap4'
            });

            $("#multiple-input").select2({
                dropDownParent: $("#modal-tambah"),
                placeholder: "Pilih Anggota",
                theme: 'bootstrap4',
            });
            $('.select2-search__field').css('width', '100%');
        });
    </script>
@endsection

@section('modal')
    {{-- Modal tambah --}}
    <div class="modal fade" id="modal-tambah" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Input leave date  --}}
                        <div class="input-group">
                            <label>Tanggal Pergi</label>
                            <div class="input-group">
                                <input type="date" class="form-control @error('leave_date') is-invalid @enderror" placeholder="dd-mm-yyyy" name="leave_date" value="{{ old('leave_date') }}">
                                @error('leave_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End Input date --}}
                        {{-- Input leave date  --}}
                        <div class="input-group">
                            <label>Tanggal Kembali</label>
                            <div class="input-group">
                                <input type="date" class="form-control @error('return_date') is-invalid @enderror" placeholder="dd-mm-yyyy" name="return_date" value="{{ old('return_date') }}">
                                @error('return_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End Input date --}}
                        <div class="input-group">
                            <label>Tujuan</label>
                            <div class="input-group">
                                <input type="string" class="form-control @error('plan') is-invalid @enderror" placeholder="Maksud" name="plan" value="{{ old('plan') }}">
                                @error('plan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{--Start: Input destination --}}
                        <div class="input-group">
                            <label>Tempat Tujuan</label>
                            <div class="input-group">
                                <input type="string" class="form-control @error('plan') is-invalid @enderror" placeholder="Tempat Tujuan" name="destination" value="{{ old('destination') }}">
                                @error('destination')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End: Input destination --}}
                        {{--Start: Input destination --}}
                        {{-- <div class="input-group">
                            <label>Transport</label>
                            <div class="input-group">
                                <select class="form-control" name="transport">
                                    @foreach ($data->users as $i)
                                        <option value="{{ $i->transport }}">{{ $i->transport }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}
                        {{-- End: Input destination --}}
                        {{--Start: Input description --}}
                        <div class="input-group">
                            <label>Deskripsi</label>
                            <div class="input-group">
                                <input type="string" class="form-control @error('description') is-invalid @enderror" placeholder="Deskripsi" name="description" value="{{ old('description') }}">
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End: Input description --}}
                        {{--Start: Input koordinator --}}
                        <label>Koordinator</label>
                        <div class="input-group">
                            <select id="single-input" class="form-control js-states">
                                <option></option>
                                <option>Shugi</option>
                                <option>Superadmin</option>
                            </select>
                        </div>
                        {{-- End: Input koordinator --}}
                        {{--Start: Input koordinator --}}
                        <label>Anggota</label>
                        <div class="input-group">
                            <select id="multiple-input" multiple="multiple" data-placeholder="  Pilih Anggota" class="form-control js-states">
                                <option>Shugi</option>
                                <option>Superadmin</option>
                            </select>
                        </div>
                        {{-- End: Input Anggota --}}
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
                    <input type="hidden" name="old_email" id="old_email">
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