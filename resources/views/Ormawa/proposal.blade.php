@extends('Template.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pengajuan Proposal</h1>
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
                  <div class="card-tools">
                      <a href="{{route('tambah-pengajuan')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Buat Proposal</a>
                  </div>  
              </div>
              <div class="card-body">
                <table class="table table-bordered" id="tableData">
                  <thead>
                    <tr>
                        <th>#</th>
                        <th>Ormawa</th>
                        <th>Nama Kegiatan</th>
                        <th>Jenis Kegiatan</th>
                        <th>Tema Kegiatan</th>
                        <th>Tanggal Kegiatan</th>
                        <th>Total Dana</th>
                        <th>Status</th>
                        <th>Lampiran</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $key => $item )
                      @php
                          $status = "<span class='badge badge-warning'>Menunggu</span>";
                          
                          if ($item->status == 1) {
                            $status = "<span class='badge badge-success'>Disetujui</span>";
                          } else if($item->status == 2) {
                            $status = "<span class='badge badge-danger'>Ditolak</span>";
                          }

                      @endphp
                        <tr>
                            <td>{{$key + 1}} </td>
                            <td>{{$item->ormawa->nama}} </td>
                            <td>{{$item->nama_kegiatan}} </td>
                            <td>{{$item->jenis_kegiatan}} </td>
                            <td>{{$item->tema_kegiatan}} </td>
                            <td>{{$item->tanggal_kegiatan}} </td>
                            <td>{{ Global_lib::rupiah($item->total_dana) }}</td>
                            <td>{!! $status !!}</td>
                            <td>
                              <a target="_blank" href="{{ asset('data_proposal/'.$item->lampiran) }}">
                                {{$item->lampiran}}
                              </a>
                            </td>
                            <td>
                              @if ($item->status == 2)
                                <a href="{{ route('pengajuanUlang', ['id' => $item->id]) }}" class="btn btn-danger btn-sm btn-block">Ajukan Ulang</a>  
                              @endif
                              @if ($item->status == 0)
                                <a href="{{ route('ubah-pengajuan', ['id' => $item->id]) }}" class="btn btn-warning btn-sm btn-block">Edit</a>  
                              @endif
                              @if ($item->status == 1)
                                @if ($item->lampiran_lpj)
                                  <a href="{{ asset('data_lpj/'.$item->lampiran_lpj) }}" download class="btn btn-info btn-sm btn-block">Download LPJ</a>      
                                @else
                                  <button class="btn btn-primary btn-sm btn-block" onclick="kirimLpj({{ $item->id }})">Lampirkan LPJ</button>    
                                @endif
                              @endif
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

  <div class="modal fade" id="lpjModal" tabindex="-1" aria-labelledby="lpjModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="lpjModalLabel">Lampiran Laporan Pertanggung Jawaban</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="javascript:void(0)" method="POST" id="insertLPJ">
          <input type="hidden" name="id" id="id">
          <div class="modal-body">
            <div class="form-group">
              <label for="userfile"><span class="text-danger">*</span> File LPJ</label>
              <input type="file" class="form-control" name="userfile" id="userfile" accept="application/pdf,application/msword,
              application/vnd.openxmlformats-officedocument.wordprocessingml.document" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Kirim LPJ</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endsection

  @section('script')
      <script>
        $(document).ready(function() {
            $('#tableData').DataTable({
                order: [
                    [0, "asc"]
                ],
                columnDefs: [{
                    "targets": 9,
                    "orderable": false
                }]
            });

            $('#insertLPJ').on('submit', (function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('lampiran.lpj') }}",
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

        function kirimLpj(id) {
          $('#id').val(id);
          $('#lpjModal').modal({
              backdrop: 'static',
              keyboard: false
          });
        }
      </script>
  @endsection