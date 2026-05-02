<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Peminjaman;

class Barang extends Model
{
    //

    protected $table = 'barang';

    protected $fillable = [
        'category_id',
        'name',
        'stock',
        'status'

    ];

    protected function casts():array
    {
        return [
            'stock'    =>'integer',
            'status'    =>'string'
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}