@extends('layouts.app')

@push('style')
<style>
    .icon-shape i {
        font-size: 1.25rem;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Barang</p>
                            <h5 class="font-weight-bolder">
                                {{ number_format($total_barang) }}
                            </h5>
                            <p class="mb-0">
                                <span class="text-success text-sm font-weight-bolder">+55%</span>
                                since yesterday
                            </p>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                            <i class="ni ni-box-2 text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Peminjaman</p>
                            <h5 class="font-weight-bolder">
                                {{ number_format($total_peminjaman) }}
                            </h5>
                            <p class="mb-0">
                                <span class="text-success text-sm font-weight-bolder">+3%</span>
                                since last week
                            </p>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                            <i class="ni ni-delivery-fast text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Kembali</p>
                            <h5 class="font-weight-bolder">
                                {{ number_format($dikembalikan) }}
                            </h5>
                            <p class="mb-0">
                                <span class="text-danger text-sm font-weight-bolder">-2%</span>
                                since last quarter
                            </p>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                            <i class="ni ni-check-bold text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Sedang Dipinjam</p>
                            <h5 class="font-weight-bolder">
                                {{ number_format($sedang_dipinjam) }}
                            </h5>
                            <p class="mb-0">
                                <span class="text-success text-sm font-weight-bolder">+5%</span> than last month
                            </p>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                            <i class="ni ni-bell-55 text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-lg-7 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">Statistik Peminjaman</h6>
                <p class="text-sm mb-0">
                    <i class="fa fa-arrow-up text-success"></i>
                    <span class="font-weight-bold">4% more</span> in 2026
                </p>
            </div>
            <div class="card-body p-3">
                <div class="chart">
                    <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header pb-0 p-3">
                <h6 class="mb-0">Aktivitas Terbaru</h6>
            </div>
            <div class="card-body p-3">
                <ul class="list-group">
                    @forelse($aktivitas as $act)
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                <!-- Ikon bisa disesuaikan dengan jenis aktivitas -->
                                @if($act->status == 'dipinjam')
                                    <i class="ni ni-delivery-fast text-white opacity-10"></i>
                                @elseif($act->status == 'dikembalikan')
                                    <i class="ni ni-check-bold text-white opacity-10"></i>
                                @else
                                    <i class="ni ni-box-2 text-white opacity-10"></i>
                                @endif
                            </div>
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm">{{ $act->barang?->name ?? 'Barang Dihapus' }} <span class="badge bg-light text-dark">{{ ucfirst($act->status) }}</span></h6>
                                <span class="text-xs">Oleh {{ $act->user?->name ?? 'User Dihapus' }}, <span class="font-weight-bold">{{ $act->updated_at->diffForHumans() }}</span></span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="/peminjaman" class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></a>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item border-0 ps-0 mb-2 border-radius-lg text-center text-sm">
                        Belum ada aktivitas.
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

@endpush