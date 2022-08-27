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
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                    <div class="card-header">
                        <div class="card-tools">
                            <a href="{{route('create')}}" class="btn btn-success">Mengajukan Proposal <i class="fas fa-plus-square"></i></a>
                        </div>  
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>Ormawa</th>
                                <th>Nama Kegiatan</th>
                                <th>Jenis Kegiatan</th>
                                <th>Tema Kegiatan</th>
                                <th>Tanggal Kegiatan</th>
                                <th>Total Dana</th>
                            </tr>
                            <tbody>
                              @foreach($data as $key => $item )
                                  <tr>
                                      <td>{{$key + 1}} </td>
                                      <td>{{$item->nama}} </td>
                                      <td>{{$item->nama_kegiatan}} </td>
                                      <td>{{$item->jenis_kegiatan}} </td>
                                      <td>{{$item->tema_kegiatan}} </td>
                                      <td>{{$item->tanggal_kegiatan}} </td>
                                      <td>{{$item->total_dana}} </td>
                                      <td>{{$item->status}} </td>
                                      <td>{{$item->tanggal_proses}} </td>
                                  </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  @endsection