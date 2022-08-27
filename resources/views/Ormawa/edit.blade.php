@extends('Template.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Ubah Pengajuan Proposal</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    
    <div class="content">
      <div class="container-fluid">
        <div class="card">
          <form action="javascript:void(0)" method="POST" id="formInsert">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" id="id" value="{{ $item->id }}" required>
            <div class="card-body">
              <div class="form-group">
                <label for="nama_kegiatan"><span class="text-danger">*</span> Nama Kegiatan</label>
                <input type="text" class="form-control" name="nama_kegiatan" value="{{ $item->nama_kegiatan }}" id="nama_kegiatan" required placeholder="Masukan nama kegiatan">
              </div>
              <div class="form-group">
                <label for="jenis_kegiatan"><span class="text-danger">*</span> Jenis Kegiatan</label>
                <input type="text" id="jenis_kegiatan" class="form-control" value="{{ $item->jenis_kegiatan }}" name="jenis_kegiatan" required placeholder="Masukan jenis kegiatan">
              </div>
              <div class="form-group">
                <label for="tema_kegiatan"><span class="text-danger">*</span> Tema Kegiatan</label>
                <input type="text" id="tema_kegiatan" class="form-control" value="{{ $item->tema_kegiatan }}" name="tema_kegiatan" required placeholder="Masukan tema kegiatan">
              </div>
              <div class="form-group">
                <label for="tanggal_kegiatan"><span class="text-danger">*</span> Waktu Kegiatan</label>
                <input type="datetime-local" id="tanggal_kegiatan" class="form-control" value="{{ $item->tanggal_kegiatan }}" name="tanggal_kegiatan" required placeholder="Masukan tema kegiatan">
              </div>
              <div class="form-group">
                <label for="total_dana"><span class="text-danger">*</span> Total Dana</label>
                <input type="number" id="total_dana" value="{{ $item->total_dana }}" class="form-control" name="total_dana" required placeholder="Masukan Total Dana">
              </div>
              <div class="form-group">
                <label for="userfile">Lampiran (File: <a href="{{ asset('data_proposal/'.$item->lampiran) }}">{{ $item->lampiran }}</a>)</label>
                <input type="file" class="form-control" accept="application/pdf,application/msword,
                application/vnd.openxmlformats-officedocument.wordprocessingml.document" name="userfile" id="userfile">
              </div>
            </div>
            <div class="card-footer">
              <div class="float-right">
                <a href="{{ route('list-pengajuan-ormawa') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </div>
          </form>
        </div>
        </div>
      </div>
    </div>
  @endsection

  @section('script')
      <script>
        $(document).ready(function() {
          $('#formInsert').on('submit', (function(e) {
              e.preventDefault();
              var formData = new FormData(this);
              $.ajax({
                  type: 'POST',
                  url: "{{ route('update-pengajuan-ormawa') }}",
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
                              window.location = "{{ route('list-pengajuan-ormawa') }}"
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
      </script>
  @endsection