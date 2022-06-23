@extends('layouts.layout') 
@section('content') 
@include('sweetalert::alert')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Transaksi Retur </h1> </div>
<hr>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered tablestriped" id="dataTable" width="100%" cellspacing="0">
				<thead class="thead-dark">
					<tr>
						<th width="15%">No Pemesanan</th>
						<th>Tanggal Pesan</th>
						<th>Total</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody> @foreach($pembelian as $beli)
					<tr>
						<td width="15%">{{ $beli->no_faktur }}</td>
						<td>{{ $beli->tgl_beli }}</td>
						<td>Rp. {{ number_format($beli->total_beli) }}</td>
						<td width="30%"> 
							<a href="{{url('/retur-beli/'.Crypt::encryptString($beli->no_faktur))}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadowsm"><i class="fas fa-recycle fa-sm text-white-50"></i> Retur</a> 
							<a no_faktur="{{$beli->no_faktur}}" href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                                <i class="fas fa-trash-alt fa-sm text-white-50"></i> Hapus
							</a>
						</td>
					</tr> @endforeach </tbody>
			</table>
		</div>
	</div>
</div>
</form> 

<script>
	var token = "{{ csrf_token() }}";
	$('a[no_faktur]').click(function(){
	var no_faktur = $(this).attr('no_faktur');
	$.ajax({
		url: '/retur/hapus',
		type: 'POST',
		dataType: 'json',
		data: {
			_token:token,
			no_faktur: no_faktur,
		},
		success: function(data){
			window.location = '{{ url("retur") }}';
		}
	});
	return false;
	});
</script>
@endsection