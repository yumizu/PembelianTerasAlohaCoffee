<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //jika tidak di definisikan, maka primary akan terdetek id
    protected $primaryKey = 'kd_supp';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $table = "supplier";
        protected $fillable=['kd_supp','nm_supp','alamat','telepon'];
}
