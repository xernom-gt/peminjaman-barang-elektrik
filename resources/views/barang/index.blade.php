@extends('layouts.app')

@push('style')
<style>
    .card .table td,
    .card .table th {
        padding-right: 1.5rem;
        padding-left: 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <!-- Header Card dengan Search & Tombol Tambah -->
                <div class="card-header border-0 d-flex justify-content-between align-items-center flex-wrap">
                    <h3 class="mb-0">Daftar Barang</h3>
                    
                    <div class="d-flex mt-3 mt-md-0">
                        <!-- Form Pencarian -->
                        <form action="{{ route('barang.index') }}" method="GET" class="d-flex me-3">
                            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari nama barang..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-sm btn-outline-primary mb-0">Cari</button>
                        </form>

                        <!-- Tombol Tambah Barang (Buka Modal) - Hanya untuk Admin -->
                        @if(Auth::check() && Auth::user()->role_id == 1)
                        <button type="button" class="btn btn-sm btn-primary mb-0" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fas fa-plus me-1"></i> Tambah Barang
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Tampilkan Notifikasi -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show text-white mx-4" role="alert">
                        <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                        <span class="alert-text"><strong>Berhasil!</strong> {{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show text-white mx-4" role="alert">
                        <span class="alert-text"><strong>Gagal!</strong> {{ session('error') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort">No</th>
                                <th scope="col" class="sort">Nama Barang</th>
                                <th scope="col" class="sort">Kategori</th>
                                <th scope="col" class="sort">Stok</th>
                                <th scope="col" class="sort text-center">Status</th>
                                @if(Auth::check() && Auth::user()->role_id == 1)
                                <th scope="col" class="sort text-center">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="list">
                            @forelse($barang as $item)
                            <tr>
                                <td>
                                    <span class="text-sm font-weight-bold">{{ $loop->iteration }}</span>
                                </td>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm font-weight-bold">{{ $item->name }}</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <!-- Nullsafe operator untuk menghindari error jika kategori dihapus -->
                                    <span class="text-sm">{{ $item->category?->name ?? 'Kategori Dihapus' }}</span>
                                </td>
                                <td>
                                    <span class="text-sm font-weight-bold">{{ $item->stock }}</span>
                                </td>
                                <td class="text-center">
                                    <!-- Badge Warna untuk Status -->
                                    @if($item->status == 'tersedia')
                                        <span class="badge bg-warning text-dark">Tersedia</span>
                                    @elseif($item->status == 'dipinjam')
                                        <span class="badge bg-info">Dipinjam</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $item->status }}</span>
                                    @endif
                                </td>
                                
                                @if(Auth::check() && Auth::user()->role_id == 1)
                                <td class="text-center">
                                    <!-- Tombol Edit (Buka Modal Edit) -->
                                    <button type="button" class="btn btn-sm btn-info mb-0" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                        Edit
                                    </button>
                                    <!-- Tombol Hapus (Buka Modal Delete) -->
                                    <button type="button" class="btn btn-sm btn-danger mb-0" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                        Hapus
                                    </button>
                                </td>
                                @endif
                            </tr>

                            <!-- Modal Edit Barang -->
                            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Barang</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('barang.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body text-start">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Barang</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Kategori</label>
                                                    <select name="category_id" class="form-select" required>
                                                        @foreach($categories as $cat)
                                                            <option value="{{ $cat->id }}" {{ $item->category_id == $cat->id ? 'selected' : '' }}>
                                                                {{ $cat->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Stok</label>
                                                    <input type="number" name="stock" class="form-control" value="{{ $item->stock }}" min="0" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-select" required>
                                                        <option value="tersedia" {{ $item->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                        <option value="dipinjam" {{ $item->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Delete Barang -->
                            <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('barang.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body text-start">
                                                Apakah Anda yakin ingin menghapus barang <strong>{{ $item->name }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Data barang tidak ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer py-4">
                    <!-- Pagination info -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create Barang -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Barang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="modal-body text-start">
                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan nama barang..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="category_id" class="form-select" required>
                            <option value="" disabled selected>Pilih Kategori...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stock" class="form-control" value="1" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="tersedia" selected>Tersedia</option>
                            <option value="dipinjam">Dipinjam</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
@endpush