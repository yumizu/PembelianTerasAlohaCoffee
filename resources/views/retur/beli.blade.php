@extends('layouts.layout')
@section('content')
@include('sweetalert::alert')
<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <h1 class="h3 mb-0 text-gray-800"> Pembelian </h1>
</div>
<hr>
<form action="/retur/simpan" method="POST">
    @csrf

    <div class="form-group col-sm-4">
        <label for="exampleFormControlInput1">No Retur</label>
        @foreach($kas as $ks)
            <input type="hidden" name="kas" value="{{ $ks->no_akun }}" class="form-control"
                id="exampleFormControlInput1">
        @endforeach
        @foreach($retur as $rtr)
            <input type="hidden" name="retur" value="{{ $rtr->no_akun }}" class="form-control"
                id="exampleFormControlInput1">
        @endforeach
        <input type="hidden" name="no_jurnal" value="{{ $formatj }}" class="form-control" id="exampleFormControlInput1">
        <input type="text" name="no_retur" value="{{ $format }}" class="form-control" id="exampleFormControlInput1"
            readonly>
    </div>
    <div class="form-group col-sm-4">
        <label for="exampleFormControlInput1">Tanggal Retur</label>
        <input type="date" min="1" name="tgl" id="addnmbrg" class="form-control" id="exampleFormControlInput1" require>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th align="center">Jumlah Barang Dibeli</th>
                            <th width=10%>Jumlah Retur</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    @if(count($beli) > 0)
                        <input name="no_beli" class="form-control" type="hidden" value="{{ $beli->first()->no_beli }}" readonly>
                    @endif
                    <tbody>
                        @php($total = 0)
                            @foreach($beli as $bli)
                                <tr>
                                    <td>
                                        <input name="kd_brg[]" class="form-control" type="hidden" value="{{ $bli->kd_brg }}" readonly>
                                        {{ $bli->kd_brg }}
                                    </td>
                                    <td>
                                        <input name="nm_brg[]" class="form-control" type="hidden" value="{{ $bli->nm_brg }}" readonly>
                                        {{ $bli->nm_brg }}
                                    </td>
                                    <td align="center">
                                        <input name="qty_beli[]" class="form-control" type="hidden" value="{{ $bli->qty_beli }}" readonly>
                                        <input name="harga[]" class="form-control" type="hidden" value="{{ $bli->harga }}" readonly>
                                        {{ $bli->qty_beli }}
                                    </td>
                                    <td width=10%>
                                        <input name="jml_retur[]" class="form-control" type="number" value="0">
                                    </td>
                                    <td align="center">
                                        <a href="/transaksi/hapus/{{ $bli->kd_brg }}"
                                            onclick="return confirm('Yakin Ingin menghapus data?')"
                                            class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                                            <i class="fas fa-trash-alt fa-sm text-white-50"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
            <p>
				@if (count($errors) > 0)
					<ul>
						@foreach($errors->all() as $error)
							<li class='text-danger'>{{ $error }}</li>
						@endforeach
					</ul>
				@endif
			</p>
            <input type="submit" class="btn btn-primary btn-send" value="Simpan Retur">
        </div>
    </div>
</form>
@endsection
