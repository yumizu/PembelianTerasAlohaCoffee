<!DOCTYPE html>
<html>

<head>
	<title>Laporan Pembelian</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<style type="text/css">
	table tr td,
	table tr th {
		font-size: 10pt;
	}
	</style>
</head>

<body>
	<table class="table table-bordered" width="100%" align="center">
		<tr align="center">
			<td>
				<h2>Laporan Pembelian<br>Teras Aloha Coffee Bogor {{ $suffix_message }}</h2>
				<hr> </td>
		</tr>
	</table>
	<table class="table table-bordered" width="100%" align="center">
		<thead>
			<tr>
				<th>No Pemesanan</th>
				<th>Tanggal</th>
				<th>Detail Barang</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody> 
			@for ($i = 0; $i < count($data); $i++)
				<tr>
					<td>{{ $data[$i]->no_pesan }}</td>
					<td>{{ $data[$i]->tgl_pesan }}</td>
					<td>
						@php
							$total = 0
						@endphp
						@foreach ($details[$i] as $detail)
							@php
								$total += 1;
							@endphp
							{{$total}}. {{ $detail->nm_brg }} ({{ $detail->qty_pesan }}x Rp{{ number_format($detail->sub_total) }})<br>
						@endforeach
					</td>
					<td>Rp{{ number_format($data[$i]->total) }}</td>
				</tr>
			@endfor
			
		</tbody>
	</table>
	<div class="total mb-4" align="right">
		@php
			$total = 0;
			foreach($data as $item) {
				$total += $item->total;
			}
		@endphp
		<b>Total Harga: Rp{{ number_format($total) }}</b>
	</div>
	<div align="right">
		<h6>Tanda Tangan</h6>
		<br>
		<br>
		<h6>{{ Auth::user()->name }}</h6> </div>
</body>

</html>