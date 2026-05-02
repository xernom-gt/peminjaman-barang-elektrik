<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_barang = Barang::count();
        $total_peminjaman = Peminjaman::count();
        
        // Asumsi status: 'dipinjam' dan 'dikembalikan'
        $sedang_dipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $dikembalikan = Peminjaman::where('status', 'dikembalikan')->count();

        // Ambil 4 aktivitas peminjaman terbaru, urutkan dari yang terbaru
        $aktivitas = Peminjaman::with(['user', 'barang'])
                                ->orderBy('updated_at', 'desc')
                                ->take(4)
                                ->get();

        return view('page.index', compact(
            'total_barang', 
            'total_peminjaman', 
            'sedang_dipinjam', 
            'dikembalikan', 
            'aktivitas'
        ));
    }
}
