@extends('index')

@section('content-header')
  {{-- expr --}}
     @component('main.title')
      @slot('title')
          oke
      @endslot
      @slot('subtitle')
          oke
      @endslot
    @endcomponent
@endsection
@section('content')

<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Title</h3>

              <div class="box-tools">
                <form action="" method="get">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="q" class="form-control pull-right" placeholder="Cari Data" value="{{Request::get('q')}}">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
                </form>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive ">
              <a href="{{Request::segment(1).'/create'}}" class="btn btn-primary">Tambah Data</a>
              <table class="table table-striped">
                <thead>
                  @foreach ($data as $d)
                    {{-- expr --}}
                    @if ($d['showAsTable'])
                    <th>{{$d['name']}}</th>
                    @endif
                  @endforeach
                  <th>Opsi</th>
                </thead>
                <tbody>
                  @foreach ($dataTable as $dt)
                    {{-- expr --}}
                    <tr>
                  @foreach ($data as $td)
                    {{-- expr --}}
                    @if ($td['showAsTable'])
                    <td>
                    @php
                    $obj = $td['field'];

                      echo $dt->$obj;
                    @endphp
                    </td>
                    @endif
                    <td>
                      <a href="{{Request::segment(1).'/'.$dt->id}}" class="btn btn-info btn-xs">Info</a>
                      <a href="{{Request::segment(1).'/'.$dt->id.'/edit'}}" class="btn btn-success btn-xs">Edit</a>
                      <form action="{{Request::segment(1).'/'.$dt->id}}" method="post" style="display: inline;">

                        {{method_field("DELETE")}}
                        {{csrf_field()}}
                        <button onclick="return confirm('Apakah Anda Ingin Menghapus Data Ini?')" class="btn btn-danger btn-xs">Hapus</button>
                      </form>
                    </td>
                  @endforeach

                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
@endsection