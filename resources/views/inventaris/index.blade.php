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
        border-radius: 0.5rem;
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

    /* Select Status Animation */
    .form-select-animated {
        transition: all 0.3s ease;
        cursor: pointer;
        border-radius: 0.5rem;
        background-color: #f8f9fa;
        border: 1px solid #d2d6da;
    }
    .form-select-animated:hover, .form-select-animated:focus {
        border-color: #5e72e4;
        box-shadow: 0 0 0 0.2rem rgba(94, 114, 228, 0.25);
        background-color: #fff;
    }
    
    .icon-shape-animated {
        transition: all 0.4s ease;
    }
    .table-row-interactive:hover .icon-shape-animated {
        transform: rotate(15deg) scale(1.1);
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col-12">
            <div class="card interactive-card mb-4 shadow">
                <div class="card-header pb-3 pt-4 border-0 d-flex justify-content-between align-items-center bg-transparent flex-wrap">
                    <h3 class="mb-0 page-title-gradient"><i class="ni ni-bullet-list-67 me-2"></i>Daftar Peminjaman</h3>
                    
                    <div class="d-flex mt-3 mt-md-0 align-items-center">
                        <!-- Link menuju halaman tambah peminjaman -->
                        <a href="{{ route('peminjaman.create') }}" class="btn btn-sm btn-gradient-primary mb-0 px-4">
                            <i class="fas fa-plus me-1"></i> Peminjaman Baru
                        </a>
                    </div>
                </div>

                <!-- Tampilkan Notifikasi Jika Ada -->
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

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0 px-2 pb-3">
                        <table class="table align-items-center mb-0 table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Barang</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Peminjam</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tgl Pinjam</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tgl Kembali</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjaman as $pinjam)
                                <tr class="table-row-interactive">
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center rounded-circle icon-shape-animated">
                                                    <i class="ni ni-laptop text-white opacity-10"></i>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <!-- Menampilkan nama barang -->
                                                <h6 class="mb-0 text-sm font-weight-bold text-dark">{{ $pinjam->barang?->name ?? 'Barang Dihapus' }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $pinjam->barang?->category?->name ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Menampilkan nama peminjam -->
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-gradient-primary rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                <span class="text-white font-weight-bold text-xs">{{ strtoupper(substr($pinjam->user?->name ?? 'U', 0, 1)) }}</span>
                                            </div>
                                            <p class="text-sm font-weight-bold mb-0 text-dark">{{ $pinjam->user?->name ?? 'User Dihapus' }}</p>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <!-- Badge status yang menyesuaikan dengan database -->
                                        @if($pinjam->status == 'dipinjam')
                                            <span class="badge bg-gradient-warning badge-animated shadow-sm text-white">Dipinjam</span>
                                        @elseif($pinjam->status == 'dikembalikan')
                                            <span class="badge bg-gradient-success badge-animated shadow-sm">Dikembalikan</span>
                                        @elseif($pinjam->status == 'rusak')
                                            <span class="badge bg-gradient-danger badge-animated shadow-sm">Rusak</span>
                                        @elseif($pinjam->status == 'hilang')
                                            <span class="badge bg-gradient-secondary badge-animated shadow-sm">Hilang</span>
                                        @else
                                            <span class="badge bg-gradient-info badge-animated shadow-sm">{{ ucfirst($pinjam->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-sm font-weight-bold">{{ \Carbon\Carbon::parse($pinjam->tanggal_peminjaman)->format('d M Y') }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-sm font-weight-bold">{{ \Carbon\Carbon::parse($pinjam->tanggal_pengembalian)->format('d M Y') }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <!-- Form untuk mengubah status menjadi dikembalikan/rusak/hilang -->
                                        @if($pinjam->status == 'dipinjam')
                                            <form action="{{ route('peminjaman.updateStatus', $pinjam->id) }}" method="POST" class="d-inline-flex align-items-center">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-select form-select-sm form-select-animated" required style="min-width: 140px;">
                                                    <option value="" disabled selected>Pilih Status...</option>
                                                    <option value="dikembalikan">✅ Normal (Kembali)</option>
                                                    <option value="rusak">⚠️ Rusak</option>
                                                    <option value="hilang">❌ Hilang</option>
                                                </select>
                                                <button type="submit" class="btn btn-sm bg-gradient-success mb-0 ms-2 shadow-sm btn-action-animated px-3" data-bs-toggle="tooltip" title="Simpan Status">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                            </form>
                                        @else
                                            <!-- Jika sudah dikembalikan, tidak perlu form lagi -->
                                            <span class="badge bg-light text-secondary border"><i class="fas fa-check-double text-success me-1"></i> Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <i class="ni ni-box-2 text-secondary mb-3" style="font-size: 4rem; opacity: 0.3;"></i>
                                            <h5 class="text-secondary font-weight-normal mb-1">Belum ada data peminjaman saat ini.</h5>
                                            <p class="text-muted text-sm mb-4">Mulai mencatat transaksi peminjaman barang dengan menambahkan data baru.</p>
                                            <a href="{{ route('peminjaman.create') }}" class="btn btn-sm btn-gradient-primary btn-action-animated px-4">
                                                <i class="fas fa-plus me-1"></i> Buat Peminjaman Pertama
                                            </a>
                                        </div>
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
</div>
@endsection

@push('script')
<script>
    // Script tambahan untuk interaksi sederhana
    document.addEventListener("DOMContentLoaded", function() {
        const rows = document.querySelectorAll('.table-row-interactive');
        rows.forEach((row, index) => {
            row.style.animation = `fadeInUp 0.4s ease-out ${index * 0.08}s both`;
        });
        
        // Initialize tooltips if bootstrap is available
        if(typeof bootstrap !== 'undefined') {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        }
    });
</script>
@endpush
