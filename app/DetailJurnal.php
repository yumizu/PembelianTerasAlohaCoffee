<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailJurnal extends Model
{
    protected $table = "detail_jurnal";
    protected $fillable = ['jurnal_id', 'no_jurnal', 'kd_brg', 'nm_brg', 'qty', 'subtotal'];

    public function jurnal()
    {
        return $this->belongsTo('App\Jurnal');
    }
}
