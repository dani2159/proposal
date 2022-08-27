@extends('Template.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Beranda</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-clock text-white" style="font-size: 50px;"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Menunggu Persetujuan</span>
                    <span class="info-box-number">{{ $menunggu }}</span>
                </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-times text-white" style="font-size: 50px;"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Ditolak</span>
                    <span class="info-box-number">{{ $ditolak }}</span>
                </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check text-white" style="font-size: 50px;"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Disetujui</span>
                    <span class="info-box-number">{{ $disetujui }}</span>
                </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fa fa-book text-white" style="font-size: 50px;"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Pengajuan</span>
                    <span class="info-box-number">{{ $menunggu + $ditolak + $disetujui }}</span>
                </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  @endsection