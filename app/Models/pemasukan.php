<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pemasukan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'pemasukan';
    protected $primaryKey = 'id';
    protected $fillable = ['kode_pemasukan', 'id_jenis_pemasukan', 'id_donatur', 'jumlah_pemsukan', 'tanggal_pemasukan', 'upload'];

    public function jenis_pemasukan()
    {
        return $this->belongsTo(jenis_pemasukan::class, 'id_jenis_pemasukan');
    }

    public function donatur()
    {
        return $this->belongsTo(donatur::class, 'id_donatur');
    }
}
