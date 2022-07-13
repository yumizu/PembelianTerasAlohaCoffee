@extends('layouts.layout') 
@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">Laporan Transaksi Jurnal</div>
				<div class="card-body">
					<form action="/laporan/cetak" method="PUT" target="_blank"> 
                    @csrf
						<fieldset>
							<div class="form-group row">
								<div class="col-md-3">
									<label for="klasifikasi">Periode Jurnal</label>
									<input id="jenis" type="hidden" name="jenis" value="bukubesar" class="formcontrol">
									<select id="periode" name="periode" class="form-control">
										<option value="">--Pilih Periode Laporan--</option>
										<option value="All">Semua</option>
										<option value="periode">Per Periode</option>
										</select>
								</div>
								<div class="col-md-3">
									<label for="no_hp">Tanggal Awal</label>
									<input id="tglawal" type="date" name="tglawal" class="form-control"> </div>

								<div class="col-md-3">
									<label for="no_hp">Tanggal Akhir</label>
									<input id="tglakhir" type="date" name="tglakhir" class="form-control"> </div>
							</div>
							<div class="col-md-10">
								<input type="submit" class="btn btn-success btnsend" value="Cetak"> </div>
						</fieldset>
					</form>
				</div>
			</div>
			<br>
			<div class="card">
				<div class="card-header">Detail Jurnal</div>
				<div class="card-body">
					<div class="col-md-12">
						<label for="klasifikasi">No Jurnal</label>
						<div class="row">
							<div class="col-md-3">
								<select id="no_jurnal" name="no_jurnal" class="form-control no_jurnal">
									<option value="">--Pilih No Jurnal--</option>
									@foreach($no_jurnal as $no)
										<option value="{{ $no }}">{{ $no }}</option>
									@endforeach
								</select>
							</div>
							<div class="">
								<a id="detail" href="#" class="btn btn-success">Lihat Detail</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> 
<script>
	$(document).ready(function(){
        $("select.no_jurnal").change(function(){
			var selectedid  = $(".no_jurnal option:selected").val();
			selectedid = selectedid.replaceAll('/', '_');
            $("#detail").attr("href","/laporan/detail/" + selectedid);  //-----this will change href 
        });
    });
</script>
@endsection