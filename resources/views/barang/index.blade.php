@extends('layouts.app')

@push('style')
<style>
    /* Interactive Table Styling */
    .card .table td,
    .card .table th {
        padding-right: 1.5rem;
        padding-left: 1.5rem;
        transition: all 0.3s ease;
    }

    /* Container Animations */
    .interactive-card {
        border-radius: 1.2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.3);
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease;
        animation: fadeInUp 0.8s ease-out;
    }

    .interactive-card:hover {
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Table Rows Interaction */
    .table-row-interactive {
        transition: all 0.3s ease;
    }
    
    .table-row-interactive:hover {
        background-color: rgba(94, 114, 228, 0.04) !important;
        transform: scale(1.01) translateX(4px);
        box-shadow: -5px 5px 15px rgba(0,0,0,0.03);
        border-radius: 0.5rem;
        position: relative;
        z-index: 10;
    }

    /* Gradient Buttons */
    .btn-gradient-primary {
        background: linear-gradient(135deg, #5e72e4 0%, #825ee4 100%);
        border: none;
        box-shadow: 0 4px 15px rgba(94, 114, 228, 0.3);
        transition: all 0.3s ease;
        color: white !important;
        position: relative;
        overflow: hidden;
    }

    .btn-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(94, 114, 228, 0.5);
    }

    .btn-action-animated {
        transition: all 0.3s ease;
        border-radius: 0.5rem;
    }

    .btn-action-animated:hover {
        transform: scale(1.1) translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    /* Badges */
    .badge-animated {
        transition: all 0.3s ease;
        padding: 0.5em 1em;
        font-weight: 600;
        letter-spacing: 0.5px;
        border-radius: 20px;
    }

    .table-row-interactive:hover .badge-animated {
        transform: scale(1.05);
    }

    /* Header text */
    .page-title-gradient {
        background: linear-gradient(135deg, #344767, #5e72e4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        animation: fadeInDown 0.8s ease-out;
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Modals Enhancement */
    .modal-content-glass {
        border-radius: 1.5rem;
        border: 1px solid rgba(255,255,255,0.4);
        box-shadow: 0 25px 50px rgba(0,0,0,0.1);
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        animation: scaleIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes scaleIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .modal-header-gradient {
        border-bottom: 1px solid rgba(0,0,0,0.05);
        background: transparent;
    }

    .form-control-animated {
        transition: all 0.3s ease;
        border-radius: 0.5rem;
    }

    .form-control-animated:focus {
        box-shadow: 0 0 0 3px rgba(94, 114, 228, 0.2);
        border-color: #5e72e4;
        transform: translateY(-2px);
    }

    /* Search Input */
    .search-container {
        position: relative;
    }
    
    .search-input-animated {
        border-radius: 2rem;
        padding-left: 2.5rem;
        transition: all 0.4s ease;
        border: 1px solid #d2d6da;
        background-color: #f8f9fa;
        width: 200px;
    }

    .search-input-animated:focus {
        box-shadow: 0 0 15px rgba(94, 114, 228, 0.15);
        width: 280px;
        background-color: #ffffff;
        border-color: #5e72e4;
    }
    
    .search-icon-inside {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #adb5bd;
        transition: color 0.3s ease;
    }
    
    .search-input-animated:focus + .search-icon-inside {
        color: #5e72e4;
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card interactive-card">
                <!-- Header Card dengan Search & Tombol Tambah -->
                <div class="card-header border-0 d-flex justify-content-between align-items-center flex-wrap bg-transparent pt-4 pb-3">
                    <h3 class="mb-0 page-title-gradient">Daftar Barang & Inventaris</h3>
                    
                    <div class="d-flex mt-3 mt-md-0 align-items-center">
                        <!-- Form Pencarian -->
                        <form action="{{ route('barang.index') }}" method="GET" class="d-flex me-3 search-container">
                            <input type="text" name="search" class="form-control form-control-sm search-input-animated" placeholder="Cari nama barang..." value="{{ request('search') }}">
                            <i class="fas fa-search search-icon-inside"></i>
                            <button type="submit" class="btn btn-sm btn-outline-primary mb-0 ms-2" style="border-radius: 2rem;">Cari</button>
                        </form>

                        <!-- Tombol Tambah Barang (Buka Modal) - Hanya untuk Admin -->
                        @if(Auth::check() && Auth::user()->role_id == 1)
                        <button type="button" class="btn btn-sm btn-gradient-primary mb-0" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fas fa-plus me-1"></i> Tambah Barang
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Tampilkan Notifikasi -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show text-white mx-4 shadow-sm" role="alert" style="border-radius: 0.8rem;">
                        <span class="alert-icon"><i class="fas fa-check-circle fs-5 align-middle me-1"></i></span>
                        <span class="alert-text"><strong>Berhasil!</strong> {{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show text-white mx-4 shadow-sm" role="alert" style="border-radius: 0.8rem;">
                        <span class="alert-icon"><i class="fas fa-exclamation-triangle fs-5 align-middle me-1"></i></span>
                        <span class="alert-text"><strong>Gagal!</strong> {{ session('error') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive px-2 pb-3">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                <th scope="col" class="sort text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Barang</th>
                                <th scope="col" class="sort text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kategori</th>
                                <th scope="col" class="sort text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stok</th>
                                <th scope="col" class="sort text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                @if(Auth::check() && Auth::user()->role_id == 1)
                                <th scope="col" class="sort text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="list">
                            @forelse($barang as $item)
                            <tr class="table-row-interactive">
                                <td>
                                    <span class="text-sm font-weight-bold text-secondary">{{ $loop->iteration }}</span>
                                </td>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="icon icon-shape icon-sm me-3 bg-gradient-info shadow-info text-center rounded-circle">
                                            <i class="ni ni-box-2 text-white opacity-10"></i>
                                        </div>
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm font-weight-bold text-dark">{{ $item->name }}</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <!-- Nullsafe operator untuk menghindari error jika kategori dihapus -->
                                    <span class="text-sm text-secondary">{{ $item->category?->name ?? 'Kategori Dihapus' }}</span>
                                </td>
                                <td>
                                    <span class="text-sm font-weight-bold text-dark">{{ $item->stock }}</span>
                                </td>
                                <td class="text-center">
                                    <!-- Badge Warna untuk Status -->
                                    @if($item->status == 'tersedia')
                                        <span class="badge bg-gradient-success badge-animated shadow-sm">Tersedia</span>
                                    @elseif($item->status == 'dipinjam')
                                        <span class="badge bg-gradient-warning badge-animated shadow-sm text-white">Dipinjam</span>
                                    @else
                                        <span class="badge bg-gradient-secondary badge-animated shadow-sm">{{ $item->status }}</span>
                                    @endif
                                </td>
                                
                                @if(Auth::check() && Auth::user()->role_id == 1)
                                <td class="text-center">
                                    <!-- Tombol Edit (Buka Modal Edit) -->
                                    <button type="button" class="btn btn-sm bg-gradient-info mb-0 text-white btn-action-animated px-3" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                    <!-- Tombol Hapus (Buka Modal Delete) -->
                                    <button type="button" class="btn btn-sm bg-gradient-danger mb-0 text-white btn-action-animated px-3 ms-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                        <i class="fas fa-trash me-1"></i> Hapus
                                    </button>
                                </td>
                                @endif
                            </tr>

                            <!-- Modal Edit Barang -->
                            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content modal-content-glass">
                                        <div class="modal-header modal-header-gradient">
                                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Barang</h5>
                                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('barang.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body text-start px-4">
                                                <div class="mb-3">
                                                    <label class="form-label font-weight-bold text-dark">Nama Barang</label>
                                                    <input type="text" name="name" class="form-control form-control-animated" value="{{ $item->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label font-weight-bold text-dark">Kategori</label>
                                                    <select name="category_id" class="form-select form-control-animated" required>
                                                        @foreach($categories as $cat)
                                                            <option value="{{ $cat->id }}" {{ $item->category_id == $cat->id ? 'selected' : '' }}>
                                                                {{ $cat->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label font-weight-bold text-dark">Stok</label>
                                                    <input type="number" name="stock" class="form-control form-control-animated" value="{{ $item->stock }}" min="0" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label font-weight-bold text-dark">Status</label>
                                                    <select name="status" class="form-select form-control-animated" required>
                                                        <option value="tersedia" {{ $item->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                        <option value="dipinjam" {{ $item->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0 px-4 pb-4">
                                                <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-gradient-primary mb-0">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Delete Barang -->
                            <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content modal-content-glass">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title text-danger" id="deleteModalLabel{{ $item->id }}"><i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('barang.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body text-start px-4 py-4">
                                                Apakah Anda yakin ingin menghapus barang <strong>{{ $item->name }}</strong> dari inventaris? Tindakan ini tidak dapat dibatalkan.
                                            </div>
                                            <div class="modal-footer border-0 pt-0 px-4 pb-4">
                                                <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn bg-gradient-danger mb-0 text-white"><i class="fas fa-trash me-2"></i>Hapus Permanen</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <i class="ni ni-box-2 text-secondary mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                        <h6 class="text-secondary font-weight-normal">Data barang tidak ditemukan.</h6>
                                        @if(request('search'))
                                            <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-primary mt-2">Reset Pencarian</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer py-4 bg-transparent border-0">
                    <!-- Pagination info -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create Barang -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-glass">
            <div class="modal-header modal-header-gradient">
                <div class="d-flex align-items-center">
                    <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle me-3 icon-sm">
                        <i class="ni ni-fat-add text-white opacity-10"></i>
                    </div>
                    <h5 class="modal-title page-title-gradient mb-0" id="createModalLabel">Tambah Barang Baru</h5>
                </div>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="modal-body text-start px-4">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-dark">Nama Barang</label>
                        <input type="text" name="name" class="form-control form-control-animated" placeholder="Masukkan nama barang..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-dark">Kategori</label>
                        <select name="category_id" class="form-select form-control-animated" required>
                            <option value="" disabled selected>Pilih Kategori...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-dark">Stok</label>
                        <input type="number" name="stock" class="form-control form-control-animated" value="1" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-dark">Status</label>
                        <select name="status" class="form-select form-control-animated" required>
                            <option value="tersedia" selected>Tersedia</option>
                            <option value="dipinjam">Dipinjam</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gradient-primary mb-0"><i class="fas fa-save me-2"></i> Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    // Add staggered animation for table rows
    document.addEventListener("DOMContentLoaded", function() {
        const rows = document.querySelectorAll('.table-row-interactive');
        rows.forEach((row, index) => {
            row.style.animation = `fadeInUp 0.4s ease-out ${index * 0.08}s both`;
        });
    });
</script>
@endpush