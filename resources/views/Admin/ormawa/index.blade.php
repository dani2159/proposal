@extends('Template.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Ormawa</h1>
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
                        <button class="btn btn-primary" data-toggle="modal" data-target="#insertModal"><span class="fa fa-plus"></span> Tambah Ormawa</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table" id="tableData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Ketua</th>
                                <th>Keterangan</th>
                                <th>Tanggal Dibuat</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->ketua }}</td>
                                    <td>{{ $item->keterangan }}</td>
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
                    <h5 class="modal-title" id="insertModalLabel">Tambah Ormawa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:void(0)" method="POST" id="formInsert">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama"><span class="text-danger">*</span> Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Isikan nama ormawa" required>
                        </div>
                        <div class="form-group">
                            <label for="ketua"><span class="text-danger">*</span> Ketua</label>
                            <input type="text" class="form-control" id="ketua" name="ketua" placeholder="Isikan ketua ormawa" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan"><span class="text-danger">*</span> Keterangan</label>
                            <textarea name="keterangan" id="keterangan" cols="30" rows="3" class="form-control" placeholder="Isikan keterangan ormawa" required></textarea>
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
                    <h5 class="modal-title" id="updateModalLabel">Ubah Ormawa</h5>
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
                            <input type="text" class="form-control" id="namaUpdate" name="nama" placeholder="Isikan nama ormawa" required>
                        </div>
                        <div class="form-group">
                            <label for="ketuaUpdate"><span class="text-danger">*</span> Ketua</label>
                            <input type="text" class="form-control" id="ketuaUpdate" name="ketua" placeholder="Isikan ketua ormawa" required>
                        </div>
                        <div class="form-group">
                            <label for="keteranganUpdate"><span class="text-danger">*</span> Keterangan</label>
                            <textarea name="keterangan" id="keteranganUpdate" cols="30" rows="3" class="form-control" placeholder="Isikan keterangan ormawa" required></textarea>
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
                    "targets": 5,
                    "orderable": false
                }]
            });

            $('#formInsert').on('submit', (function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.ormawa.insert') }}",
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
                    url: "{{ route('admin.ormawa.update') }}",
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
                        url: "{{ route('admin.ormawa.delete') }}",
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
            $('#ketuaUpdate').val(item.ketua);
            $('#keteranganUpdate').val(item.keterangan);
            $('#updateModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    </script>
  @endsection