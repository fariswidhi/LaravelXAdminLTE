<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang as Table;
use App\Kategori;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $dir = 'barang';
    protected $url = 'barang';

    public function searchForId($id, $array) {
   foreach ($array as $key => $val) {
       if ($val['uid'] === $id) {
           return $key;
       }
   }
   return null;
}


    public function forms(){

        $forms = [
    [
        'name'=>'Barang',
        'list'=>[
            'type'=>'text',
            'field'=>'nama',
            'showAsTable'=>true,
          ],

      ],[
        'name'=>'Kategori',
        'list'=>[
            'type'=>'select',
            'field'=>'kategori',
            'showAsTable'=>true,
            'data'=>Kategori::all(),
            'id'=>'id',
            'value'=>'kategori',
            'related'=>true,
            'belongsTo'=>'kategorine',
            'key'=>'kategori'
          ],

      ],
        ];

        return $forms;

    }

  public function fields(){

        $forms = $this->forms();
        $count = count($forms);

        // print_r($forms);
        // print_r($forms);
        $array = [];
        for ($i=0; $i < $count ; $i++) { 
            # code...
            $name  = $forms[$i]['name'];
            $list = $forms[$i]['list'];
            $type = $list['type'];
            $field = $list['field'];
            $showAsTable = $list['showAsTable'];

            // print_r($list);
            $class = array_key_exists('class', $list) ? $list['class']: ' ';
            $data = array_key_exists('data', $list) ? $list['data']: ' ';
            $id = array_key_exists('id', $list) ? $list['id']: ' ';
            $value = array_key_exists('value', $list) ? $list['value']: ' ';
            $related = array_key_exists('related', $list) ? $list['related']: false;
            $belongsTo = array_key_exists('belongsTo', $list) ? $list['belongsTo']: ' ';
            $key = array_key_exists('key', $list) ? $list['key']: ' ';

            // var_dump($class);
            // var_dump($list);
            // $class

            $array[] = [
                'name'=>$name,
                'type'=>$type,
                'field'=>$field,
                'class'=>$class,
                'showAsTable'=>$showAsTable,
                'data'=>$data,
                'id'=>$id,
                'value'=>$value,
                'related'=>$related,
                'belongsTo'=>$belongsTo,
                'key'=>$key
            ];

            // echo $forms[$i];

        }

        return $array;
  }

    public function index(Request $request)
    {
        //

        $data = $this->fields();
        // print_r($forms);
            // print_r($data);
        $title = "Daftar Data";
        $subtitle = "Barang ";

        if (!empty($request->q)) {
        $columns = ['nama','kategori'];
        
        $query = Table::select('*');
        
        foreach($columns as $column)
        {
            $query->orWhere($column, 'LIKE', '%'.$request->q.'%');
        }
        
        $dataTable = $query->get();

        }
        else{
                    $dataTable = Table::all();
        }
        return view($this->dir.'/table',compact('data','dataTable','title','subtitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = $this->fields();
        return view($this->dir.'/create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // UNTUK DUMP NAMA FORM

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request, $type untuk save/update,$table untuk Class nama tabel

     */

    public function dumpName($request,$type,$table){

        $text = '';
        if ($type=='save') {
            $text.= '$table = new '.$table."; <br>";
        }
        elseif ($type=='update') {
            $text .= '$table = '.$table.'::find($id); <br>';
        }
        foreach ($request as $r=>$v) {
            # code...
            // print_r($r);
            $text .= '$table->'.$r.'= $request->'.$r.";<br>";
            // echo $r."<br>";
        }

        $text .= '$save = $table->save();<br>';
        $text .= 'if ($save) {<br>';
        $text .= '//Do Your Something<br>';
        $text .= '}<br>';
        $text .= 'else {<br>';
        $text .= '//Do Your Something <br>';
        $text .= '}<br>';

        echo $text;


    }
    public function store(Request $request)
    {
        //
        $name = $this->dumpName($request->except(['_token','_method']),'save','Table');



        $table = new Table; 
        $table->nama= $request->nama;
        $table->kategori= $request->kategori;
        $save = $table->save();

        if ($save) {
        //Do Your Something
            $request->session()->flash('success', "Data Berhasil Disimpan");
            return redirect($this->url);
        }
        else {
        //Do Your Something 
            $request->session()->flash('success', "Data Gagal Disimpan");
            return redirect()->back();
        }

        // $table = new Table;
        // print_r($request->all());


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $data = $this->fields();
        $table = Table::find($id);
        $title = "Detail  Data";
        $subtitle = "Kategori";
        return view($this->dir.'/info',compact('data','table','title','subtitle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $data = $this->fields();
        $table = Table::find($id);

        $title = "Edit Data";
        $subtitle = "Kategori";
        return view($this->dir.'/edit',compact('data','table','title','subtitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $name = $this->dumpName($request->except(['_token','_method']),'update','Table');

        // INI ADALAH HASIL GENERATE DARI KODE DIATAS;
$table = Table::find($id); 
$table->nama= $request->nama;
$table->kategori= $request->kategori;
$save = $table->save();
        if ($save) {
        //Do Your Something
            $request->session()->flash('success', "Data Berhasil Diubah");
            return redirect($this->url);
        }
        else {
        //Do Your Something 
            $request->session()->flash('success', "Data Gagal Diubah");
            return redirect()->back();
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        //
        $table = Table::find($id);
        $delete = $table->delete();
         if ($delete) {
        //Do Your Something
            $request->session()->flash('success', "Data Berhasil Dihapus");
            return redirect($this->url);
        }
        else {
        //Do Your Something 
            $request->session()->flash('success', "Data Gagal Dihapus");
            return redirect()->back();
        }
    }
}
