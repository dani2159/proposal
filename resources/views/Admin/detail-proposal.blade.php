@extends('Template.app')

@section('content')
@php
    $status = "<span class='badge badge-warning'>Menunggu</span>";
    
    if ($item->status == 1) {
        $status = "<span class='badge badge-success'>Disetujui</span>";
    } else if($item->status == 2) {
        $status = "<span class='badge badge-danger'>Ditolak</span>";
    }

@endphp
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Detail Pengajuan Proposal</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h6><b>Ormawa</b></h6>
                    <p id="nama_kegiatan">{{ $item->ormawa->nama }}</p>
                </div>
                <div class="col-md-4">
                    <h6><b>Nama Kegiatan</b></h6>
                    <p id="nama_kegiatan">{{ $item->nama_kegiatan }}</p>
                </div>
                <div class="col-md-4">
                    <h6><b>Jenis Kegiatan</b></h6>
                    <p id="jenis_kegiatan">{{ $item->jenis_kegiatan }}</p>
                </div>
                <div class="col-md-4">
                    <h6><b>Tema Kegiatan</b></h6>
                    <p id="tema_kegiatan">{{ $item->tema_kegiatan }}</p>
                </div>
                <div class="col-md-4">
                    <h6><b>Tanggal Kegiatan</b></h6>
                    <p id="tanggal_kegiatan">{{ $item->tanggal_kegiatan }}</p>
                </div>
                <div class="col-md-4">
                    <h6><b>Total Dana</b></h6>
                    <p id="total_dana">{{ Global_lib::rupiah($item->total_dana) }}</p>
                </div>
                <div class="col-md-4">
                    <h6><b>Status</b></h6>
                    <p id="status">{!! $status !!}</p>
                </div>
                <div class="col-md-4">
                    <h6><b>Lampiran</b></h6>
                    <p id="lampiran"><a href="{{ asset('data_proposal/'.$item->lampiran) }}" download>{{ $item->lampiran }}</a></p>
                </div>
                <div class="col-md-4">
                    <h6><b>Tanggal Pengajuan</b></h6>
                    <p id="created_at">{{ $item->created_at }}</p>
                </div>
                @if ($item->status == 2)
                    <div class="col-md-4">
                        <h6><b>Keterangan Penolakan</b></h6>
                        <p id="created_at">{{ $item->note_reject }}</p>
                    </div>                  
                @endif
                <div class="col-md-4">
                    <h6><b>Lampiran LPJ</b></h6>
                    <p id="created_at"><a href="{{ asset('data_lpj/'.$item->lampiran_lpj) }}" download>{{ $item->lampiran_lpj }}</a></p>
                </div>  
            </div>
          </div>
        </div>

        @if ($item->id_parent)
            <div class="card">
                <div class="card-header">
                    Historical Pengajuan
                </div>
                <div class="card-body">
                    <table class="table" id="tableData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kegiatan</th>
                                <th>Jenis Kegiatan</th>
                                <th>Tema Kegiatan</th>
                                <th>Tanggal Kegiatan</th>
                                <th>Total Dana</th>
                                <th>Lampiran</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($item->parent as $key => $list)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $list->nama_kegiatan }}</td>
                                    <td>{{ $list->jenis_kegiatan }}</td>
                                    <td>{{ $list->tema_kegiatan }}</td>
                                    <td>{{ $list->tanggal_kegiatan }}</td>
                                    <td>{{ Global_lib::rupiah($list->total_dana) }}</td>
                                    <td><a href="{{ asset('data_proposal/'.$list->lampiran) }}" download="">{{ $list->lampiran }}</a></td>
                                    <td>{{ $list->note_reject }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

  <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rejectModalLabel">Masukan alasan penolakan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="javascript:void(0)" id="formReject">
            <input type="hidden" name="id" id="id" value="{{ $item->id }}" required>
            <div class="modal-body">
                <textarea name="note" class="form-control" id="note" cols="30" rows="5" required placeholder="Masukan alasan"></textarea>
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
  <script>
    $(document).ready(function() {
        $('#tableData').DataTable({
            order: [
                [0, "asc"]
            ],
            columnDefs: [{
                "targets": 7,
                "orderable": false
            }]
        });
        $('#formReject').on('submit', (function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('pengajuan.reject') }}",
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

    function formatRupiah(angka, prefix){
			var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function terima(id) {
        swal({
            title: "Apakah anda yakin ?",
            text: "Pengajuan ini akan diterima.",
            icon: "info",
            buttons: true,
            successMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    method: 'POST',
                    url: "{{ route('pengajuan.approve') }}",
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
  </script>
@endsection