<!DOCTYPE html>
<html>

<head>
	<title>Laporan Stok Barang</title>
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
				<h2>Laporan Stok<br>Teras Aloha Coffee Bogor</h2>
				<hr> </td>
		</tr>
	</table>
	<table class="table table-bordered" width="100%" align="center">
		<thead>
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
			@foreach($data as $item)
				<tr>
					<td>{{ $item->kd_brg}}</td>
					<td>{{ $item->nm_brg}}</td>
					<td>{{ number_format($item->stok,0,',','.') }}</td>
					<td>{{ number_format($item->beli,0,',','.') }}</td>
					<td>{{ number_format($item->retur,0,',','.') }}</td>
					<td>{{ number_format(($item->stok+$item->beli)-$item->retur) }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<div align="right">
		<h6>Tanda Tangan</h6>
		<br>
		<br>
		<h6>{{ Auth::user()->name }}</h6> </div>
</body>

</html>