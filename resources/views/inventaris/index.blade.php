@extends('layouts.app')

@push('style')
<style>
    /* Tambahan agar tabel terlihat lebih lega di layar lebar */
    .card .table td,
    .card .table th {
        padding-right: 1.5rem;
        padding-left: 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Daftar Inventaris & Peminjaman</h6>
                <!-- Link menuju halaman tambah peminjaman -->
                <a href="{{ route('peminjaman.create') }}" class="btn btn-primary btn-sm mb-0">Tambah Peminjaman</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Barang</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Peminjam</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tgl Pinjam</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tgl Kembali</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjaman as $pinjam)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center border-radius-md">
                                                <i class="ni ni-laptop text-white opacity-10"></i>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <!-- Menampilkan nama barang -->
                                            <h6 class="mb-0 text-sm">{{ $pinjam->barang?->name ?? 'Barang Dihapus' }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $pinjam->barang?->category?->name ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <!-- Menampilkan nama peminjam -->
                                    <p class="text-xs font-weight-bold mb-0">{{ $pinjam->user?->name ?? 'User Dihapus' }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <!-- Badge status yang menyesuaikan dengan database -->
                                    @if($pinjam->status == 'dipinjam')
                                        <span class="badge badge-sm bg-gradient-warning">Dipinjam</span>
                                    @elseif($pinjam->status == 'dikembalikan')
                                        <span class="badge badge-sm bg-gradient-success">Dikembalikan</span>
                                    @elseif($pinjam->status == 'rusak')
                                        <span class="badge badge-sm bg-gradient-danger">Rusak</span>
                                    @elseif($pinjam->status == 'hilang')
                                        <span class="badge badge-sm bg-gradient-secondary">Hilang</span>
                                    @else
                                        <span class="badge badge-sm bg-gradient-info">{{ ucfirst($pinjam->status) }}</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($pinjam->tanggal_peminjaman)->format('d/m/Y') }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($pinjam->tanggal_pengembalian)->format('d/m/Y') }}</span>
                                </td>
                                <td class="align-middle">
                                    <!-- Form untuk mengubah status menjadi dikembalikan/rusak/hilang -->
                                    @if($pinjam->status == 'dipinjam')
                                        <form action="{{ route('peminjaman.updateStatus', $pinjam->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-select form-select-sm d-inline w-auto" required style="min-width: 120px;">
                                                <option value="" disabled selected>Pilih Status...</option>
                                                <option value="dikembalikan">Normal (Kembali)</option>
                                                <option value="rusak">Rusak</option>
                                                <option value="hilang">Hilang</option>
                                            </select>
                                            <button type="submit" class="btn btn-xs btn-success mb-0 ms-1">Simpan</button>
                                        </form>
                                    @else
                                        <!-- Jika sudah dikembalikan, tidak perlu form lagi -->
                                        <span class="text-xs text-secondary font-weight-bold">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <p class="text-sm mb-0">Belum ada data peminjaman.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
@endpush
