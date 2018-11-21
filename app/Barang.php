<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    //
    protected $table = 'barang';
    public $timestamps = false;
    public function kategorine(){
    	return $this->belongsTo('App\Kategori','kategori');
    }
}
