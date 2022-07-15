@extends('layouts.layout')
@section('content')
@include('sweetalert::alert')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Transaksi Pembelian </h1>
</div>
<hr>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th width="15%">No Pemesanan</th>
                        <th>Tanggal Pesan</th>
                        <th width="30%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pemesanan as $pesan)
                    <tr>
                        <td width="15%">{{ $pesan->no_pesan }}</td>
                        <td>{{ $pesan->tgl_pesan }}</td>
                        <td width="30%">
                            @role('admin')
                                <a href="{{url('/pembelian-beli/'.Crypt::encryptString($pesan->no_pesan))}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-edit fa-sm text-white-50"></i> Beli</a>
                                <a no_pesan="{{$pesan->no_pesan}}" href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                                <i class="fas fa-trash-alt fa-sm text-white-50"></i> Hapus</a>
                            @endrole
                            <a href="{{route('cetak.order_pdf',[Crypt::encryptString($pesan->no_pesan)])}}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
                                <i class="fas fa-print fa-sm text-white-50"></i> Cetak Permintaan Pembelian
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</form>
<script>
    var token = "{{ csrf_token() }}";
    $('a[no_pesan]').click(function(){
    var no_pesan = $(this).attr('no_pesan');
    $.ajax({
        url: '/deletepembelian',
        type: 'POST',
        dataType: 'json',
        data: {
            _token:token,
            no_pesan: no_pesan,
        },
        success: function(data){
            window.location = '{{ url("pembelian") }}';
        }
    });
    return false;
    });
</script>
@endsection