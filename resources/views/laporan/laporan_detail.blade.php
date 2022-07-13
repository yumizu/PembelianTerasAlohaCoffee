@extends('layouts.layout')
@section('content')
@include('sweetalert::alert')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Jurnal</h1>
</div>
<hr>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th width="15%">No Jurnal</th>
                        <th width="30%">Keterangan</th>
                        <th>Tanggal</th>
                        <th>No Akun</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jurnal as $item)
                    <tr>
                        <td>{{$item->no_jurnal}}</td>
                        <td>{{$item->keterangan}}</td>
                        <td>{{$item->tgl_jurnal}}</td>
                        <td>{{$item->no_akun}}</td>
                        <td>{{$item->debet}}</td>
                        <td>{{$item->kredit}}</td>
                        <td>
                            @if ($item->keterangan != 'Kas')
                                <a href="/laporan/detail/{{ $item->id }}/barang" class="btn btn-primary">Lihat Barang</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection