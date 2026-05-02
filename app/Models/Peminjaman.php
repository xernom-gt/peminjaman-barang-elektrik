<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Barang;

class Peminjaman extends Model
{
    //

    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'barang_id',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'status'
    ]; 

    protected function casts():array
    {
        return [
            'tanggal_peminjaman'    =>'date',
            'tanggal_pengembalian'    =>'date',
            'status'    =>'string',
    
        ];
    }

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}