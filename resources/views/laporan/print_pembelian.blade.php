<!DOCTYPE html>
<html>

<head>
	<title>Laporan Buku Besar</title>
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
				<h2>Laporan Pembelian<br>Teras Aloha Coffee Bogor</h2>
				<hr> </td>
		</tr>
	</table>
	<table class="table table-bordered" width="100%" align="center">
		<thead>
			<tr>
				<th>No Pemesanan</th>
				<th>Tanggal</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody> 
			@foreach($data as $item)
				<tr>
					<td>{{ $item->no_pesan }}</td>
					<td>{{ $item->tgl_pesan }}</td>
					<td>Rp{{ number_format($item->total) }}</td>
				</tr>
			@endforeach
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