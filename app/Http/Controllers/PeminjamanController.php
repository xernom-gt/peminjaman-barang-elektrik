<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data peminjaman user yang sedang login, atau semua jika belum login (untuk kemudahan testing)
        if (Auth::check()) {
            $peminjaman = Peminjaman::with(['user', 'barang'])->where('user_id', Auth::id())->get();
        } else {
            // Default load semua untuk mempermudah jika belum setting login
            $peminjaman = Peminjaman::with(['user', 'barang'])->get();
        }

        // Tampilkan ke view inventaris.index
        return view('inventaris.index', compact('peminjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya ambil barang yang stoknya lebih dari 0
        $barang = Barang::where('stock', '>', 0)->get();
        
        // Tampilkan halaman form peminjaman
        return view('inventaris.create', compact('barang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'barang_id'            => 'required|array',
            'barang_id.*'          => 'exists:barang,id',
            'tanggal_peminjaman'   => 'required|date',
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman'
        ]);

        // Wrap dalam DB transaction untuk keamanan
        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            foreach ($request->barang_id as $id) {
                // Cari barang yang akan dipinjam
                $barang = Barang::findOrFail($id);

                if ($barang->stock <= 0) {
                    \Illuminate\Support\Facades\DB::rollBack();
                    return back()->with('error', 'Stok barang ' . $barang->name . ' sedang kosong!');
                }

                // Buat data peminjaman
                Peminjaman::create([
                    // Gunakan ID user login, fallback ke ID 1 jika untuk tes
                    'user_id'              => Auth::check() ? Auth::id() : 1, 
                    'barang_id'            => $id,
                    'tanggal_peminjaman'   => $request->tanggal_peminjaman,
                    'tanggal_pengembalian' => $request->tanggal_pengembalian,
                    'status'               => 'dipinjam', // Status awal diset 'dipinjam'
                ]);

                // Kurangi stok barang
                $barang->stock -= 1;
                // Jika stok habis, ubah status barang
                if ($barang->stock == 0) {
                    $barang->status = 'dipinjam';
                }
                $barang->save();
            }

            \Illuminate\Support\Facades\DB::commit();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat meminjam barang: ' . $e->getMessage());
        }

        return redirect()->route('peminjaman.index')->with('success', 'Barang berhasil dipinjam!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, string $id)
    {
        // Validasi status kembalian (dikembalikan, rusak, hilang)
        $request->validate([
            'status' => 'required|in:dikembalikan,rusak,hilang'
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = $request->status;
        $peminjaman->save();

        // Update stok barang berdasarkan kondisi saat dikembalikan
        $barang = Barang::findOrFail($peminjaman->barang_id);
        
        if ($request->status === 'dikembalikan') {
            // Jika kembali normal, stok barang bertambah
            $barang->stock += 1;
            $barang->status = 'tersedia';
            $barang->save();
        }
        // Jika rusak atau hilang, stok dibiarkan (tidak ditambah)

        return redirect()->route('peminjaman.index')->with('success', 'Status peminjaman diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
