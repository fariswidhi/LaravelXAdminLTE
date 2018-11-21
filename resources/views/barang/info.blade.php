@extends('index')

@section('content-header')
  {{-- expr --}}
     @component('main.title')
      @slot('title')
          {{$title}}
      @endslot
      @slot('subtitle')
          {{$subtitle}}
      @endslot
    @endcomponent
@endsection
@section('content')

<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Detail </h3>

           
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive ">
              <form action="{{url(Request::segment(1).'/'.Request::segment(2))}}" method="post">
                <div class="row" style="margin-left: 0;margin-right: 0;">
                  <div class="col-lg-6">      
                {{csrf_field()}}
                {{method_field('PUT')}}
                @foreach ($data as $d)
                  {{-- expr --}}
                    <div class="form-group">
                      <label>{{$d['name']}}</label><br>
                        {{-- expr --}}
                        @php
                          $field = $d['field'];
                          $related = $d['related'];
                          $belongsTo = $d['belongsTo'];
                          $key = $d['key'];
                    // print_r($belongsTo);
                          if ($related){
                      // JIKA ADA DATA YANG JOIN
                            echo $table->$belongsTo->$key;
                          }

                    else{
                      echo $table->$field;

                    }

                        @endphp
{{--                         {{$table->$field}} --}}
                    
                    </div>
                @endforeach
                <button type="button" class="btn btn-success" onclick="window.history.go(-1)">Kembali</button>
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