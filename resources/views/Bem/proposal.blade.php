@extends('Template.app')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pengajuan Ormawa</h1>
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
        <div class="card">
          <div class="card-body">
            <table class="table" id="dataTable">
              <thead>
                <tr>
                    <th>#</th>
                    <th>Ormawa</th>
                    <th>Nama Kegiatan</th>
                    <th>Jenis Kegiatan</th>
                    <th>Tanggal Kegiatan</th>
                    <th>Total Dana</th>
                    <th>Status</th>
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
                          <td>{{Global_lib::rupiah($item->total_dana)}} </td>
                          <td>{!! $status !!} </td>
                          <td>
                            <a href="{{ route('pengajuan.detail', ['id' => $item->id]) }}" class="btn btn-primary btn-sm"><span class="fa fa-eye"></span></a>
                          </td>
                      </tr>
                  @endforeach
                </tbody>
            </table>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
@endsection

@section('script')
  <script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            order: [
                [0, "asc"]
            ],
            columnDefs: [{
                "targets": 7,
                "orderable": false
            }]
        });
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
  </script>
@endsection