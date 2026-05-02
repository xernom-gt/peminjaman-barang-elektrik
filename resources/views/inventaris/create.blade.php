@extends('layouts.app')

@push('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Basic Select2 adjustments for Bootstrap */
    .select2-container .select2-selection--multiple {
        min-height: 40px;
        border: 1px solid #d2d6da;
        border-radius: 0.5rem;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #5e72e4;
        border: none;
        color: white;
        border-radius: 0.25rem;
        padding: 2px 8px;
        margin-top: 6px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: white;
        margin-right: 5px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #f8f9fa;
        background: transparent;
    }
    .select2-container .select2-search--inline .select2-search__field {
        margin-top: 8px;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Tambah Peminjaman Baru</h6>
            </div>
            <div class="card-body">
                <!-- Tampilkan pesan error jika validasi gagal atau stok habis -->
                @if(session('error'))
                    <div class="alert alert-danger text-white">
                        {{ session('error') }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger text-white">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="barang_id" class="form-label">Pilih Barang</label>
                        <!-- Dropdown hanya menampilkan barang yang tersedia (stok > 0) -->
                        <select class="form-select" id="barang_id" name="barang_id[]" multiple="multiple" required>
                            @foreach($barang as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} - Stok: {{ $item->stock }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Ketik untuk mencari, dan Anda bisa memilih lebih dari satu barang sekaligus.</small>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
                        <!-- Menggunakan input date untuk tanggal -->
                        <input type="date" class="form-control" id="tanggal_peminjaman" name="tanggal_peminjaman" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_pengembalian" class="form-label">Tanggal Rencana Pengembalian</label>
                        <!-- Menggunakan input date untuk pengembalian -->
                        <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" value="{{ date('Y-m-d', strtotime('+3 days')) }}" required>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary mb-0 me-2">Batal</a>
                        <button type="submit" class="btn btn-primary mb-0">Simpan Peminjaman</button>
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
