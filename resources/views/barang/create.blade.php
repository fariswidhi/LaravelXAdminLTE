@extends('index')

@section('content-header')
  {{-- expr --}}
     @component('main.title')
      @slot('title')
          Kategori
      @endslot
      @slot('subtitle')
          Tambah Data
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
              <form action="{{url(Request::segment(1))}}" method="post">
                <div class="row" style="margin-left: 0;margin-right: 0;">
                  <div class="col-lg-6">      
                {{csrf_field()}}
                {{method_field('POST')}}
                @foreach ($data as $d)
                  {{-- expr --}}
                    <div class="form-group">
                      <label>{{$d['name']}}</label><br>

                      @if ($d['type']=='text' || $d['type']=='date'|| $d['type']=='number' || $d['type']=='password'|| $d['type']=='email')
                        {{-- expr --}}
                        <input type="{{$d['type']}}" name="{{$d['field']}}" class="form-control {{$d['class']}}">
                      @elseif($d['type']=='select')

                      @php
                        $id = $d['id'];
                        $value = $d['value'];
                      @endphp
{{--                           {{$d['data']}} --}}
                        <select class="form-control {{$d['class']}}" name="{{$d['field']}}">
                          <option value="">Pilih Data</option>
                          @foreach ($d['data'] as $selectData)
                          <option value="{{$selectData->$id}}">{{$selectData->$value}}</option>
                            {{-- expr --}}
                          @endforeach
                        </select>
                      @endif
                    </div>
                @endforeach
                <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </div>

              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
@endsection