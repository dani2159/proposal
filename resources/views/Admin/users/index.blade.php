@extends('Template.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#insertModal"><span class="fa fa-plus"></span> Tambah User</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table" id="tableData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Level</th>
                                <th>Username</th>
                                <th>Ormawa</th>
                                <th>Tanggal Dibuat</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{!! "<span class='badge badge-info'>".$item->level."</span>" !!}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->id_ormawa ? $item->ormawa->nama : '-' }}</td>
                                    <td>{{ $item->created_at ? date('d F Y', strtotime($item->created_at)) : '-' }}</td>
                                    <td>
                                        <button onclick="ubahData({{ $item }})" class="btn btn-warning btn-sm"><span class="fa fa-pencil-alt"></span></button>
                                        <button onclick="hapusData({{ $item->id }})" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertModalLabel">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:void(0)" method="POST" id="formInsert">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama"><span class="text-danger">*</span> Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Isikan nama" required>
                        </div>
                        <div class="form-group">
                            <label for="username"><span class="text-danger">*</span> Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Isikan username" required>
                        </div>
                        <div class="form-group">
                            <label for="password"><span class="text-danger">*</span> Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Isikan password" required>
                        </div>
                        <div class="form-group">
                            <label for="level"><span class="text-danger">*</span> Level</label>
                            <select name="level" id="level" class="form-control" required onchange="getOrmawa(this)">
                                <option value="">-- Pilih Level --</option>
                                <option value="admin_mhs">Admin Mahasiswa</option>
                                <option value="bem">BEM</option>
                                <option value="ormawa">Ormawa</option>
                            </select>
                        </div>
                        <div class="form-group" id="componentOrmawa" style="display: none">
                            <label for="id_ormawa"><span class="text-danger">*</span> Ormawa</label>
                            <select name="id_ormawa" id="id_ormawa" class="form-control">
                                <option value="">-- Pilih Level --</option>
                                @foreach ($ormawa as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Ubah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:void(0)" method="POST" id="formUpdate">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" id="id" required>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namaUpdate"><span class="text-danger">*</span> Nama</label>
                            <input type="text" class="form-control" id="namaUpdate" name="nama" placeholder="Isikan nama" required>
                        </div>
                        <div class="form-group">
                            <label for="usernameUpdate"><span class="text-danger">*</span> Username</label>
                            <input type="text" class="form-control" id="usernameUpdate" name="username" placeholder="Isikan username" required>
                        </div>
                        <div class="form-group">
                            <label for="passwordUpdate">Password <span class="text-danger" style="font-size: 10px">Kosongkan jika tidak akan mengubah password</span></label>
                            <input type="password" class="form-control" id="passwordUpdate" name="password" placeholder="Isikan password">
                        </div>
                        <div class="form-group">
                            <label for="levelUpdate"><span class="text-danger">*</span> Level</label>
                            <select name="level" id="levelUpdate" class="form-control" required onchange="getOrmawaUpdate(this)">
                                <option value="">-- Pilih Level --</option>
                                <option value="admin_mhs">Admin Mahasiswa</option>
                                <option value="bem">BEM</option>
                                <option value="ormawa">Ormawa</option>
                            </select>
                        </div>
                        <div class="form-group" id="componentOrmawaUpdate" style="display: none">
                            <label for="id_ormawaUpdate"><span class="text-danger">*</span> Ormawa</label>
                            <select name="id_ormawa" id="id_ormawaUpdate" class="form-control">
                                <option value="">-- Pilih Level --</option>
                                @foreach ($ormawa as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  @endsection

  @section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tableData').DataTable({
                order: [
                    [0, "asc"]
                ],
                columnDefs: [{
                    "targets": 6,
                    "orderable": false
                }]
            });

            $('#formInsert').on('submit', (function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.user.insert') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data, status, xhr) {
                        try {
                            var result = JSON.parse(xhr.responseText);
                            if (result.status) {
                                swal(result.message, {
                                    icon: "success",
                                    title: "Success",
                                    text: result.message,
                                }).then((acc) => {
                                    location.reload();
                                });
                            } else {
                                swal("Warning!", result.message, "warning");
                            }
                        } catch (e) {
                            swal("Warning!", "Terjadi kesahalan sistem", "error");
                        }
                    },
                    error: function(data) {
                        swal("Warning!", "Terjadi kesahalan sistem", "error");
                    }
                });
            }));
            
            $('#formUpdate').on('submit', (function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.user.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data, status, xhr) {
                        try {
                            var result = JSON.parse(xhr.responseText);
                            if (result.status) {
                                swal(result.message, {
                                    icon: "success",
                                    title: "Success",
                                    text: result.message,
                                }).then((acc) => {
                                    location.reload();
                                });
                            } else {
                                swal("Warning!", result.message, "warning");
                            }
                        } catch (e) {
                            swal("Warning!", "Terjadi kesahalan sistem", "error");
                        }
                    },
                    error: function(data) {
                        swal("Warning!", "Terjadi kesahalan sistem", "error");
                    }
                });
            }));
        });

        function getOrmawa(val) {
            if (val.value == 'ormawa') {
                $('#componentOrmawa').show()
                $("#id_ormawa").prop('required',true);
            } else {
                $('#componentOrmawa').hide()
                $("#id_ormawa").prop('required',false);
            }
        }

        function getOrmawaUpdate(val) {
            if (val.value == 'ormawa') {
                $('#componentOrmawaUpdate').show()
                $("#id_ormawaUpdate").prop('required',true);
            } else {
                $('#componentOrmawaUpdate').hide()
                $("#id_ormawaUpdate").prop('required',false);
            }
        }

        function hapusData(id) {
            swal({
                title: "Apakah anda yakin ?",
                text: "Ketika data telah dihapus, tidak bisa dikembalikan lagi!",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        method: 'DELETE',
                        url: "{{ route('admin.user.delete') }}",
                        data: {
                            id
                        },
                        success: function(data, status, xhr) {
                            try {
                                var result = JSON.parse(xhr.responseText);
                                if (result.status) {
                                    swal(result.message, {
                                        icon: "success",
                                    }).then((acc) => {
                                        location.reload();
                                    });
                                } else {
                                    swal("Warning!", "Terjadi kesalahan sistem", "warning");
                                }
                            } catch (e) {
                                swal("Warning!", "Terjadi kesalahan sistem", "error");
                            }
                        },
                        error: function(data) {
                            swal("Warning!", "Terjadi kesalahan sistem", "error");
                        }
                    });
                }
            });
        }

        function ubahData(item) {
            $('#id').val(item.id);
            $('#namaUpdate').val(item.nama);
            $('#levelUpdate').val(item.level).change();
            $('#usernameUpdate').val(item.username);
            $('#id_ormawaUpdate').val(item.id_ormawa);
            $('#updateModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    </script>
  @endsection