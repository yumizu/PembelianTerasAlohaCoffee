@extends('layouts.layout')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Laporan Stok Barang </h1>
</div>
<hr>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <a href="{{ route('cetak.stok') }}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm float-right ml-4">
                    <i class="fas fa-print fa-sm text-white-50"></i> Cetak Laporan
                </a>
                <thead class="thead-dark">
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Stok Awal</th>
                        <th>Beli</th>
                        <th>Retur</th>
                        <th>Stok Total (Stok+Beli-retur)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($data as $item):
                    ?>
                        <tr>
                            <td>{{ $item->kd_brg}}</td>
                            <td>{{ $item->nm_brg}}</td>
                            <td>{{ number_format($item->stok,0,',','.') }}</td>
                            <td>{{ number_format($item->beli,0,',','.') }}</td>
                            <td>{{ number_format($item->retur,0,',','.') }}</td>
                            <td>{{ number_format(($item->stok+$item->beli)-$item->retur) }}</td>
                        </tr>
                    <?php
                        endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</form>
@endsection
