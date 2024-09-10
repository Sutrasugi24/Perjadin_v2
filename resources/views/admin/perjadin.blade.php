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
                            @can('create perjadin')
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
                                            <th>Tujuan Kedua</th>
                                            <th>Tujuan Ketiga</th>
                                            <th>Angkutan</th>
                                            <th>Koordinator</th>
                                            <th>Anggota</th>
                                            @canany(['update perjadin', 'delete perjadin'])
                                                <th>Action</th>
                                            @endcanany
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $i)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ date('d-m-Y', strtotime($i->leave_date)) }}</td>
                                                <td>{{ date('d-m-Y', strtotime($i->return_date)) }}</td>
                                                <td>{{ $i->plan }}</td>
                                                <td>{{ $i->destination }}</td>
                                                <td>{{ $i->destination_two }}</td>
                                                <td>{{ $i->destination_three }}</td>
                                                <td>{{ ucfirst(trans($i->transport)) }}</td>
                                                @foreach($user as $id)
                                                    @if ($id->id == $i->coordinator)
                                                        <td>{{ $id->name }}</td>
                                                    @endif
                                                @endforeach
                                                <td>{{ $i->users()->get()->implode('name', ', ') }}</td>
                                                @canany(['update perjadin', 'delete perjadin'])
                                                    <td>
                                                        <div class="btn-group">
                                                            @can('update perjadin')
                                                                <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $i->id }}"><i class="fas fa-pencil-alt"></i></button>
                                                            @endcan
                                                            @can('delete perjadin')
                                                                <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $i->id }}" data-name="{{ $i->coordinator }}"><i class="fas fa-trash"></i></button>
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
                        $("#leave_date").val(data.leave_date);
                        $("#return_date").val(data.leave_date);
                        $("#plan").val(data.plan);
                        $("#destination").val(data.destination);
                        $("#destination_two").val(data.destination_two);
                        $("#destination_three").val(data.destination_three);
                        $("#transport").val(data.transport);
                        $("#coordinator").val(data.coordinator);
                        $("#description").val(data.description);
                        $("#members").val(data.members);
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
                theme: 'bootstrap4',
            });

            $("#single-edit").select2({
                dropDownParent: $("#modal-edit"),
                placeholder: "Pilih Koordinator",
                theme: 'bootstrap4'
            });

            $("#multiple-input").select2({
                dropDownParent: $("#modal-tambah"),
                placeholder: "Pilih Anggota",
                theme: 'bootstrap4',
                tags: true
            });
            
            $("#multiple-edit").select2({
                dropDownParent: $("#modal-edit"),
                placeholder: "Pilih Anggota",
                theme: 'bootstrap4',
                tags: true
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
                    <form action="{{ route('perjadin.store') }}" method="POST" enctype="multipart/form-data">
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
                            <label>Maksud Perjalanan Dinas</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('plan') is-invalid @enderror" placeholder="Maksud Perjalanan Dinas" name="plan" value="{{ old('plan') }}">
                                @error('plan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{--Start: Input destination --}}
                        <div class="input-group">
                            <label>Tempat Tujuan</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('destination') is-invalid @enderror" placeholder="Tempat Tujuan" name="destination" value="{{ old('destination') }}">
                                @error('destination')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End: Input destination --}}
                        {{--Start: Input destination --}}
                        <div class="input-group">
                            <label>Tempat Tujuan Kedua</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('destination_two') is-invalid @enderror" placeholder="Tempat Tujuan Kedua" name="destination_two" value="{{ old('destination_two') }}">
                                @error('destination_two')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End: Input destination --}}
                         {{--Start: Input destination --}}
                         <div class="input-group">
                            <label>Tempat Tujuan Ketiga</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('destination_three') is-invalid @enderror" placeholder="Tempat Tujuan Ketiga" name="destination_three" value="{{ old('destination_three') }}">
                                @error('destination_three')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End: Input destination --}}
                        {{--Start: Input destination --}}
                        <div class="input-group">
                            <label>Transport</label>
                            <div class="input-group">
                                <select class="form-control" name="transport">
                                    @foreach($transport as $i)
                                        <option value="{{ $i }}">{{ ucfirst(trans($i)) }}</option>
                                   @endforeach
                                </select>
                                @error('transport')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End: Input destination --}}
                        {{--Start: Input description --}}
                        <div class="input-group">
                            <label>Deskripsi</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('description') is-invalid @enderror" placeholder="Deskripsi" name="description" value="{{ old('description') }}">
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End: Input description --}}
                        {{--Start: Input koordinator --}}
                        <label>Koordinator</label>
                        <div class="input-group">
                            <select id="single-input" class="form-control js-states" name="coordinator">
                                <@foreach ($user as $i)
                                    <option value="{{ $i->id }}">{{ $i->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{--Start: Input koordinator --}}
                        <label>Anggota</label>
                        <div class="input-group">
                            <select id="multiple-input" multiple="multiple" data-placeholder="  Pilih Anggota" class="form-control js-states" name="members[]">
                                <@foreach ($user as $i)
                                    <option value="{{ $i->id }}">{{ $i->name }}</option>
                                @endforeach
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
                    <form action="{{ route('perjadin.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        {{-- Input leave date  --}}
                        <div class="input-group">
                            <label>Tanggal Pergi</label>
                            <div class="input-group">
                                <input type="date" class="form-control @error('leave_date') is-invalid @enderror" id="leave_date" name="leave_date" value="{{ old('leave_date') }}">
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
                                <input type="date" class="form-control @error('return_date') is-invalid @enderror" id="return_date" name="return_date" value="{{ old('return_date') }}">
                                @error('return_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End Input date --}}
                        <div class="input-group">
                            <label>Maksud Perjalanan Dinas</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('plan') is-invalid @enderror" placeholder="Maksud Perjalanan Dinas" id="plan" name="plan" value="{{ old('plan') }}">
                                @error('plan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{--Start: Input destination --}}
                        <div class="input-group">
                            <label>Tempat Tujuan</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('destination') is-invalid @enderror" placeholder="Tempat Tujuan" id="destination" name="destination" value="{{ old('destination') }}">
                                @error('destination')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End: Input destination --}}
                        {{--Start: Input destination --}}
                        <div class="input-group">
                            <label>Tempat Tujuan Kedua</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('destination_two') is-invalid @enderror" placeholder="Tempat Tujuan Kedua" id="destination_two" name="destination_two" value="{{ old('destination_two') }}">
                                @error('destination_two')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End: Input destination --}}
                        {{--Start: Input destination --}}
                        <div class="input-group">
                            <label>Tempat Tujuan Ketiga</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('destination_three') is-invalid @enderror" placeholder="Tempat Tujuan Ketiga" id="destination_three" name="destination_three" value="{{ old('destination_three') }}">
                                @error('destination_three')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End: Input destination --}}
                        {{--Start: Input destination --}}
                        <div class="input-group">
                            <label>Transport</label>
                            <div class="input-group">
                                <select class="form-control" id="transport" name="transport">
                                    @foreach($transport as $i)
                                        <option {{ $data }}  value="{{ $i }}">{{ ucfirst(trans($i))}}</option>
                                    @endforeach
                                </select>
                                @error('transport')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End: Input destination --}}
                        {{--Start: Input description --}}
                        <div class="input-group">
                            <label>Deskripsi</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('description') is-invalid @enderror" placeholder="Deskripsi" id="description" name="description" value="{{ old('description') }}">
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- End: Input description --}}
                        {{--Start: Input koordinator --}}
                        <label>Koordinator</label>
                        <div class="input-group">
                            <select id="single-edit" class="form-control js-states" name="coordinator" id="coordinator">
                                <@foreach ($user as $i)
                                    <option value="{{ $i->id }}">{{ $i->name }}</option>
                                @endforeach
                            </select>
                            @error('coordinator')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- End: Input koordinator --}}
                        {{--Start: Input koordinator --}}
                        <label>Anggota</label>
                        <div class="input-group">
                            <select id="multiple-edit" multiple="multiple" data-placeholder="  Pilih Anggota" class="form-control js-states" name="members[]">
                                <@foreach ($user as $i)
                                    <option value="{{ $i->id }}">{{ $i->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- End: Input Anggota --}}
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
                    <form action="{{ route('perjadin.destroy') }}" method="POST" enctype="multipart/form-data">
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
