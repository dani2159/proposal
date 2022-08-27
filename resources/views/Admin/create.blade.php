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
                     <!-- Main content -->
                  <section class="content">
                      <div class="container-fluid">
                          <div class="row">
                      
                              <!-- left column -->
                              <div class="col-md-10">
                                  <!-- general form elements -->
                                  <div class="card card-primary">
                                  <div class="card-header">
                                      <h3 class="card-title">Pengajuan Proposal</h3>
                              </div>
                              <!-- /.card-header -->
                              <!-- form start -->
                              <form action="{{route('tambah-pengajuan')}}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field()}}
                                  <div class="card-body">
                                  <div class="form-group">
                                        <label">Ormawa</label>
                                        <select class="form-control" name="ormawa_id" id="ormawa_id">
                                          <option disable value> Ormawa </option>
                                          @foreach ($ormawa as $item)
                                          <option value="{{$item->id}}">{{$item->nama}}</option>
                                          @endforeach
                                        </select>
                                  </div>
                                  <div class="form-group">
                                      <label>Nama Kegiatan</label>
                                      <input type="text" class="form-control" name="nama_kegiatan">
                                  </div>
                                  @error('nama_kegiatan')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                  <div class="form-group">
                                      <label>Jenis Kegiatan</label>
                                      <input type="text" class="form-control" name="jenis_kegiatan">
                                  </div>
                                  @error('jenis_kegiatan')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                  <div class="form-group">
                                      <label>Tema Kegiatan</label>
                                      <input type="text" class="form-control" name="tema_kegiatan"></textarea>
                                  </div>
                                  @error('tema_kegiatan')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                  <div class="form-group">
                                      <label>Tanggal Kegiatan</label>
                                      <input type="datetime-local" class="form-control" name="tanggal_kegiatan"></textarea>
                                  </div>
                                  @error('tanggal_kegiatan')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                  <div class="form-group">
                                      <label >Total Dana</label>
                                      <input type="double" class="form-control" name="total_dana"></textarea>
                                  </div>
                                  @error('total_dana')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                  <div class="form-group">
                                      <label >Lampiran</label>
                                      <div class="input-group">
                                          <div class="input-group col-xs-12">
                                              <input type="file" name="lampiran" id="lampiran" class="form-control file-upload-info"  placeholder="Upload Berkas">
                                              <span class="input-group-append">
                                                  <button class="file-upload-browse btn btn-primary" type="button">Upload Proposal</button>
                                              </span>
                                          </div>
                                      </div>
                                  </div>
                                  @error('lampiran')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                  <div class="form-check">
                                      <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                      <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                  </div>
                                  <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </section>
              </div>
            <!-- /.card -->
                <p class="card-text">
                  Some quick example text to build on the card title and make up the bulk of the card's
                  content.
                </p>

                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
              </div>
            </div>
            </div><!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  @endsection