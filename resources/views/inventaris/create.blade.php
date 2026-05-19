@extends('layouts.app')

@push('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Basic Select2 adjustments for Bootstrap */
    .select2-container .select2-selection--multiple {
        min-height: 48px;
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }
    
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        box-shadow: 0 0 0 3px rgba(94, 114, 228, 0.2) !important;
        border-color: #5e72e4 !important;
        transform: translateY(-2px);
        background-color: #ffffff;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background: linear-gradient(135deg, #5e72e4 0%, #825ee4 100%);
        border: none;
        color: white;
        border-radius: 0.25rem;
        padding: 4px 10px;
        margin-top: 8px;
        box-shadow: 0 2px 5px rgba(94, 114, 228, 0.3);
        transition: all 0.2s ease;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice:hover {
        transform: scale(1.05);
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: white;
        margin-right: 8px;
        border-right: 1px solid rgba(255, 255, 255, 0.2);
        padding-right: 5px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #ffc107;
        background: transparent;
    }
    .select2-container .select2-search--inline .select2-search__field {
        margin-top: 12px;
    }

    /* Interactive UI Elements */
    .interactive-form-card {
        border-radius: 1.2rem;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        border: 1px solid rgba(255, 255, 255, 0.4);
        background: linear-gradient(145deg, #ffffff, #f9fafc);
        animation: fadeIn 0.8s ease-out;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .interactive-form-card:hover {
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.98) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .form-control-interactive {
        border-radius: 0.5rem;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
        padding: 0.75rem 1rem;
    }

    .form-control-interactive:focus {
        box-shadow: 0 0 0 3px rgba(94, 114, 228, 0.2) !important;
        border-color: #5e72e4 !important;
        transform: translateY(-2px);
        background-color: #ffffff;
    }

    .form-label-interactive {
        font-weight: 600;
        color: #344767;
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    .form-group:hover .form-label-interactive,
    .mb-3:hover .form-label-interactive {
        color: #5e72e4;
    }

    .btn-gradient-primary {
        background: linear-gradient(135deg, #5e72e4 0%, #825ee4 100%);
        border: none;
        box-shadow: 0 4px 15px rgba(94, 114, 228, 0.4);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        color: white;
    }

    .btn-gradient-primary:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 25px rgba(94, 114, 228, 0.6);
        color: white;
    }

    .btn-outline-secondary-interactive {
        border: 2px solid #e9ecef;
        color: #8392ab;
        background: transparent;
        transition: all 0.3s ease;
    }

    .btn-outline-secondary-interactive:hover {
        background: #f8f9fa;
        color: #344767;
        border-color: #d2d6da;
        transform: translateY(-2px);
    }

    .card-header-gradient {
        background: transparent;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    .page-title-animated {
        background: linear-gradient(135deg, #344767, #5e72e4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        margin-bottom: 0;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10 col-12">
        <div class="card mb-4 interactive-form-card">
            <div class="card-header pb-3 pt-4 px-4 card-header-gradient">
                <div class="d-flex align-items-center">
                    <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle me-3">
                        <i class="ni ni-cart text-white opacity-10"></i>
                    </div>
                    <h5 class="page-title-animated">Buat Peminjaman Baru</h5>
                </div>
            </div>
            <div class="card-body p-4">
                <!-- Tampilkan pesan error jika validasi gagal atau stok habis -->
                @if(session('error'))
                    <div class="alert alert-danger text-white border-0 shadow-sm rounded-3">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger text-white border-0 shadow-sm rounded-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('peminjaman.store') }}" method="POST" class="mt-2">
                    @csrf
                    
                    <div class="mb-4 form-group">
                        <label for="barang_id" class="form-label form-label-interactive">Pilih Barang <span class="text-danger">*</span></label>
                        <!-- Dropdown hanya menampilkan barang yang tersedia (stok > 0) -->
                        <select class="form-select form-control-interactive" id="barang_id" name="barang_id[]" multiple="multiple" required>
                            @foreach($barang as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} - Stok: {{ $item->stock }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted mt-2 d-block"><i class="fas fa-info-circle me-1"></i> Ketik untuk mencari, dan Anda bisa memilih lebih dari satu barang sekaligus.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4 form-group">
                            <label for="tanggal_peminjaman" class="form-label form-label-interactive">Tanggal Peminjaman <span class="text-danger">*</span></label>
                            <!-- Menggunakan input date untuk tanggal -->
                            <input type="date" class="form-control form-control-interactive" id="tanggal_peminjaman" name="tanggal_peminjaman" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col-md-6 mb-4 form-group">
                            <label for="tanggal_pengembalian" class="form-label form-label-interactive">Rencana Pengembalian <span class="text-danger">*</span></label>
                            <!-- Menggunakan input date untuk pengembalian -->
                            <input type="date" class="form-control form-control-interactive" id="tanggal_pengembalian" name="tanggal_pengembalian" value="{{ date('Y-m-d', strtotime('+3 days')) }}" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-2 border-top">
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary-interactive mb-0 me-3 px-4">Batal</a>
                        <button type="submit" class="btn btn-gradient-primary mb-0 px-4">
                            <i class="fas fa-save me-2"></i> Simpan Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#barang_id').select2({
            placeholder: "Cari dan pilih barang yang ingin dipinjam...",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush
